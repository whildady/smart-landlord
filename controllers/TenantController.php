<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Units;       // Hakikisha jina hili linaendana na model yako ya Units
use app\models\Properties;  // Hakikisha jina hili linaendana na model yako ya Properties

class TenantController extends Controller
{
    public $layout = 'main'; 

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'tenant';
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Kipengele cha Index (Ukurasa mkuu wenye Layout na Sidebar)
     */
    public function actionIndex()
    {
        $dashboardData = $this->getTenantData();

        return $this->render('index', [
            'data' => $dashboardData
        ]);
    }

    /**
     * Hii inafungua ruti ya tenant/panel
     */
    public function actionPanel()
    {
        $dashboardData = $this->getTenantData();

        return $this->render('panel', [
            'data' => $dashboardData
        ]);
    }

    /**
     * Helper Method: Inavuta data halisi kutoka Database kulingana na Tenant aliyelogin
     */
    private function getTenantData()
{
    $user = Yii::$app->user->identity;

    // Thamani za mwanzo (Fallback defaults) kama mtumiaji hana chumba bado
    $propertyName = 'Hujapangiwa Jengo';
    $unitNumber = 'N/A';
    $rentAmount = 'Tsh 0';
    $rentStatus = 'Pending';

    // 1. Angalia kama huyu user ana unit_id kwenye account yake
    if (!empty($user->unit_id)) {
        
        // 2. Vuta data za chumba kutoka table ya 'units' kwa kutumia hiyo unit_id
        $unit = (new \yii\db\Query())
            ->select(['*'])
            ->from('units')
            ->where(['id' => $user->unit_id])
            ->one();

        if ($unit) {
            $unitNumber = 'Room No. ' . $unit['unit_number'];
            $rentAmount = 'Tsh ' . number_format($unit['rent_amount']);
            $rentStatus = (strtolower($unit['status']) === 'paid') ? 'Paid' : 'Pending';

            // 3. Vuta jina la jengo kutoka table ya 'properties' kwa kutumia property_id iliyopo kwenye unit
            $property = (new \yii\db\Query())
                ->select(['name']) // Kama column ya jina inaitwa tofauti (mf. property_name), badilisha hapa
                ->from('properties') // Kama table inaitwa tofauti (mf. property), badilisha hapa
                ->where(['id' => $unit['property_id']])
                ->one();

            if ($property) {
                $propertyName = $property['name'];
            }
        }
    }

    return [
        'tenantName' => $user->name ?? 'Chayeka Gauley',
        'tenantEmail' => $user->email ?? 'tenant@smartlandlord.com',
        'propertyName' => $propertyName, // Sasa inatoka DB halisi kupitia unit_id ya user!
        'unitNumber' => $unitNumber,     // Sasa inatoka DB halisi!
        'rentAmount' => $rentAmount,     // Sasa inatoka DB halisi!
        'totalUtilities' => 'Tsh 15,000', 
        'rentStatus' => $rentStatus, 
        'dueDate' => 'Mst: July 01, 2026',
        'lukuToken' => '4502 - 1198 - 3847 - 2291',
        'utilityBills' => [
            ['name' => 'Ulinzi & Usafi', 'amount' => 'Tsh 15,000', 'status' => 'Pending', 'icon' => '🛡️'],
            ['name' => 'Maji (DAWASA)', 'amount' => 'Tsh 10,000', 'status' => 'Paid', 'icon' => '🚰'],
        ],
        'announcements' => [
            ['title' => 'Gatuzi la Maji Wikiendi', 'body' => 'Kutakuwa na maboresho ya miundombinu ya maji siku ya Jumamosi kuanzia asubuhi.', 'date' => 'Leo'],
            ['title' => 'Ulinzi Imara wa Sikukuu', 'body' => 'Kuelekea sikukuu, ulinzi umeimarishwa getini. Wageni wote lazima waandikishwe.', 'date' => 'Jana']
        ],
        'recentRequests' => [
            ['title' => 'Fereji la bafuni linavuja', 'date' => 'Siku 2 zilizopita', 'status' => 'In Progress', 'type' => 'Plumbing'],
        ]
    ];
}

 public function actionChat()
{
    $tenant_id = Yii::$app->user->id; // ID ya mpangaji aliyelogin

    // 1. Vuta unit_id ya huyu tenant aliyelogin sasa hivi
    $currentUser = (new \yii\db\Query())
        ->select(['unit_id'])
        ->from('users')
        ->where(['id' => $tenant_id])
        ->one();

    $landlord = null;
    if ($currentUser && $currentUser['unit_id']) {
        // 2. Mtafute landlord mwenye unit_id hiyo hiyo lakini role yake iwe 'landlord' au 'admin'
        $landlord = (new \yii\db\Query())
            ->select(['id', 'name'])
            ->from('users')
            ->where(['unit_id' => $currentUser['unit_id']])
            ->andWhere(['role' => 'landlord']) // Badilisha 'landlord' hapa kulingana na jina la role ya landlord kwenye mfumo wako
            ->one();
    }

    // Data za Sidebar
    $data = [
        'tenantName' => Yii::$app->user->identity->name ?? 'Tenant User',
        'tenantEmail' => Yii::$app->user->identity->email ?? 'tenant@smartlandlord.com',
    ];

    return $this->render('messages', [
        'landlord' => $landlord,
        'data' => $data
    ]);
}
}