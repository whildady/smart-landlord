<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * @property int $id
 * @property int $tenant_id
 * @property int $unit_id
 * @property float $amount
 * @property string $billing_month
 * @property string $due_date
 * @property string $status
 */
class Invoice extends ActiveRecord
{
    public static function tableName()
    {
        return 'invoices';
    }

    public function rules()
    {
        return [
            [['tenant_id', 'unit_id', 'amount', 'billing_month', 'due_date', 'status'], 'required'],
            [['tenant_id', 'unit_id'], 'integer'],
            [['amount'], 'number'],
            [['billing_month', 'due_date', 'status'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tenant_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenant_id' => 'Tenant ID',
            'unit_id' => 'Unit ID',
            'amount' => 'Amount',
            'billing_month' => 'Billing Month',
            'due_date' => 'Due Date',
            'status' => 'Status',
        ];
    }

    public function getUnit(): ActiveQuery
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

    public function getTenant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'tenant_id']);
    }

    public static function getInvoicesByLandlord($landlord_id)
    {
        return (new Query())
            ->select([
                'i.*',
                'u.unit_number',
                'p.name AS property_name',
                't.name AS tenant_name',
            ])
            ->from(['i' => 'invoices'])
            ->leftJoin(['u' => 'units'], 'i.unit_id = u.id')
            ->leftJoin(['p' => 'properties'], 'u.property_id = p.id')
            ->leftJoin(['t' => 'users'], 'i.tenant_id = t.id')
            ->where(['or',
                ['p.landlord_id' => $landlord_id],
                ['not', ['i.tenant_id' => null]],
            ])
            ->orderBy(['i.id' => SORT_DESC])
            ->all();
    }

    public static function createInvoice($data)
    {
        $model = new static();
        $model->tenant_id = $data['tenant_id'];
        $model->unit_id = $data['unit_id'];
        $model->amount = $data['amount'];
        $model->billing_month = $data['billing_month'];
        $model->due_date = $data['due_date'];
        $model->status = $data['status'] ?? 'unpaid';

        try {
            return $model->save();
        } catch (\Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return false;
        }
    }
}
