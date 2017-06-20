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
        'keyStorage' => [
            'class' => 'ait\keystorage\components\KeyStorage',
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
            ],
//            'converter' => [
//                'class' => '\common\assets\AssetGzipConverter'
//            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\User::class,
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => '/site/index',
                '/@<username:[\w-]+>/' => '/profile/index',
                '/investigative-services' => '/investigation-type/index',
                '/investigative-services/<action:\w+>/<id:\d+>' => '/investigation-type/<action>',
                '/investigative-services/<action:\w+>' => '/investigation-type/<action>',
                '/settings' => '/site/settings',
                '/applicant/details/<id:\d+>' => '/file/index',
                '/applicant/edit/<id:\d+>' => '/wizard/investigation',
                '/applicant/create' => '/wizard/investigation',
                '/applicant' => '/investigation/index',
                '/applicant/<action:\w+>/<id:\d+>' => '/investigation/<action>',
                '/company/edit/<id:\d+>' => '/wizard/company',
                '/company/create' => '/wizard/company',
                '/user/edit/<id:\d+>' => '/wizard/user',
                '/<controller:\w+>' => '/<controller>/index',
                '/<controller:\w+>/<action:\w+>/<id:\d+>' => '/<controller>/<action>',
                '/<controller:\w+>/<action:\w+>/<id:[\w\d-]+>' => '/<controller>/<action>',
                '/<controller:\w+>/<action:\w+>' => '/<controller>/<action>',
            ]
        ],
        'formatter' => [
            'dateFormat' => 'MM.dd.yyyy',
            'sizeFormatBase' => 1000
        ],
    ],
    'as beforeAction' => [
        'class' => 'common\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];
