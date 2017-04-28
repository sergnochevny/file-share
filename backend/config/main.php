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
            'class' => 'keystorage\components\KeyStorage',
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
            'converter' => [
                'class' => '\common\assets\AssetGzipConverter'
            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\User::class,
            'enableAutoLogin' => false,
            'authTimeout' => 300,
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
                'wizard/applicant' => '/wizard/investigation',
                'applicant' => '/investigation',
                'applicant/<action>' => '/investigation/<action>',
                'investigative-services' => '/investigation-type',
                'investigative-services/<action>' => '/investigation-type/<action>',
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
