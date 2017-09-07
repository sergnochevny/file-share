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
        '/applicant' => '/investigation/index',
        '/applicant/<action:\w+>/<id:\d+>' => '/investigation/<action>',
        '/login'=>'/auth/auth/login',
        '/logout' => '/auth/auth/logout',
        '/sign-up' => '/auth/auth/sign-up',
        '/password-reset' => '/auth/auth/password-reset',
        '/password-restore' => '/auth/auth/password-restore',
        '/file/download/<id:[\w\d-]+>' => '/file/download',
        '/file/archive/<id:[\w\d-]+>' => '/file/archive',
        '/file/multi-download/<parent:[\w\d-]+>' => '/file/multi-download',
        '/file/multi-upload/<parent:[\w\d-]+>' => '/file/multi-upload',
        '/file/upload/<parent:[\w\d-]+>' => '/file/upload',
        '/history/<action>' => '/history/<action>',
        '/history/<action>/<id:\d+>' => '/history/<action>',
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