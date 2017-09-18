<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace console\controllers;


use ait\auth\traits\RbacInitTrait;
use backend\components\rbac\rules\EmployeeRule;
use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{

    use RbacInitTrait;

    protected $permissions = [
        ['name' => 'site.index', 'description' => 'Site index view'],
        ['name' => 'site.settings', 'description' => 'Site Settings View'],
        ['name' => 'site.error', 'description' => 'Error page view'],
        ['name' => 'site.captcha', 'description' => 'Captcha generation'],

        ['name' => 'company.index', 'description' => 'company.index'],
        ['name' => 'company.create', 'description' => 'company.create'],
        ['name' => 'company.update', 'description' => 'company.update'],
        ['name' => 'company.archive', 'description' => 'company.archive'],

        ['name' => 'history.index', 'description' => 'History index'],
        ['name' => 'history.recover', 'description' => 'History recover'],

        ['name' => 'investigation.index', 'description' => 'Investigations list'],
        ['name' => 'investigation.complete', 'description' => 'Investigations complete'],
        ['name' => 'investigation.archive', 'description' => 'Investigations archive'],
        ['name' => 'investigation.create', 'description' => 'investigation.create'],
        ['name' => 'investigation.update', 'description' => 'investigation.update'],

        ['name' => 'profile.index', 'description' => 'profile.index'],

        ['name' => 'user.index', 'description' => 'Users view'],
        ['name' => 'user.create', 'description' => 'User create'],
        ['name' => 'user.update', 'description' => 'Users update'],
        ['name' => 'user.delete', 'description' => 'Delete users'],

        ['name' => 'admin.index', 'description' => 'Admins view'],
        ['name' => 'admin.create', 'description' => 'Create Admins'],
        ['name' => 'admin.update', 'description' => 'Update Admins'],
        ['name' => 'admin.delete', 'description' => 'Delete Admins'],

        ['name' => 'wizard.update-types', 'description' => 'Wizard update types'],
        ['name' => 'wizard.company', 'description' => 'Wizard company'],
        ['name' => 'wizard.user', 'description' => 'Wizard users'],
        ['name' => 'wizard.admin', 'description' => 'Wizard admins'],
        ['name' => 'wizard.company-users', 'description' => 'Wizard company user'],
        ['name' => 'wizard.investigation', 'description' => 'Wizard investigation'],

        ['name' => 'investigation-type.index', 'description' => 'Investigation types list'],
        ['name' => 'investigation-type.create', 'description' => 'Investigation type create'],
        ['name' => 'investigation-type.update', 'description' => 'Investigation type update'],
        ['name' => 'investigation-type.delete', 'description' => 'Investigation type delete'],

        ['name' => 'file.index', 'description' => 'Files list view'],
        ['name' => 'file.delete', 'description' => 'Files delete'],
        ['name' => 'file.download', 'description' => 'Files download'],
        ['name' => 'file.download-archive', 'description' => 'Files download from archive'],
        ['name' => 'file.multi-download', 'description' => 'Files multiple download'],
        ['name' => 'file.upload', 'description' => 'Files upload'],
        ['name' => 'file.multi-upload', 'description' => 'Files multiple upload'],
        ['name' => 'file.archive', 'description' => 'Files delete'],

// Modules permissions..............................................................................................

        ['name' => 'company.find.all', 'description' => 'Model permission all companies list'],
        ['name' => 'company.find.group', 'description' => 'Model permission group companies list'],
        ['name' => 'company.update.all', 'description' => 'Model permission foreign all companies archiving'],
        ['name' => 'company.update.group', 'description' => 'Model permission foreign group companies update'],
        ['name' => 'company.archive.all', 'description' => 'Model permission foreign all companies archiving'],
        ['name' => 'company.archive.group', 'description' => 'Model permission foreign group companies archiving'],

        ['name' => 'investigation.find.all', 'description' => 'Model permission all investigations list'],
        ['name' => 'investigation.find.group', 'description' => 'Model permission group investigations list'],
        ['name' => 'investigation.update.all', 'description' => 'Model permission all investigations update'],
        ['name' => 'investigation.complete.all', 'description' => 'Model permission all investigations completion'],
        ['name' => 'investigation.complete.group', 'description' => 'Model permission group investigations completion'],
        ['name' => 'investigation.archive.all', 'description' => 'Model permission all investigations archiving'],
        ['name' => 'investigation.archive.group', 'description' => 'Model permission group investigations archiving'],

        ['name' => 'history.find.all', 'description' => 'Model permission all history list'],
        ['name' => 'history.find.group', 'description' => 'Model permission group history list'],
        ['name' => 'history.recover.all', 'description' => 'Model permission all history recovering'],
        ['name' => 'history.recover.group', 'description' => 'Model permission group history recovering'],

        ['name' => 'file.find.all', 'description' => 'Model permission all files list'],
        ['name' => 'file.find.group', 'description' => 'Model permission group files list'],
        ['name' => 'file.multi-download.all', 'description' => 'Model permission download all files by packet'],
        ['name' => 'file.download.all', 'description' => 'Model permission download all files'],
        ['name' => 'file.multi-upload.all', 'description' => 'Model permission upload files by packet'],
        ['name' => 'file.upload.all', 'description' => 'Model permission upload file'],
        ['name' => 'file.archive.all', 'description' => 'Model permission archive file'],

//Specifying permissions rules.....................................................................................

        [
            'name' => 'employee',
            'description' => 'Verify employee of company',
            'rule' => '\backend\components\rbac\rules\EmployeeRule'
        ],
    ];

    protected $roles = [
        ['name' => 'full', 'description' => 'Full Clients Role', 'type' => 'custom'],
        ['name' => 'shared', 'description' => 'Shared Clients Role', 'type' => 'custom'],
        ['name' => 'individual', 'description' => 'Individual Clients Role', 'type' => 'custom'],
    ];

    protected $dependencies = [
        'sadmin' => [
            'permission' => [
                'site.settings' => true,
                'user.delete' => true,
                'admin.index' => true,
                'admin.create' => true,
                'admin.update' => true,
                'admin.delete' => true,
                'wizard.admin' => true,
                'wizard.update-types' => true,
                'wizard.investigation' => true,
                'investigation.create' => true,
                'investigation.update' => true,
                'investigation.update.all' => true,
                'investigation-type.create' => true,
                'investigation-type.update' => true,
                'investigation-type.delete' => true,
                'investigation.archive' => true,
                'history.recover' => true,

//permissions of foreign objects
                'investigation.archive.all' => true,
                'history.recover.all' => true,
            ]
        ],
        'admin' => [
            'permission' => [
                'user.index' => true,
                'company.index' => true,
                'company.create' => true,
                'company.archive' => true,
                'history.index' => true,
                'history.recover' => true,
                'wizard.user' => true,
                'wizard.company-users' => true,
                'wizard.investigation' => false,
                'investigation.create' => false,
                'investigation.update' => false,
                'investigation.complete' => true,
                'investigation.archive' => true,
                'investigation-type.index' => true,
                'file.delete' => true,

//permissions of foreign objects
                'company.find.all' => true,
                'company.update.all' => true,
                'company.archive.all' => true,

                'history.find.all' => true,

                'investigation.find.all' => true,
                'investigation.complete.all' => true,
                'investigation.archive.all' => false,

                'file.archive.all' => true,
                'file.upload.all' => true,
                'file.multi-upload.all' => true,
            ]
        ],
        'full' => [
            'role' => ['shared'],
            'permission' => [
                'investigation.find.all' => true,
                'history.find.all' => true
            ]
        ],
        'shared' => [
            'role' => ['individual'],
            'permission' => [
                'investigation.find.group' => true,
                'history.find.group' => true,
            ]
        ],
        'individual' => [
            'role' => ['user'],
            'permission' => [
            ]
        ],
        'user' => [
            'permission' => [
                'company.update' => true,
                'site.index' => true,
                'investigation.index' => true,
                'profile.index' => true,
                'wizard.company' => true,
                'wizard.investigation' => true,
                'investigation.create' => true,
                'investigation.update' => true,
                'history.index' => true,
                'file.index' => true,
                'file.archive' => true,
                'file.download' => true,
                'file.download-archive' => true,
                'file.multi-download' => true,
                'file.upload' => true,
                'file.multi-upload' => true,
                'employee' => true,

                'file.find.all' => true,
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
        $this->initRoles($this->roles);
        $this->initPermissions($this->permissions);
        $this->initDependencies($this->dependencies);
    }
}