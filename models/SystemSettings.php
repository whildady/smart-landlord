<?php

namespace app\models;

use yii\db\ActiveRecord;

class SystemSettings extends ActiveRecord
{
    public static function tableName()
    {
        return 'system_settings';
    }

    // Helper function ya kuchukua setting yoyote kwa urahisi
    public static function getVal($key, $default = null)
    {
        $setting = self::findOne(['setting_key' => $key]);
        return $setting ? $setting->setting_value : $default;
    }
}