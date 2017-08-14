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

        ['name' => 'site.index', 'description' => 'site.index'],
        ['name' => 'site.settings', 'description' => 'site.settings']
    ];

    protected $dependencies = [
        'sadmin' => [
            'permission' => [
                'site.settings'
            ]
        ],
        'admin' => [
            'permission' => [
                'company.index',
                'company.archive',
                'history.index',
                'history.recover',
                'investigation.complete',
                'investigation.archive',
            ]
        ],
        'user' => [
            'permission' => [
                'site.index',
                'investigation.index',

                'profile.index',
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