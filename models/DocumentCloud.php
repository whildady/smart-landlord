<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Hii ndiyo Model kwa ajili ya Document Cloud
 */
class DocumentCloud extends ActiveRecord
{
    public static function tableName()
    {
        return 'document_cloud';
    }

    public function rules()
    {
        return [
            // Ziko sahihi kabisa kama ulivyoweka, hakuna makosa
            [['landlord_id', 'file_name', 'file_path', 'file_category'], 'required'],
            [['landlord_id', 'tenant_id'], 'integer'],
            [['expiry_date', 'created_at'], 'safe'],
            [['file_name', 'file_path', 'file_category'], 'string', 'max' => 255],
        ];
    }

    /**
     * Professional Touch: Inasaidia fomu au view kujua majina safi ya kuonyesha kwenye skrini
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'landlord_id' => 'Landlord ID',
            'tenant_id' => 'Tenant ID',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'file_category' => 'Category',
            'expiry_date' => 'Expiry Date',
            'created_at' => 'Uploaded At',
        ];
    }
}