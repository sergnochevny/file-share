<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'user' => [
            'class' => 'common\components\User',
            'identityClass' => 'common\models\User',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['all']
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'keyStorage' => [
            'class' => 'ait\keystorage\components\KeyStorage',
        ],
    ],
    'modules' => [
        'auth' => [
            'class' => 'ait\auth\Module',
            'viewPath' => '@backend/views/auth'
        ],
    ],
];
