<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $auth_key
 * @property string $role
 * @property int|null $unit_id
 * @property string $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'role', 'status'], 'required'],
            [['unit_id'], 'integer'],
            [['name', 'email', 'password', 'auth_key', 'role', 'status'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'unit_id' => 'Unit ID',
            'status' => 'Status',
        ];
    }

    public function getUnit(): ActiveQuery
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 'active']);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return (string) $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() !== '' && $this->getAuthKey() === $authKey;
    }

    public function ensureAuthKey(): bool
    {
        if (!empty($this->auth_key)) {
            return true;
        }

        $this->generateAuthKey();

        return $this->save(false, ['auth_key']);
    }

    public function validatePassword($password)
    {
        if (!empty($this->password) && password_get_info($this->password)['algo']) {
            return password_verify($password, $this->password);
        }

        return $this->password === $password;
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function register(array $data)
    {
        $user = new static();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->role = $data['role'];
        $user->status = $data['status'];
        $user->generateAuthKey();

        return $user->save();
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function getUnassignedTenants()
    {
        return static::find()
            ->select(['id', 'name', 'email'])
            ->where([
                'role' => 'tenant',
                'unit_id' => null,
                'status' => 'active',
            ])
            ->asArray()
            ->all();
    }

    public static function getAvailableTenants()
    {
        return static::find()
            ->select(['id', 'name', 'email'])
            ->where(['role' => 'tenant'])
            ->andWhere(['or',
                ['unit_id' => null],
                ['unit_id' => 0],
                ['unit_id' => ''],
            ])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();
    }

    public static function getActiveTenantsByLandlord($landlord_id)
    {
        return (new Query())
            ->select([
                'u.id AS unit_id',
                'u.unit_number',
                'p.name AS property_name',
                't.id AS tenant_id',
                't.name AS tenant_name',
            ])
            ->from(['t' => 'users'])
            ->innerJoin(['u' => 'units'], 'u.id = t.unit_id')
            ->innerJoin(['p' => 'properties'], 'p.id = u.property_id')
            ->where([
                'u.status' => 'occupied',
                't.role' => 'tenant',
                'p.landlord_id' => $landlord_id,
            ])
            ->all();
    }
}
