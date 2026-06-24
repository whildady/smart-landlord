<?php

namespace app\helpers;

use Yii;
use yii\web\ForbiddenHttpException;

class SessionHelper
{
    public static function isLoggedIn(): bool
    {
        return !Yii::$app->user->isGuest;
    }

    public static function requireLandlord(): void
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        }

        $user = Yii::$app->user->identity;
        if ($user === null || $user->role !== 'landlord') {
            throw new ForbiddenHttpException('Landlord access required.');
        }
    }

    public static function requireTenant(): void
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        }

        $user = Yii::$app->user->identity;
        if ($user === null || $user->role !== 'tenant') {
            throw new ForbiddenHttpException('Tenant access required.');
        }
    }
}
