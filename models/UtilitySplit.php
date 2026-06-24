<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property int $utility_bill_id
 * @property int $unit_id
 * @property int|null $tenant_id
 * @property float $allocated_amount
 * @property string $status
 */
class UtilitySplit extends ActiveRecord
{
    public static function tableName()
    {
        return 'utility_splits';
    }

    public function rules()
    {
        return [
            [['utility_bill_id', 'unit_id', 'allocated_amount', 'status'], 'required'],
            [['utility_bill_id', 'unit_id', 'tenant_id'], 'integer'],
            [['allocated_amount'], 'number'],
            [['status'], 'string', 'max' => 255],
            [['utility_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => UtilityBill::class, 'targetAttribute' => ['utility_bill_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tenant_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utility_bill_id' => 'Utility Bill ID',
            'unit_id' => 'Unit ID',
            'tenant_id' => 'Tenant ID',
            'allocated_amount' => 'Allocated Amount',
            'status' => 'Status',
        ];
    }

    public function getUtilityBill(): ActiveQuery
    {
        return $this->hasOne(UtilityBill::class, ['id' => 'utility_bill_id']);
    }

    public function getUnit(): ActiveQuery
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

    public function getTenant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'tenant_id']);
    }

    public static function insertSplit($bill_id, $unit_id, $tenant_id, $amount)
    {
        $model = new static();
        $model->utility_bill_id = $bill_id;
        $model->unit_id = $unit_id;
        $model->tenant_id = $tenant_id;
        $model->allocated_amount = $amount;
        $model->status = 'unpaid';

        return $model->save();
    }

    public static function insertSplitRow($utility_bill_id, $unit_id, $tenant_id, $allocated_amount)
    {
        $model = new static();
        $model->utility_bill_id = $utility_bill_id;
        $model->unit_id = $unit_id;
        $model->tenant_id = $tenant_id;
        $model->allocated_amount = $allocated_amount;
        $model->status = 'unpaid';

        return $model->save();
    }
}
