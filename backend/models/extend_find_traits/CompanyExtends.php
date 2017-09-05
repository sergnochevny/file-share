<?php
/**
 * Copyright (c) 2017. AIT
 */

/**
 * Date: 04.09.2017
 * Time: 20:00
 */

namespace backend\models\extend_find_traits;

use ait\rbac\DbManager;
use yii\db\ActiveRecord;

trait CompanyExtends
{
    /**
     * @param \yii\db\ActiveQuery $query
     */
    protected static function extendFindConditionByPermissions(&$query)
    {
        /**
         * @var ActiveRecord $this
         */
        $permission = static::getPermissionName('all');
        $can = \Yii::$app->user->can($permission);
        if (!$can) {
            /**
             * @var DBManager $am
             */
            $permission = static::getPermissionName('group');
            $am = \Yii::$app->authManager;
            $user = \Yii::$app->user->identity;
            $intersectRoles = $am->getRolesByUser($user->id);
            $intersectRoles = array_diff_key($intersectRoles, $am->getDefaultRoleInstances());
            if (!empty($intersectRoles)) {
                $intersectRoles = array_filter($intersectRoles, function ($roleObj) use ($am, $permission) {
                    $permissions = $am->getPermissionsByRole($roleObj->name);
                    /**
                     * @var \ait\rbac\Permission[] $permissions
                     */
                    return (isset($permissions[$permission]) && $permissions[$permission]->allow);
                });
                if (!empty($intersectRoles)) {
                    $query->leftJoin(
                        $am->assignmentTable,
                        $am->assignmentTable . '.user_id = ' . static::tableName() . '.created_by'
                    );
                    $query->andWhere(['in', $am->assignmentTable . '.item_name', array_keys($intersectRoles)]);
                    $can = true;
                }
            }
        }
        if (!$can) {
            $query->joinWith('users');
            $query->andWhere(['user.id' => \Yii::$app->user->id]);
        }
    }
}
