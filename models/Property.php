<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * @property int $id
 * @property int $landlord_id
 * @property string $name
 * @property string $address
 * @property string $type
 * @property string|null $created_at
 *
 * @property User $landlord
 * @property Unit[] $units
 * @property UtilityBill[] $utilityBills
 */
class Property extends ActiveRecord
{
    public static function tableName()
    {
        return 'properties';
    }

    public function rules()
    {
        return [
            [['landlord_id', 'name', 'address', 'type'], 'required'],
            [['landlord_id'], 'integer'],
            [['name', 'address', 'type'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
            [['landlord_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['landlord_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'landlord_id' => 'Landlord ID',
            'name' => 'Name',
            'address' => 'Address',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    public function getLandlord(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'landlord_id']);
    }

    public function getUnits(): ActiveQuery
    {
        return $this->hasMany(Unit::class, ['property_id' => 'id']);
    }

    public function getUtilityBills(): ActiveQuery
    {
        return $this->hasMany(UtilityBill::class, ['property_id' => 'id']);
    }

    public static function getPropertiesByLandlord($landlord_id)
    {
        return (new Query())
            ->select(['p.*', 'COUNT(u.id) AS total_units'])
            ->from(['p' => 'properties'])
            ->leftJoin(['u' => 'units'], 'p.id = u.property_id')
            ->where(['p.landlord_id' => $landlord_id])
            ->groupBy('p.id')
            ->orderBy(['p.created_at' => SORT_DESC])
            ->all();
    }

    public static function addProperty($data)
    {
        $model = new static();
        $model->landlord_id = $data['landlord_id'];
        $model->name = $data['name'];
        $model->address = $data['address'];
        $model->type = $data['type'];

        return $model->save();
    }

    public static function getPropertyById($id)
    {
        return static::findOne($id);
    }

    public static function deleteProperty($id)
    {
        $model = static::findOne($id);

        return $model !== null && $model->delete() !== false;
    }
}
