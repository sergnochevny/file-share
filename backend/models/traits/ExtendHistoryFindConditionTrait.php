<?php
/**
 * Copyright (c) 2017. AIT
 */

/**
 * Date: 04.09.2017
 * Time: 20:16
 */

namespace backend\models\traits;

use ait\rbac\DbManager;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

trait ExtendHistoryFindConditionTrait
{
    protected static $ALLOW_SCENARIOS_OF_PERMISSIONS = ['all', 'group'];

    /**
     * Creates something like site.index.all (controller.action.all)
     * or if it has module - module.controller.action.all
     *
     * @param string $scenario
     * @return string
     */
    public static function getPermissionName($scenario = 'all')
    {
        if (!in_array($scenario, static::$ALLOW_SCENARIOS_OF_PERMISSIONS)) {
            $scenario = 'all';
        }
        $tableName = \Yii::$app->db->schema->getRawTableName(static::tableName());
        return ($tableName . '.find.' . $scenario);
    }

    /**
     * @return array
     */
    public static function getIntersectPermissions()
    {
        return array_filter([
            str_replace('/', '.', static::getPermissionName('group')),
//            str_replace('/', '.', Yii::$app->controller->getUniqueId() . '.create'),
//            str_replace('/', '.', Yii::$app->controller->getUniqueId()),
//            str_replace('/', '.', Yii::$app->controller->module->getUniqueId())
        ]);
    }


    public static function find()
    {
        $class = get_called_class();
        $query = Yii::createObject(ActiveQuery::className(), [$class]);
        static::extendFindConditionByPermissions($query);
        return $query;
    }

    /**
     * @param \common\models\query\UndeleteableActiveQuery $query
     */
    protected static function extendFindConditionByPermissions(&$query)
    {
        /**
         * @var ActiveRecord $this
         * @var DBManager $am
         */
        $am = \Yii::$app->authManager;
        $user = \Yii::$app->user->identity;
        $tableName = \Yii::$app->db->schema->getRawTableName(static::tableName());

        $permission = static::getPermissionName('all');
        $can = \Yii::$app->user->can($permission);
        if (!$can) {
            $permission = static::getPermissionName('group');
            if (\Yii::$app->user->can($permission)) {
                $intersectRoles = $am->getRolesByUser($user->id);
                $intersectRoles = array_diff_key($intersectRoles, $am->getDefaultRoleInstances());
                if (!empty($intersectRoles)) {
                    $intersectPermissions = static::getIntersectPermissions();
                    $intersectRoles =
                        array_filter($intersectRoles, function ($roleObj) use ($am, $intersectPermissions) {
                            $permissions = $am->getPermissionsByRole($roleObj->name);
                            /**
                             * @var \ait\rbac\Permission[] $permissions
                             */
                            $intersectPermissions = array_intersect($intersectPermissions, array_keys($permissions));
                            if (empty($intersectPermissions)) {
                                return false;
                            }
                            $can = false;
                            foreach ($intersectPermissions as $permission) {
                                $can = $can || $permissions[$permission]->allow;
                            }
                            return $can;
                        });
                    if (!empty($intersectRoles)) {
                        $query->leftJoin(
                            $am->assignmentTable,
                            $am->assignmentTable . '.user_id = ' . $tableName . '.created_by'
                        );
                        $query->andWhere(['in', $am->assignmentTable . '.item_name', array_keys($intersectRoles)]);
                        $can = true;
                    }
                }
            }
        }
        if (!$can) {
            $query->andWhere([$tableName . '.created_by' => !empty($user->id) ? $user->id : null]);
        }
        if (!\Yii::$app->user->can('company.find.all')) {
            $query->joinWith('users');
            $query->andWhere(['user.id' => !empty($user->id) ? $user->id : null]);
        }
    }
}
