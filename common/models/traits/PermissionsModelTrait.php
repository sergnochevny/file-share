<?php
/**
 * Copyright (c) 2017. sn
 */

/**
 * Date: 21.08.2017
 * Time: 17:57
 */

namespace common\models\traits;

use common\models\query\UndeleteableActiveQuery;
use Yii;

/**
 * Trait PermissionsModelTrait
 * @package backend\models
 */
trait PermissionsModelTrait
{

    protected static $ALLOW_SCENARIOS_OF_PERMISSIONS = ['all', 'group'];

    /**
     * @inheritdoc
     */
    public static function find()
    {
        $class = get_called_class();
        $query = Yii::createObject(UndeleteableActiveQuery::className(), [$class]);
        static::extendFindConditionByPermissions($query);
        return $query;
    }

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

    /**
     * @param UndeleteableActiveQuery $query
     */
    protected static function extendFindConditionByPermissions(&$query)
    {
    }
}