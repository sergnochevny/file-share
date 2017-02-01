<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Protus',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/theme/vendor.min.js',
                    ]
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\User::class,
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '@<username:[\w-]+>/' => '/profile/index',
            ]
        ],
        'formatter' => [
            'dateFormat' => 'MM.dd.yyyy',
            'sizeFormatBase' => 1000
        ],
    ],
    'as globalAccess' => [
        'class' => 'common\behaviors\GlobalAccessBehavior',
        'rules' => [
            [
                'controllers' => ['file', 'history', 'investigation', 'wizard', 'user'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'controllers' => ['company', 'user'],
                'allow' => true,
                'roles' => ['admin'],
            ],
            [
                'controllers' => ['company'],
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['client'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['login', 'restore-password-request', 'password-reset'],
                'roles' => ['?'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['logout','index'],
                'roles' => ['@'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['error'],
                'roles' => ['?', '@'],
            ],
            [
                'allow' => true,
                'roles' => ['admin'],
            ],
            [
                'allow' => false,
            ],
        ],
    ],
    'params' => $params,
];
