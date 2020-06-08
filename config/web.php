<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'es-ES',
    // 'sourceLanguage' => 'es-ES',
    'name' => 'Turnos Desligar.me',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute'=>'/site/index',
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    // '@dektrium/user/views' => '@app/views/security',
                    // '@dektrium/user/views' => '@app/views/security',
                    '@dektrium/user/views/security' => '@app/views/security',
                    '@dektrium/user/views/recovery' => '@app/views/recovery',
                    '@dektrium/user/views/registration' => '@app/views/registration',
                    '@dektrium/user/views/settings' => '@app/views/settings',
                    // '@app/views' => '@app/views/layouts/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => false,
            // Use pretty URLs
            'enablePrettyUrl' => true,
            'rules' => [
                'reservar/<id:\d+>'=>'link/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                // '/'=>'site/main-index',
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'eDVzykOci3CI4vH9F9Urb9zVff6Sxe0d',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'user' => [
        //     'identityClass' => 'app\models\User',
        //     'enableAutoLogin' => true,
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'registration' => [
                    // 'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'class' => 'app\controllers\RegistrationController',
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                        Yii::$app->response->redirect(array('/user/security/login'))->send();
                        Yii::$app->end();
                    }
                ],
            ],
            'modelMap' => [
                'User' => 'app\models\User',
            ],
            'enableConfirmation' => false,
            'enableRegistration' => true,
            'enablePasswordRecovery' => true,
            'admins' => ['santiago'],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'gridview' => [
            'class' => 'kartik\grid\Module',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kvgrid/messages',
                'forceTranslation' => true
            ]
        ],
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'dd-MM-yyyy',
                'time' => 'H:i:s A',
                'datetime' => 'd-m-Y H:i:s A',
            ],

            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'php:Y-m-d', 
                'time' => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],



            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1','192.168.0.218'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1','192.168.0.218'],
    ];
    $config['modules']['gii']['generators'] = [
        'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
        'crud' => [
            'class' => 'yii\gii\generators\crud\Generator',
            'templates' => [
                'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
            ]
        ]
    ];
}

return $config;
