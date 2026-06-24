<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * @property int $id
 * @property int $property_id
 * @property string $bill_type
 * @property float $total_amount
 * @property float|null $net_amount
 * @property string $billing_period
 * @property string $split_method
 * @property string|null $vacant_handling
 * @property string $status
 * @property string|null $created_at
 */
class UtilityBill extends ActiveRecord
{
    public static function tableName()
    {
        return 'utility_bills';
    }

    public function rules()
    {
        return [
            [['property_id', 'bill_type', 'total_amount', 'billing_period', 'split_method'], 'required'],
            [['property_id'], 'integer'],
            [['total_amount', 'net_amount'], 'number'],
            [['bill_type', 'billing_period', 'split_method', 'vacant_handling', 'status'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'bill_type' => 'Bill Type',
            'total_amount' => 'Total Amount',
            'net_amount' => 'Net Amount',
            'billing_period' => 'Billing Period',
            'split_method' => 'Split Method',
            'vacant_handling' => 'Vacant Handling',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function getProperty(): ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    public function getSplits(): ActiveQuery
    {
        return $this->hasMany(UtilitySplit::class, ['utility_bill_id' => 'id']);
    }

    public static function getByLandlord($landlord_id)
    {
        return (new Query())
            ->select(['ub.*', 'p.name AS property_name'])
            ->from(['ub' => 'utility_bills'])
            ->innerJoin(['p' => 'properties'], 'ub.property_id = p.id')
            ->where(['p.landlord_id' => $landlord_id])
            ->orderBy(['ub.created_at' => SORT_DESC])
            ->all();
    }

    public static function createMasterBill($data)
    {
        $model = new static();
        $model->property_id = $data['property_id'];
        $model->bill_type = $data['bill_type'];
        $model->total_amount = $data['total_amount'];
        $model->net_amount = $data['net_amount'] ?? null;
        $model->billing_period = $data['billing_period'];
        $model->split_method = $data['split_method'];
        $model->vacant_handling = $data['vacant_handling'] ?? null;
        $model->status = $data['status'] ?? 'pending';

        if ($model->save()) {
            return $model->id;
        }

        return false;
    }

    public static function insertMasterBill($property_id, $bill_type, $total_amount, $billing_period, $split_method)
    {
        return static::createMasterBill([
            'property_id' => $property_id,
            'bill_type' => $bill_type,
            'total_amount' => $total_amount,
            'billing_period' => $billing_period,
            'split_method' => $split_method,
            'status' => 'pending',
        ]);
    }
}
