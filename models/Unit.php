<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * @property int $id
 * @property int $property_id
 * @property string $unit_number
 * @property float $rent_amount
 * @property string $status
 * @property int|null $tenant_id
 */
class Unit extends ActiveRecord
{
    public static function tableName()
    {
        return 'units';
    }

    public function rules()
    {
        return [
            [['property_id', 'unit_number', 'rent_amount', 'status'], 'required'],
            [['property_id', 'tenant_id'], 'integer'],
            [['rent_amount'], 'number'],
            [['unit_number', 'status'], 'string', 'max' => 255],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'unit_number' => 'Unit Number',
            'rent_amount' => 'Rent Amount',
            'status' => 'Status',
            'tenant_id' => 'Tenant ID',
        ];
    }

    public function getProperty(): ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    public function getTenant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'tenant_id']);
    }

    public static function getByProperty($property_id)
    {
        return (new Query())
            ->select(['units.*', 'users.name AS tenant_name'])
            ->from('units')
            ->leftJoin('users', 'units.tenant_id = users.id OR users.unit_id = units.id')
            ->where(['units.property_id' => $property_id])
            ->groupBy('units.id')
            ->all();
    }

    public static function addUnit($data)
    {
        $model = new static();
        $model->property_id = $data['property_id'];
        $model->unit_number = $data['unit_number'];
        $model->rent_amount = $data['rent_amount'];
        $model->status = $data['status'];

        return $model->save();
    }

    public function assignTenant($tenant_id)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            Yii::$app->db->createCommand()->update(
                'users',
                ['unit_id' => $this->id],
                ['id' => $tenant_id]
            )->execute();

            $this->status = 'occupied';
            $this->tenant_id = $tenant_id;
            $this->save(false);

            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        return $this->save(false);
    }

    public static function getOccupantsCount($unit_id)
    {
        $result = (new Query())
            ->select(['total' => 'COUNT(id)'])
            ->from('tenants')
            ->where(['unit_id' => $unit_id])
            ->one();

        return $result ? (int) $result['total'] : 0;
    }

    public static function getIdsByProperty($property_id)
    {
        return static::find()
            ->select(['id'])
            ->where(['property_id' => $property_id])
            ->asArray()
            ->all();
    }
}
