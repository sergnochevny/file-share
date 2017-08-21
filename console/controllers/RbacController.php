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
        ['name' => 'wizard.user', 'description' => 'Wizard users'],
        ['name' => 'wizard.company-users', 'description' => 'Wizard company user'],
        ['name' => 'wizard.investigation', 'description' => 'Wizard investigation'],

        ['name' => 'investigation-type.index', 'description' => 'Investigation types list'],
        ['name' => 'investigation-type.create', 'description' => 'Investigation type create'],
        ['name' => 'investigation-type.update', 'description' => 'Investigation type update'],
        ['name' => 'investigation-type.delete', 'description' => 'Investigation type delete'],

        ['name' => 'investigation.index', 'description' => 'Investigations list'],
        ['name' => 'investigation.complete', 'description' => 'Investigations complete'],
        ['name' => 'investigation.archive', 'description' => 'Investigations archive'],

        ['name' => 'history.index', 'description' => 'History index'],
        ['name' => 'history.recover', 'description' => 'History recover'],

        ['name' => 'file.index', 'description' => 'Files list view'],
        ['name' => 'file.delete', 'description' => 'Files delete'],
        ['name' => 'file.download', 'description' => 'Files download'],
        ['name' => 'file.download-archive', 'description' => 'Files download from archive'],
        ['name' => 'file.multi-download', 'description' => 'Files download multiple'],
        ['name' => 'file.upload', 'description' => 'Files upload'],
        ['name' => 'file.multi-upload', 'description' => 'Files multiple upload'],
        ['name' => 'file.archive', 'description' => 'Files delete'],
    ];

    protected $dependencies = [
        'sadmin' => [
            'permission' => [
                'site.settings' => true,
                'user.delete' => true,
                'wizard.update-types' => true,
                'wizard.investigation' => true,
                'investigation-type.create' => true,
                'investigation-type.update' => true,
                'investigation-type.delete' => true,
                'investigation.archive' => true,
                'history.recover' => true
            ]
        ],
        'admin' => [
            'permission' => [
                'user.index' => true,
                'company.index' => true,
                'company.archive' => true,
                'history.index' => true,
                'history.recover' => true,
                'investigation.complete' => true,
                'investigation.archive' => false,
                'wizard.investigation' => false,
                'wizard.user' => true,
                'wizard.company-users' => true,
                'investigation-type.index' => true,
                'file.delete' => true
            ]
        ],
        'user' => [
            'permission' => [
                'site.index' => true,
                'investigation.index' => true,
                'profile.index' => true,
                'wizard.company' => true,
                'wizard.investigation' => true,
                'investigation.archive' => true,
                'history.index' => true,
                'file.index' => true,
                'file.archive' => true,
                'file.download' => true,
                'file.download-archive' => true,
                'file.multi-download' => true,
                'file.upload' => true,
                'file.multi-upload' => true,
            ]
        ],
        'all' => [
            'permission' => [
                'site.error' => true,
                'site.captcha' => true,
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