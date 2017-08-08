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
        '/company/create' => '/wizard/company',
        '/user/edit/<id:\d+>' => '/wizard/user',
        '/<controller:\w+>' => '/<controller>/index',
        '/<controller:\w+>/<action:\w+>/<id:\d+>' => '/<controller>/<action>',
        '/<controller:\w+>/<action:\w+>/<id:[\w\d-]+>' => '/<controller>/<action>',
        '/<controller:\w+>/<action:\w+>' => '/<controller>/<action>',
    ]
];