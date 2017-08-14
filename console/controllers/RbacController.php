<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace console\controllers;


use ait\auth\traits\RbacInitTrait;
use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{

    use RbacInitTrait;

    protected $permissions = [
        ['name' => 'company.index', 'description' => 'company.index'],
        ['name' => 'company.archive', 'description' => 'company.archive'],

        ['name' => 'history.index', 'description' => 'history.index'],
        ['name' => 'history.recover', 'description' => 'history.recover'],

        ['name' => 'investigation.index', 'description' => 'investigation.index'],
        ['name' => 'investigation.complete', 'description' => 'investigation.complete'],
        ['name' => 'investigation.archive', 'description' => 'investigation.archive'],

        ['name' => 'profile.index', 'description' => 'profile.index'],

        ['name' => 'site.index', 'description' => 'Site index view'],
        ['name' => 'site.settings', 'description' => 'Site Settings View'],
        ['name' => 'site.error', 'description' => 'Error page view'],
        ['name' => 'site.captcha', 'description' => 'Captcha generation'],

        ['name' => 'user.index', 'description' => 'Users view'],
        ['name' => 'user.delete', 'description' => 'Delete users'],

        ['name' => 'wizard.update-types', 'description' => 'Wizard update types'],
        ['name' => 'wizard.company', 'description' => 'Wizard company'],
        ['name' => 'wizard.users', 'description' => 'Wizard users'],
        ['name' => 'wizard.company-user', 'description' => 'Wizard company user'],
        ['name' => 'wizard.investigation', 'description' => 'Wizard investigation'],

        ['name' => 'investigation-type.index', 'description' => 'Investigation types list'],
        ['name' => 'investigation-type.create', 'description' => 'Investigation type create'],
        ['name' => 'investigation-type.update', 'description' => 'Investigation type update'],
        ['name' => 'investigation-type.delete', 'description' => 'Investigation type delete'],
    ];

    protected $dependencies = [
        'sadmin' => [
            'permission' => [
                'site.settings',
                'user.delete',
                'wizard.update-types',
                'investigation-type.create',
                'investigation-type.update',
                'investigation-type.delete'
            ]
        ],
        'admin' => [
            'permission' => [
                'user.index',
                'company.index',
                'company.archive',
                'history.index',
                'history.recover',
                'investigation.complete',
                'investigation.archive',
                'wizard.user',
                'wizard.company-users',
                'investigation-type.index',
            ]
        ],
        'user' => [
            'permission' => [
                'site.index',
                'investigation.index',
                'profile.index',
                'wizard.company',
                'wizard.investigation',

            ]
        ],
        'all' => [
            'permission' => [
                'site.error',
                'site.captcha',
            ]
        ]
    ];

    /**
     * Initiate site. Creates roles all, user, admin and sadmin.
     * WARNING! If you already have db with roles, this will overwrite it.
     */
    public function actionInit()
    {
        $this->initPermissions($this->permissions);
        $this->initDependencies($this->dependencies);
    }
}