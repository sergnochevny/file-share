<?php
/**
 * Date: 08.08.2017
 * Time: 17:03
 */

return [
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
//        '/company/create' => '/wizard/company',
        '/user/edit/<id:\d+>' => '/wizard/user',
        '/login'=>'/auth/auth/login',
        '/logout' => '/auth/auth/logout',
        '/sign-up' => '/auth/auth/sign-up',
        '/password-reset' => '/auth/auth/password-reset',
        '/password-restore' => '/auth/auth/password-restore',
        '/user/<action>' => '/user/<action>',

        '/wizard/<action>' => '/wizard/<action>',

        '/<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
        '/<module:\w+>/<controller:\w+>/<action>' => '<module>/<controller>/<action>',

        '/<controller:\w+>' => '/<controller>/index',
        '/<controller:\w+>/<action>/<id:\d+>' => '/<controller>/<action>',
        '/<controller:\w+>/<action>/<id:[\w\d-]+>' => '/<controller>/<action>',
        '/<controller:\w+>/<action>' => '/<controller>/<action>',

   ]
];