<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'smart-landlord',
    'name' => 'Smart Landlord System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'user/login',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4LdxN6kyEMlOI_Xjk8-ln8H76R5D6qDV',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // --- NZURI ZA GOOGLE AUTH (ZIMEKAA SUTI) ---
                'user/auth/<authclient:\w+>' => 'user/auth', 
                'user/auth' => 'user/auth',
                
                'complete-profile' => 'user/complete-profile',
                'login' => 'user/login',
                'register' => 'user/register',
                'logout' => 'user/logout',
                'forgot-password' => 'user/forgot-password',
                'site/login' => 'user/login',
                
                // --- SHERIA ZAKO ZA DASHBOARD ---
                'landlord/units/<property_id:\d+>' => 'landlord/units',
                'landlord/assign-tenant/<unit_id:\d+>' => 'landlord/assign-tenant',
                'landlord/delete-unit/<unit_id:\d+>/<property_id:\d+>' => 'landlord/delete-unit',
                'landlord/update-unit-status/<unit_id:\d+>/<property_id:\d+>' => 'landlord/update-unit-status',
                'landlord/utility-breakdown/<billId:\d+>' => 'landlord/utility-breakdown',
                'landlord/delete-bill/<id:\d+>' => 'landlord/delete-bill',
                'landlord/delete-property/<id:\d+>' => 'landlord/delete-property',
                'landlord/mark-paid/<id:\d+>' => 'landlord/mark-paid',
                'landlord/delete-invoice/<id:\d+>' => 'landlord/delete-invoice',
            ],
        ], // <--- Mabano ya urlManager yamefungwa hapa sawa sawa sasa hivi!
        
        /**
         * CONFIGURATION YA GOOGLE NA APPLE AUTHCLIENT
         */
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'NULL',
                    'clientSecret' => 'NULL',
                    'title' => 'Google',
                    'returnUrl' => 'http://localhost/smart-landlord-yii/web/user/auth?authclient=google',
                    // --- REKEBISHO: viewOptions sasa zipo NDANI ya google client yenyewe kitalamu ---
                    'viewOptions' => [
                        'popupWidth' => 600,
                        'popupHeight' => 500,
                        'authUrl' => 'https://accounts.google.com/o/oauth2/v2/auth?prompt=select_account',
                    ],
                ],
            ],
        ],
        
    ], // Mabano ya components yanafunga hapa
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;