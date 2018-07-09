<?php

use backend\models\User;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'file_share',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/index',
    'components' => [
        'keyStorage' => [
            'class' => 'sn\keystorage\components\KeyStorage',
        ],
        'assetManager' => [
            'linkAssets' => false,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/theme/vendor.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => 'sn\utilities\web\User',
            'identityClass' => User::class,
            'loginUrl' => ['auth/auth/login'],
            'enableAutoLogin' => false,
            'authTimeout' => 600,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => include('partials/url-manager.php'),
        'formatter' => [
            'dateFormat' => 'MM.dd.yyyy',
            'sizeFormatBase' => 1000
        ],
    ],
    'as access' => [
        'class' => 'sn\auth\behaviors\AccessControl'
    ],
    'as beforeAction' => [
        'class' => 'sn\auth\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];
