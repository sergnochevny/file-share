<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'user' => [
            'class' => 'common\components\User',
            'identityClass' => 'common\models\User',
        ],
        'authManager' => [
            'class' => 'sn\rbac\DbManager',
            'cache' => [
                'class' => 'yii\caching\FileCache',
                'cachePath' => '@backend/runtime/cache'
            ],
            'defaultRoles' => ['all']
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@backend/runtime/cache'
        ],
        'keyStorage' => [
            'class' => 'sn\keystorage\components\KeyStorage',
        ],
    ],
    'modules' => [
        'auth' => [
            'class' => 'sn\auth\Module',
            'viewPath' => '@backend/views/auth'
        ],
    ],
];
