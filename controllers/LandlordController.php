<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\db\Query;
use app\models\Property;
use app\models\Unit;
use app\models\User;
use app\models\Invoice;
use app\models\UtilityBill;
use app\models\UtilitySplit;
use yii\widgets\ActiveForm;
use app\models\DocumentCloud;

class LandlordController extends Controller
{
    public $layout = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $user = Yii::$app->user->identity;
                            return $user && $user->role === 'landlord' && $user->status === 'active';
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-unit' => ['POST'],
                    'update-unit-status' => ['POST'],
                    'assign-tenant' => ['POST'],
                    'process-utility-split' => ['POST'],
                    'delete-bill' => ['POST'],
                    'delete-property' => ['POST'],
                    'delete-invoice' => ['POST'],
                    'update-profile-image' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['dashboard']);
    }

    public function actionDashboard()
{
    $landlordId = Yii::$app->user->id;
    $properties = $this->toObjects(Property::getPropertiesByLandlord($landlordId));
    $invoices = $this->toObjects(Invoice::getInvoicesByLandlord($landlordId));

    $totalProperties = count($properties);
    $totalUnits = 0;
    $occupiedUnits = 0;
    $vacantUnits = 0;

    foreach ($properties as $property) {
        $totalUnits += (int) ($property->total_units ?? 0);
        $units = $this->toObjects(Unit::getByProperty($property->id));

        foreach ($units as $unit) {
            if ($unit->status === 'occupied') {
                $occupiedUnits++;
            } elseif ($unit->status === 'vacant') {
                $vacantUnits++;
            }
        }
    }

    $collectedRent = 0;
    $pendingRent = 0;

    foreach ($invoices as $invoice) {
        if ($invoice->status === 'paid') {
            $collectedRent += (float) $invoice->amount;
        } elseif ($invoice->status === 'unpaid') {
            $pendingRent += (float) $invoice->amount;
        }
    }

    // 1. Pata matangazo yote yaliyo hai (Active Notices)
    $today = date('Y-m-d');
    $activeNotices = (new \yii\db\Query())
        ->select(['*'])
        ->from('notice_broadcasts')
        ->where(['>=', 'expiry_date', $today])
        ->orderBy(['created_at' => SORT_DESC])
        ->limit(3)
        ->all();

    // 2. Rudisha data zote kwenye render MOJA tu
    return $this->render('dashboard', [
        'total_properties' => $totalProperties,
        'total_units' => $totalUnits,
        'occupied_units' => $occupiedUnits,
        'vacant_units' => $vacantUnits,
        'collected_rent' => $collectedRent,
        'pending_rent' => $pendingRent,
        'activeNotices' => $activeNotices, // Hapa ndipo tunapoipeleka kwenye Dashboard
    ]);
}

    public function actionProperties()
    {
        $landlordId = Yii::$app->user->id;
        $properties = $this->toObjects(Property::getPropertiesByLandlord($landlordId));

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $data = [
                'properties' => $properties,
                'landlord_id' => $landlordId,
                'name' => trim((string) ($post['name'] ?? '')),
                'address' => trim((string) ($post['address'] ?? '')),
                'type' => trim((string) ($post['type'] ?? '')),
                'name_err' => '',
                'address_err' => '',
            ];

            if ($data['name'] === '') {
                $data['name_err'] = 'Please enter a property name';
            }
            if ($data['address'] === '') {
                $data['address_err'] = 'Please enter the property location/address';
            }

            if ($data['name_err'] === '' && $data['address_err'] === '') {
                if (Property::addProperty($data)) {
                    return $this->redirect(['properties']);
                }

                throw new \yii\web\ServerErrorHttpException('Something went wrong on the server side.');
            }

            return $this->render('properties', $data);
        }

        return $this->render('properties', [
            'properties' => $properties,
            'name' => '',
            'address' => '',
            'type' => '',
            'name_err' => '',
            'address_err' => '',
        ]);
    }

    public function actionUnits($property_id = null)
    {
        if ($property_id === null) {
            return $this->redirect(['properties']);
        }

        $property = Property::getPropertyById($property_id);

        if ($property === null || (int) $property->landlord_id !== (int) Yii::$app->user->id) {
            return $this->redirect(['properties']);
        }

        $units = $this->toObjects(Unit::getByProperty($property_id));
        $availableTenants = $this->toObjects(User::getAvailableTenants());

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $data = [
                'property' => $property,
                'units' => $units,
                'available_tenants' => $availableTenants,
                'property_id' => $property_id,
                'unit_number' => trim((string) ($post['unit_number'] ?? '')),
                'rent_amount' => trim((string) ($post['rent_amount'] ?? '')),
                'status' => trim((string) ($post['status'] ?? '')),
                'unit_number_err' => '',
                'rent_amount_err' => '',
            ];

            if ($data['unit_number'] === '') {
                $data['unit_number_err'] = 'Please enter unit number or name';
            }
            if ($data['rent_amount'] === '' || !is_numeric($data['rent_amount'])) {
                $data['rent_amount_err'] = 'Please enter a valid rent amount (numbers only)';
            }

            if ($data['unit_number_err'] === '' && $data['rent_amount_err'] === '') {
                if (Unit::addUnit($data)) {
                    return $this->redirect(['units', 'property_id' => $property_id]);
                }

                throw new \yii\web\ServerErrorHttpException('Something went wrong on the server side.');
            }

            return $this->render('units', $data);
        }

        return $this->render('units', [
            'property' => $property,
            'units' => $units,
            'available_tenants' => $availableTenants,
            'property_id' => $property_id,
            'unit_number' => '',
            'rent_amount' => '',
            'status' => 'vacant',
            'unit_number_err' => '',
            'rent_amount_err' => '',
        ]);
    }

    public function actionAssignTenant($unit_id = null)
    {
        if ($unit_id === null) {
            return $this->redirect(['properties']);
        }

        if (!Yii::$app->request->isPost) {
            return $this->redirect(['properties']);
        }

        $tenantId = trim((string) Yii::$app->request->post('tenant_id', ''));

        if ($tenantId === '') {
            return $this->redirect(['properties']);
        }

        $unit = Unit::findOne($unit_id);

        if ($unit === null || !$unit->assignTenant($tenantId)) {
            throw new \yii\web\ServerErrorHttpException('Critical Error: Failed to execute tenant placement.');
        }

        return $this->redirect(['units', 'property_id' => $unit->property_id]);
    }

    public function actionInvoices()
    {
        $landlordId = Yii::$app->user->id;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $tenantId = isset($post['tenant_id']) ? trim((string) $post['tenant_id']) : null;
            $unitId = isset($post['unit_id']) ? trim((string) $post['unit_id']) : null;

            if (empty($tenantId) && !empty($post['tenant_info']) && strpos($post['tenant_info'], '|') !== false) {
                $infoParts = explode('|', $post['tenant_info']);
                $tenantId = trim($infoParts[0]);
                $unitId = trim($infoParts[1]);
            }

            if (empty($tenantId) || empty($unitId)) {
                throw new \yii\web\BadRequestHttpException('Error: Cannot generate invoice. Invalid tenant or unit configuration.');
            }

            $data = [
                'tenant_id' => $tenantId,
                'unit_id' => $unitId,
                'amount' => trim((string) $post['amount']),
                'due_date' => trim((string) $post['due_date']),
                'billing_month' => trim((string) $post['billing_month']),
            ];

            if (Invoice::createInvoice($data)) {
                return $this->redirect(['invoices']);
            }

            throw new \yii\web\ServerErrorHttpException('Critical Error: Failed to write data into the ledger database.');
        }

        return $this->render('invoices', [
            'invoices' => $this->toObjects(Invoice::getInvoicesByLandlord($landlordId)),
            'active_tenants' => $this->toObjects(User::getActiveTenantsByLandlord($landlordId)),
        ]);
    }

    public function actionDeleteUnit($unit_id, $property_id)
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['units', 'property_id' => $property_id]);
        }

        $unit = Unit::findOne($unit_id);

        if ($unit === null || $unit->delete() === false) {
            throw new \yii\web\ServerErrorHttpException('Something went wrong while deleting the unit.');
        }

        return $this->redirect(['units', 'property_id' => $property_id]);
    }

    public function actionUpdateUnitStatus($unit_id, $property_id)
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['units', 'property_id' => $property_id]);
        }

        $status = trim((string) Yii::$app->request->post('status', ''));
        $unit = Unit::findOne($unit_id);

        if ($unit === null || !$unit->updateStatus($status)) {
            throw new \yii\web\ServerErrorHttpException('Failed to update status.');
        }

        return $this->redirect(['units', 'property_id' => $property_id]);
    }

    public function actionDeleteProperty($id)
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['properties']);
        }

        if (!Property::deleteProperty($id)) {
            throw new \yii\web\ServerErrorHttpException('Failed to delete property.');
        }

        return $this->redirect(['properties']);
    }

    public function actionMarkPaid($id)
    {
        $invoice = Invoice::findOne($id);

        if ($invoice !== null) {
            $invoice->status = 'paid';
            $invoice->save(false);
        }

        return $this->redirect(['invoices']);
    }

    public function actionDeleteInvoice($id)
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['invoices']);
        }

        $invoice = Invoice::findOne($id);

        if ($invoice === null || $invoice->delete() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to delete invoice.');
        }

        return $this->redirect(['invoices']);
    }

    public function actionUtilitySplitter()
    {
        $landlordId = Yii::$app->user->id;
        $properties = $this->toObjects(Property::getPropertiesByLandlord($landlordId));
        $bills = $this->toObjects(UtilityBill::getByLandlord($landlordId));

        $awaitingRow = (new Query())
            ->select(['total_awaiting' => 'SUM(s.allocated_amount)'])
            ->from(['s' => 'utility_splits'])
            ->innerJoin(['b' => 'utility_bills'], 's.utility_bill_id = b.id')
            ->innerJoin(['p' => 'properties'], 'b.property_id = p.id')
            ->where(['p.landlord_id' => $landlordId, 's.status' => 'unpaid'])
            ->one();

        $monthRow = (new Query())
            ->select(['total_month' => 'SUM(s.allocated_amount)'])
            ->from(['s' => 'utility_splits'])
            ->innerJoin(['b' => 'utility_bills'], 's.utility_bill_id = b.id')
            ->innerJoin(['p' => 'properties'], 'b.property_id = p.id')
            ->where(['p.landlord_id' => $landlordId])
            ->andWhere('MONTH(s.created_at) = MONTH(CURRENT_DATE())')
            ->andWhere('YEAR(s.created_at) = YEAR(CURRENT_DATE())')
            ->one();

        return $this->render('utility_splitter', [
            'properties' => $properties,
            'bills' => $bills,
            'awaiting_action' => $awaitingRow['total_awaiting'] ?? 0,
            'total_month' => $monthRow['total_month'] ?? 0,
            'unsplit_count' => 0,
        ]);
    }

    public function actionProcessUtilitySplit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            return ['success' => false, 'message' => 'Invalid request method.'];
        }

        $billReceipt = $this->uploadAndCompressReceipt('bill_receipt');

        if ($billReceipt === false) {
            return [
                'success' => false,
                'message' => 'Upload Failed: Image size is too large. Please upload an image under 2MB.',
            ];
        }

        $post = Yii::$app->request->post();
        $propertyId = trim((string) ($post['property_id'] ?? ''));
        $billType = trim((string) ($post['bill_type'] ?? ''));
        $totalAmount = (float) ($post['total_amount'] ?? 0);
        $netAmount = (float) ($post['net_amount'] ?? 0);
        $billingPeriod = trim((string) ($post['billing_period'] ?? ''));
        $splitMethod = trim((string) ($post['split_method'] ?? ''));
        $vacantHandling = trim((string) ($post['vacant_handling'] ?? ''));

        if ($propertyId === '') {
            return ['success' => false, 'message' => 'Please select a property first.'];
        }

        $unitsWithTenants = (new Query())
            ->select([
                'unit_id' => 'u.id',
                'u.unit_number',
                'tenant_user_id' => 'usr.id',
                'tenant_name' => 'usr.name',
                'tenant_email' => 'usr.email',
            ])
            ->from(['u' => 'units'])
            ->innerJoin(['usr' => 'users'], 'u.id = usr.unit_id')
            ->where([
                'u.property_id' => $propertyId,
                'usr.role' => 'tenant',
            ])
            ->andWhere(['usr.status' => 'active'])
            ->all();

        $occupiedUnits = count($unitsWithTenants);

        if ($occupiedUnits === 0) {
            return [
                'success' => false,
                'message' => 'Split Failed: No active tenants connected to units of Property ID: ' . $propertyId,
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            Yii::$app->db->createCommand()->insert('utility_bills', [
                'property_id' => $propertyId,
                'bill_type' => $billType,
                'total_amount' => $totalAmount,
                'net_amount' => $netAmount,
                'billing_period' => $billingPeriod,
                'split_method' => $splitMethod,
                'vacant_handling' => $vacantHandling,
                'bill_receipt' => $billReceipt,
            ])->execute();

            $utilityBillId = (int) Yii::$app->db->getLastInsertID();
            $tenantShareAmount = $totalAmount / $occupiedUnits;

            foreach ($unitsWithTenants as $tenant) {
                UtilitySplit::insertSplit(
                    $utilityBillId,
                    $tenant['unit_id'],
                    $tenant['tenant_user_id'],
                    $tenantShareAmount
                );
            }

            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Bill splitted successfully. Total Occupied Units: ' . $occupiedUnits,
            ];
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);

            return ['success' => false, 'message' => 'Failed to save the master bill into the database.'];
        }
    }

    public function actionDeleteBill($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            return ['success' => false, 'message' => 'Invalid request method.'];
        }

        $billId = (int) $id;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            Yii::$app->db->createCommand()
                ->delete('utility_splits', ['utility_bill_id' => $billId])
                ->execute();

            $deleted = Yii::$app->db->createCommand()
                ->delete('utility_bills', ['id' => $billId])
                ->execute();

            $transaction->commit();

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'The master bill record and its associated tenant splits have been completely removed.',
                ];
            }

            return ['success' => false, 'message' => 'Failed to delete the master bill from the database.'];
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);

            return ['success' => false, 'message' => 'Failed to delete the master bill from the database.'];
        }
    }

    public function actionUpdateProfileImage()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['dashboard']);
        }

        $uploadedFile = UploadedFile::getInstanceByName('profile_image');

        if ($uploadedFile !== null && !$uploadedFile->hasError) {
            $uploadFolder = Yii::getAlias('@webroot/uploads/profiles/');
            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0755, true);
            }

            $uniqueName = Yii::$app->user->id . '_' . time() . '.jpg';
            $destination = $uploadFolder . $uniqueName;

            if ($uploadedFile->saveAs($destination)) {
                Yii::$app->session->setFlash('success', 'Profile photo updated successfully.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['dashboard']);
    }

    public function actionUtilityBreakdown($billId)
    {
        $masterBill = (new Query())
            ->select(['ub.*', 'property_name' => 'p.name'])
            ->from(['ub' => 'utility_bills'])
            ->leftJoin(['p' => 'properties'], 'ub.property_id = p.id')
            ->where(['ub.id' => $billId])
            ->one();

        if ($masterBill === null) {
            return $this->redirect(['utility-splitter']);
        }

        $splits = (new Query())
            ->select([
                'us.*',
                'u.unit_number',
                'tenant_name' => 'usr.name',
                'tenant_email' => 'usr.email',
            ])
            ->from(['us' => 'utility_splits'])
            ->innerJoin(['u' => 'units'], 'us.unit_id = u.id')
            ->innerJoin(['usr' => 'users'], 'us.tenant_id = usr.id')
            ->where(['us.utility_bill_id' => $billId])
            ->all();

        return $this->render('utility_breakdown', [
            'title' => 'Utility Bill Breakdown',
            'bill' => (object) $masterBill,
            'splits' => $this->toObjects($splits),
        ]);
    }

    private function uploadAndCompressReceipt($fileField)
    {
        $uploadedFile = UploadedFile::getInstanceByName($fileField);

        if ($uploadedFile === null || $uploadedFile->hasError) {
            return null;
        }

        $maxSize = 2 * 1024 * 1024;
        if ($uploadedFile->size > $maxSize) {
            return false;
        }

        $uploadFolder = Yii::getAlias('@webroot/uploads/receipts/');
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0755, true);
        }

        $uniqueName = time() . '_' . bin2hex(random_bytes(4)) . '.jpg';
        $destination = $uploadFolder . $uniqueName;
        $fileType = $uploadedFile->type;

        if ($fileType === 'image/jpeg' || $fileType === 'image/jpg') {
            $sourceImage = imagecreatefromjpeg($uploadedFile->tempName);
        } elseif ($fileType === 'image/png') {
            $sourceImage = imagecreatefrompng($uploadedFile->tempName);
        } elseif ($fileType === 'image/gif') {
            $sourceImage = imagecreatefromgif($uploadedFile->tempName);
        } else {
            return null;
        }

        imagejpeg($sourceImage, $destination, 60);
        imagedestroy($sourceImage);

        return $uniqueName;
    }

    private function toObjects(array $rows): array
    {
        return array_map(static function ($row) {
            return is_object($row) ? $row : (object) $row;
        }, $rows);
    }

    // TENANTS
  public function actionTenants()
{
    // Disable default Yii2 layout to prevent HTML clashing
    $this->layout = false;
    $landlordId = Yii::$app->user->id;

    // Fetch tenants with their respective units and properties
    $rawTenants = (new \yii\db\Query())
        ->select([
            'tenant_id' => 'usr.id',
            'tenant_name' => 'usr.name',
            'tenant_email' => 'usr.email',
            'tenant_phone' => 'usr.phone', // Assumes you added 'phone' column to users table
            'tenant_status' => 'usr.status',
            'unit_number' => 'u.unit_number',
            'property_name' => 'p.name',
        ])
        ->from(['usr' => 'users'])
        ->innerJoin(['u' => 'units'], 'usr.unit_id = u.id')
        ->innerJoin(['p' => 'properties'], 'u.property_id = p.id')
        ->where([
            'usr.role' => 'tenant',
            'p.landlord_id' => $landlordId
        ])
        ->all();

    // Organize and group tenants by Property Name
    $groupedTenants = [];
    foreach ($rawTenants as $tenant) {
        $propertyName = $tenant['property_name'] ?? 'Unassigned Complex';
        $groupedTenants[$propertyName][] = $tenant;
    }

    // Render view file passing the premium grouped array matrix
    return $this->render('tenants', [
        'groupedTenants' => $groupedTenants,
    ]);
}

/**
 * Fetches a single tenant's data as JSON for AJAX views and edits.
 */
public function actionGetTenantDetails($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $tenant = (new \yii\db\Query())
        ->select(['usr.id', 'usr.name', 'usr.email', 'usr.phone', 'usr.status', 'usr.unit_id', 'u.unit_number', 'p.name AS property_name'])
        ->from(['usr' => 'users'])
        ->leftJoin(['u' => 'units'], 'usr.unit_id = u.id')
        ->leftJoin(['p' => 'properties'], 'u.property_id = p.id')
        ->where(['usr.id' => $id, 'usr.role' => 'tenant'])
        ->one();

    if ($tenant) {
        return ['success' => true, 'data' => $tenant];
    }
    return ['success' => false, 'message' => 'Tenant profile not discovered.'];
}

/**
 * Updates tenant details directly via POST from the interface modal.
 */
public function actionUpdateTenant($id)
{
    $request = Yii::$app->request;
    if ($request->isPost) {
        $db = Yii::$app->db;
        $db->createCommand()->update('users', [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'phone' => $request->post('phone'),
            'unit_id' => $request->post('unit_id'),
        ], 'id = :id AND role = "tenant"', [':id' => $id])->execute();

        Yii::$app->session->setFlash('success', 'Tenant records optimized successfully.');
    }
    return $this->redirect(['landlord/tenants']);
}

/**
 * Completely purges and evicts a tenant from the platform layout structure.
 */
public function actionDeleteTenant($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    // Clear unit assignment first before deleting to prevent foreign key errors
    Yii::$app->db->createCommand()
        ->update('users', ['unit_id' => null], 'id = :id', [':id' => $id])
        ->execute();
        
    $deleted = Yii::$app->db->createCommand()
        ->delete('users', 'id = :id AND role = "tenant"', [':id' => $id])
        ->execute();

    if ($deleted) {
        return ['success' => true, 'message' => 'Tenant profile successfully purged from database core.'];
    }
    return ['success' => false, 'message' => 'Failed to execute eviction purge routine.'];
}

/**
 * Registers a new tenant and associates them with a building unit.
 */
public function actionCreateTenant()
{
    $request = Yii::$app->request;
    if ($request->isPost) {
        $db = Yii::$app->db;
        
        // Suka password ya default (Mfano: tenant123) na uifanye iwe secured (Hashed)
        $defaultPassword = Yii::$app->security->generatePasswordHash('tenant123');

        $db->createCommand()->insert('users', [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'phone' => $request->post('phone'),
            'unit_id' => $request->post('unit_id'),
            'role' => 'tenant',
            'password' => $defaultPassword, // Watabadilisha wakilogin mara ya kwanza
            'status' => 'active',
        ])->execute();

        Yii::$app->session->setFlash('success', 'New leaseholder successfully registered.');
    }
    return $this->redirect(['landlord/tenants']);
}

// SOCIAL AUTH (Google & Apple)
public function actions()
{
    return [
        'auth' => [
            'class' => 'yii\authclient\AuthAction',
            'successCallback' => [$this, 'onAuthSuccess'],
        ],
    ];
}

// Hapa ndipo mtumiaji akisharuhusu Google/Apple, data zake zinasomwa na kuingizwa kwenye mfumo
public function onAuthSuccess($client)
{
    $attributes = $client->getUserAttributes();
    
    // Mfano wa kusoma data za Google:
    // $email = $attributes['email'];
    // $name = $attributes['name'];
    
    // Logic ya ku-login au ku-register mtumiaji kiotomatiki inaenda hapa...
}
public function actionChat()
{
    // Hakikisha mtumiaji ameshajisajili/ame-login kabla ya kuingia kwenye chat
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    // Kuvuta orodha ya wapangaji wote kutoka kwenye meza ya 'users'
    $tenants = (new \yii\db\Query())
        ->select([
            'id', 
            'name', 
            'email', 
            'phone', 
            'status', 
            'unit_id'
        ])
        ->from('users') // Jina la meza yako kama lilivyo kwenye database
        ->where(['role' => 'tenant']) // Inachuja na kuleta wapangaji tu
        ->andWhere(['status' => 1])   // (Hiari) Inaleta wapangaji walio active tu, kama unatumia 1 kumaanisha active
        ->orderBy('name ASC')         // Inapanga majina kuanzia A-Z
        ->all();

    // Inatuma data ya $tenants kwenda kwenye view ya 'chat.php'
    return $this->render('chat', [
        'tenants' => $tenants
    ]);
}

// 1. Kuvuta meseji kati ya Landlord (Mtumiaji aliyelogin) na Mpangaji aliyemchagua
public function actionFetchMessages($receiver_id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $sender_id = Yii::$app->user->id; // Landlord ID

    $messages = (new \yii\db\Query())
        ->select(['id', 'sender_id', 'receiver_id', 'message', 'file_path', 'created_at'])
        ->from('messages')
        ->where([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        ])
        ->orWhere([
            'sender_id' => $receiver_id,
            'receiver_id' => $sender_id
        ])
        ->orderBy('created_at ASC')
        ->all();

    return ['success' => true, 'messages' => $messages, 'current_user' => $sender_id];
}

// 2. Kutuma ujumbe mpya au Faili lililoambatishwa
public function actionSendMessage()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $request = Yii::$app->request;
    
    $sender_id = Yii::$app->user->id;
    $receiver_id = $request->post('receiver_id');
    $message_text = $request->post('message', '');
    $file_path = null;

    // Kushughulikia Upakiaji wa Faili (Attachment) kama lipo
    $uploadedFile = UploadedFile::getInstanceByName('attachment');
    if ($uploadedFile) {
        $directory = Yii::getAlias('@webroot/uploads/chats/');
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $fileName = time() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
        if ($uploadedFile->saveAs($directory . $fileName)) {
            $file_path = 'uploads/chats/' . $fileName;
            if (empty($message_text)) {
                $message_text = "Sent an attachment: " . $uploadedFile->baseName;
            }
        }
    }

    if (!empty($message_text) || $file_path) {
        Yii::$app->db->createCommand()->insert('messages', [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message_text,
            'file_path' => $file_path,
            'is_read' => 0
        ])->execute();

        return ['success' => true];
    }

    return ['success' => false, 'error' => 'Empty message'];
}
// Hakikisha jina liko hivi kabisa: actionCalendar
public function actionCalendar()
{
    return $this->render('calendar'); // Hakikisha faili la view linaitwa calendar.php
}

// 1. Action ya kuvuta matukio yote yaliyopo kwenye database
public function actionGetEvents()
{
    Yii::$app->response->format = Response::FORMAT_JSON;
    
    $events = (new \yii\db\Query())
        ->from('calendar_event')
        ->all();
        
    $formattedEvents = [];
    foreach ($events as $event) {
        $dateKey = $event['event_date']; // Hii inarudisha muundo wa YYYY-MM-DD
        
        // Kupanga muundo wa AM/PM kwa ajili ya kuonyesha kwenye kadi
        $startTime = $event['start_time'] ? date("h:i A", strtotime($event['start_time'])) : '';
        $endTime = $event['end_time'] ? date("h:i A", strtotime($event['end_time'])) : '';
        $timeRange = $startTime && $endTime ? "$startTime - $endTime" : "All Day";

        // Kupanga rangi za badge kulingana na aina uliyochagua
        $badgeClass = "bg-blue-50 text-blue-700";
        if (strtolower($event['badge']) === 'success') $badgeClass = "bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400";
        if (strtolower($event['badge']) === 'warning') $badgeClass = "bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400";
        if (strtolower($event['badge']) === 'danger') $badgeClass = "bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400";

        if (!isset($formattedEvents[$dateKey])) {
            $formattedEvents[$dateKey] = [];
        }

        $formattedEvents[$dateKey][] = [
            'title' => $event['title'],
            'time' => $timeRange,
            'desc' => $event['description'] ?? 'No description provided.',
            'badge' => $event['badge'],
            'badgeClass' => $badgeClass
        ];
    }

    return $formattedEvents;
}


// 2. Action ya kuhifadhi tukio jipya linalotumwa kutoka kwenye Form
public function actionCreateEvent()
{
    Yii::$app->response->format = Response::FORMAT_JSON;
    $request = Yii::$app->request;

    if ($request->isPost) {
        $title = $request->post('title');
        $date = $request->post('date');
        $startTime = $request->post('start_time');
        $endTime = $request->post('end_time');
        $badge = $request->post('badge');
        $description = $request->post('description');

        if (empty($title) || empty($date)) {
            return ['success' => false, 'message' => 'Title and Date are required.'];
        }

        $inserted = Yii::$app->db->createCommand()->insert('calendar_event', [
            'title' => $title,
            'event_date' => $date,
            'start_time' => $startTime ?: null,
            'end_time' => $endTime ?: null,
            'badge' => $badge,
            'description' => $description
        ])->execute();

        if ($inserted) {
            return ['success' => true, 'message' => 'Event created successfully.'];
        }
    }

    return ['success' => false, 'message' => 'Invalid request.'];
}





public function actionReports()
{
    // Mwaka wa sasa wa ripoti
    $currentYear = date('Y');

    // 1. KPI Data kutoka kwenye majedwali yako halisi
    $totalRevenue = (new \yii\db\Query())
        ->from('invoices')
        ->where(['status' => 'Paid'])
        ->sum('amount') ?: 0;

    $totalExpenses = (new \yii\db\Query())
        ->from('utility_bills')
        ->sum('total_amount') ?: 0;

    $expectedBilling = (new \yii\db\Query())
        ->from('invoices')
        ->sum('amount') ?: 0;

    $outstandingDebt = (new \yii\db\Query())
        ->from('invoices')
        ->where(['status' => ['Pending', 'Overdue']])
        ->sum('amount') ?: 0;

    // 2. Mwelekeo wa miezi 12 ya mwaka huu (Data ya Grafu Kuu)
    $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    $monthlyRevenue = [];
    $monthlyExpenses = [];

    foreach ($months as $m) {
        $yearMonth = $currentYear . "-" . $m;
        
        $rev = (new \yii\db\Query())
            ->from('invoices')
            ->where(['status' => 'Paid'])
            ->andWhere(['like', 'billing_month', $yearMonth])
            ->sum('amount') ?: 0;
            
        $exp = (new \yii\db\Query())
            ->from('utility_bills')
            ->andWhere(['like', 'billing_period', $yearMonth])
            ->sum('total_amount') ?: 0;

        $monthlyRevenue[] = (float)$rev;
        $monthlyExpenses[] = (float)$exp;
    }

    // 3. Mchanganuo wa Utility Category (Doughnut Chart)
    $utilityBreakdown = (new \yii\db\Query())
        ->select(['bill_type', 'SUM(total_amount) as total'])
        ->from('utility_bills')
        ->groupBy('bill_type')
        ->all();

    $pieLabels = [];
    $pieData = [];
    $totalBillsCount = 0;

    foreach ($utilityBreakdown as $ub) {
        $pieLabels[] = $ub['bill_type'];
        $pieData[] = (float)$ub['total'];
        $totalBillsCount += $ub['total'];
    }

    // Kama database iko tupu kabisa, weka data ya mfano isikae tupu kabisa mwanzo
    if (empty($pieData)) {
        $pieLabels = ['LUKU', 'Maji', 'Ulinzi'];
        $pieData = [0, 0, 0];
    }

    return $this->render('reports', [
        'totalRevenue' => (float)$totalRevenue,
        'totalExpenses' => (float)$totalExpenses,
        'expectedBilling' => (float)$expectedBilling,
        'outstandingDebt' => (float)$outstandingDebt,
        'monthlyRevenue' => json_encode($monthlyRevenue),
        'monthlyExpenses' => json_encode($monthlyExpenses),
        'pieLabels' => json_encode($pieLabels),
        'pieData' => json_encode($pieData),
        'totalBillsCount' => $totalBillsCount
    ]);
}

public function actionLeases()
{
    $request = Yii::$app->request;
    $currentDate = date('Y-m-d');
    $thirtyDaysLater = date('Y-m-d', strtotime('+30 days'));

    // 1. FORM SUBMISSION WITH FILE UPLOAD
    if ($request->isPost) {
        $tenantId = $request->post('tenant_id');
        $unitId = $request->post('unit_id');
        $startDate = $request->post('start_date');
        $endDate = $request->post('end_date');
        $rentAmount = (float)$request->post('rent_amount');
        $paymentCycle = $request->post('payment_cycle');
        $securityDeposit = (float)$request->post('security_deposit');
        
        $contractFile = null;
        if (isset($_FILES['scanned_contract']) && $_FILES['scanned_contract']['error'] == UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['scanned_contract']['name'], PATHINFO_EXTENSION);
            $contractFile = 'contract_' . time() . '.' . $ext;
            
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            move_uploaded_file($_FILES['scanned_contract']['tmp_name'], $uploadPath . $contractFile);
        }

        Yii::$app->db->createCommand()->insert('lease_agreements', [
            'tenant_id' => $tenantId,
            'unit_id' => $unitId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'rent_amount' => $rentAmount,
            'payment_cycle' => $paymentCycle,
            'security_deposit' => $securityDeposit,
            'scanned_contract' => $contractFile,
            'status' => 'Active',
            'created_at' => date('Y-m-d H:i:s'),
        ])->execute();

        Yii::$app->session->setFlash('success', 'Lease agreement created successfully.');
        return $this->redirect(['leases']);
    }

    // 2. REAL LIVE KPI CALCULATIONS
    $activeCount = (new \yii\db\Query())->from('lease_agreements')->where(['status' => 'Active'])->count();
    
    $expiringCount = (new \yii\db\Query())
        ->from('lease_agreements')
        ->where(['between', 'end_date', $currentDate, $thirtyDaysLater])
        ->andWhere(['status' => 'Active'])
        ->count();

    $terminatedCount = (new \yii\db\Query())->from('lease_agreements')->where(['status' => ['Expired', 'Terminated']])->count();

    // 3. FETCH LEASE LEDGER (FIXED: Using t.name instead of t.username)
    $leasesList = (new \yii\db\Query())
        ->select(['l.*', 'u.unit_number as unit_name', 't.name as tenant_name'])
        ->from('lease_agreements l')
        ->leftJoin('units u', 'u.id = l.unit_id')
        ->leftJoin('users t', 't.id = l.tenant_id')
        ->orderBy(['l.created_at' => SORT_DESC])
        ->all();

    // 4. DROPDOWN DATA SELECTORS
    $units = (new \yii\db\Query())->from('units')->all();
    $tenants = (new \yii\db\Query())->from('users')->all();

    return $this->render('leases', [
        'activeCount' => (int)$activeCount,
        'expiringCount' => (int)$expiringCount,
        'terminatedCount' => (int)$terminatedCount,
        'leasesList' => $leasesList,
        'units' => $units,
        'tenants' => $tenants
    ]);
}

public function actionMaintenance()
    {
        // 1. Leta Units zote kwa ajili ya fomu ya dropdown
        $units = Yii::$app->db->createCommand('SELECT id, unit_number FROM units')->queryAll();

        // 2. Leta kazi zilizogawanywa kulingana na Status zao (Kanban Logic)
        $newTasks = Yii::$app->db->createCommand(
            'SELECT m.*, u.unit_number FROM maintenance_tasks m 
             JOIN units u ON m.unit_id = u.id 
             WHERE m.status = "New Request" ORDER BY m.id DESC'
        )->queryAll();

        $progressTasks = Yii::$app->db->createCommand(
            'SELECT m.*, u.unit_number FROM maintenance_tasks m 
             JOIN units u ON m.unit_id = u.id 
             WHERE m.status = "In Progress" ORDER BY m.id DESC'
        )->queryAll();

        $resolvedTasks = Yii::$app->db->createCommand(
            'SELECT m.*, u.unit_number FROM maintenance_tasks m 
             JOIN units u ON m.unit_id = u.id 
             WHERE m.status = "Resolved" ORDER BY m.id DESC'
        )->queryAll();

        // 3. Piga hesabu ya jumla ya gharama zilizotumika (Resolved pekee)
        $totalExpenses = Yii::$app->db->createCommand(
            'SELECT SUM(estimated_cost) FROM maintenance_tasks WHERE status = "Resolved"'
        )->queryScalar() ?? 0;

        return $this->render('maintenance', [
            'units' => $units,
            'newTasks' => $newTasks,
            'progressTasks' => $progressTasks,
            'resolvedTasks' => $resolvedTasks,
            'totalExpenses' => $totalExpenses,
        ]);
    }

    /**
     * Inapokea na kuhifadhi ripoti mpya ya matengenezo
     */
    public function actionCreateMaintenanceTask()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            $unitId = $request->post('unit_id');
            $category = $request->post('category');
            $priority = $request->post('priority');
            $description = $request->post('description');
            $estimatedCost = $request->post('estimated_cost') ?? 0;
            $technicianName = $request->post('technician_name');
            $now = time();

            Yii::$app->db->createCommand()->insert('maintenance_tasks', [
                'unit_id' => $unitId,
                'category' => $category,
                'priority' => $priority,
                'description' => $description,
                'estimated_cost' => $estimatedCost,
                'technician_name' => $technicianName,
                'status' => 'New Request',
                'created_at' => $now,
                'updated_at' => $now,
            ])->execute();

            Yii::$app->session->setFlash('success', 'Maintenance task logged and dispatched successfully.');
            return $this->redirect(['maintenance']);
        }
    }
    public function actionNotices()
{
    $request = Yii::$app->request;

    // 1. SAVE NEW BROADCAST PROTOCOL
    if ($request->isPost) {
        $title = $request->post('title');
        $content = $request->post('content');
        $audience = $request->post('audience_type');
        $severity = $request->post('severity');
        $expiryDate = $request->post('expiry_date');
        
        // Convert channels array to string
        $channelsArr = $request->post('channels', []);
        $channelsStr = implode(',', $channelsArr);

        // Simulazione ya idadi ya walengwa (Tanzania context dynamic setup)
        $totalTarget = ($audience === 'All') ? 45 : 12; 

        Yii::$app->db->createCommand()->insert('notice_broadcasts', [
            'title' => $title,
            'content' => $content,
            'audience_type' => $audience,
            'severity' => $severity,
            'channels' => $channelsStr,
            'expiry_date' => $expiryDate,
            'total_target' => $totalTarget,
            'total_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ])->execute();

        Yii::$app->session->setFlash('success', 'Broadcast issued successfully through linked channels.');
        return $this->redirect(['notices']);
    }

    // 2. FETCH INTEGRATED NOTICES FEED
    $noticesList = (new \yii\db\Query())
        ->from('notice_broadcasts')
        ->orderBy(['created_at' => SORT_DESC])
        ->all();

    // 3. GENERATE ADVANCED ENGAGEMENT METRICS
    $totalSent = count($noticesList);
    $activeNotices = (new \yii\db\Query())->from('notice_broadcasts')->where(['>=', 'expiry_date', date('Y-m-d')])->count();
    
    return $this->render('notices', [
        'noticesList' => $noticesList,
        'totalSent' => $totalSent,
        'activeNotices' => $activeNotices
    ]);
}
// Ndani ya LandlordController.php
public function actionUploadDocument()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $model = new \app\models\DocumentCloud();
            $file = \yii\web\UploadedFile::getInstanceByName('document_file');

            if ($file) {
                // 1. Tengeneza folder la uploads kama halipo
                $uploadPath = Yii::getAlias('@webroot/uploads/documents/');
                if (!is_dir($uploadPath)) {
                    \yii\helpers\FileHelper::createDirectory($uploadPath, 0777, true);
                }

                // Kuzuia majina yanayofanana
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->baseName) . '.' . $file->extension;
                $filePath = $uploadPath . $fileName;

                // Save faili kwenye Hard Drive
                if ($file->saveAs($filePath)) {
                    // 2. Jaza data halisi kutoka kwenye fomu iliyoboreshwa
                    $model->landlord_id = Yii::$app->user->id;
                    $model->file_name = $file->name;
                    $model->file_path = 'uploads/documents/' . $fileName;
                    
                    // Sasa tunachukua data halisi zilizochaguliwa na mtumiaji
                    $model->file_category = $request->post('category', 'General');
                    $model->expiry_date = $request->post('expiry_date') ?: null;

                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Document uploaded successfully!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Database failed to save.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save file.');
                }
            }
        }
        
        return $this->redirect(Yii::$app->request->referrer ?: ['/landlord/documents']);
    }
    public function actionDocuments()
    {
        // 1. Hapa tunaita nyaraka zote kutoka kwenye database
        // Hakikisha model yako ya DocumentCloud imeshaleta data vizuri
        $documents = \app\models\DocumentCloud::find()
                        ->where(['landlord_id' => Yii::$app->user->id])
                        ->orderBy(['created_at' => SORT_DESC])
                        ->all();

        // 2. Tunairudisha kwenye view inayoitwa 'documents'
        return $this->render('documents', [
            'documents' => $documents,
        ]);
    }
    public function actionSettings()
{
    if (Yii::$app->request->isPost) {
        $data = Yii::$app->request->post('Setting');
        foreach ($data as $key => $value) {
            $setting = \app\models\SystemSettings::findOne(['setting_key' => $key]) 
                        ?? new \app\models\SystemSettings(['setting_key' => $key]);
            $setting->setting_value = $value;
            $setting->save();
        }
        Yii::$app->session->setFlash('success', 'System settings updated successfully!');
    }
    
    return $this->render('settings');
}

public function actionExpenses()
{
    $request = Yii::$app->request;

    // 1. Kushughulikia fomu pindi inapowasilishwa (Form Submission)
    if ($request->isPost) {
        $category = $request->post('category');
        $amount = (float)$request->post('amount');
        $propertyId = $request->post('property_id');
        $paymentMethod = $request->post('payment_method');
        $description = $request->post('description');
        $date = $request->post('expense_date') ?: date('Y-m-d');

        // Insert into database (Hakikisha jina la jedwali lako ni 'expenses' au ubadilishe hapa)
        Yii::$app->db->createCommand()->insert('expenses', [
            'category' => $category,
            'amount' => $amount,
            'property_id' => $propertyId,
            'payment_method' => $paymentMethod,
            'description' => $description,
            'expense_date' => $date,
            'status' => 'Paid', // au Pending kulingana na fomu
            'created_at' => date('Y-m-d H:i:s'),
        ])->execute();

        Yii::$app->session->setFlash('success', 'Gharama imerekodiwa kikamilifu!');
        return $this->redirect(['expenses']);
    }

    // 2. Mahesabu ya KPI (Real Live Data)
    $currentMonth = date('Y-m');
    
    $totalExpensesMonth = (new \yii\db\Query())
        ->from('expenses')
        ->where(['like', 'expense_date', $currentMonth])
        ->sum('amount') ?: 0;

    $pendingApprovals = (new \yii\db\Query())
        ->from('expenses')
        ->where(['status' => 'Pending'])
        ->sum('amount') ?: 0;

    // Operational Cost Ratio (Gharama vs Mapato ya Invoices)
    $totalRevenue = (new \yii\db\Query())->from('invoices')->where(['status' => 'Paid'])->sum('amount') ?: 1; // 1 kuzuia division by zero
    $costRatio = ($totalExpensesMonth / $totalRevenue) * 100;

    // 3. Orodha ya Gharama zote kwa ajili ya Jedwali (Transactions Table)
    $expensesList = (new \yii\db\Query())
        ->select(['e.*', 'p.name as property_name'])
        ->from('expenses e')
        ->leftJoin('properties p', 'p.id = e.property_id')
        ->orderBy(['e.expense_date' => SORT_DESC])
        ->all();

    // 4. Orodha ya Majengo kwa ajili ya Dropdown Selector kwenye Fomu
    $properties = (new \yii\db\Query())->from('properties')->all();

    // 5. Data ya Grafu ya Matumizi ya Miezi 12 (Graph Data)
    $currentYear = date('Y');
    $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    $graphData = [];
    foreach ($months as $m) {
        $graphData[] = (float)(new \yii\db\Query())
            ->from('expenses')
            ->where(['like', 'expense_date', $currentYear . '-' . $m])
            ->sum('amount') ?: 0;
    }

    return $this->render('expenses', [
        'totalExpensesMonth' => (float)$totalExpensesMonth,
        'pendingApprovals' => (float)$pendingApprovals,
        'costRatio' => round($costRatio, 1),
        'expensesList' => $expensesList,
        'properties' => $properties,
        'graphData' => json_encode($graphData)
    ]);
}
}
