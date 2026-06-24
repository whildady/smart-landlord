<?php

namespace tests\unit\models;

use app\models\User;
use Yii;

class UserTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $this->seedUser([
            'id' => 100,
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'auth_key' => 'test100key',
            'access_token' => '100-token',
            'role' => 'landlord',
            'status' => 'active',
        ]);

        $this->seedUser([
            'id' => 101,
            'username' => 'demo',
            'name' => 'Demo',
            'email' => 'demo@example.com',
            'password' => 'demo',
            'auth_key' => 'test101key',
            'access_token' => '101-token',
            'role' => 'tenant',
            'status' => 'active',
        ]);
    }

    protected function _after()
    {
        User::deleteAll(['id' => [100, 101]]);
    }

    private function seedUser(array $data)
    {
        $user = User::findOne($data['id']);
        if ($user === null) {
            $user = new User();
            $user->id = $data['id'];
        }

        $user->setAttributes($data, false);
        $user->save(false);
    }

    public function testFindUserById()
    {
        verify($user = User::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = User::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('admin'))->notEmpty();
        verify(User::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();
    }
}
