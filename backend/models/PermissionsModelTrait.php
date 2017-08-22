<?php
/**
 * Date: 21.08.2017
 * Time: 17:57
 */

namespace backend\models;


use common\models\query\UndeleteableActiveQuery;
use Yii;

/**
 * Trait PermissionsModelTrait
 * @package backend\models
 */
trait PermissionsModelTrait
{

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

    protected static function getPermissionFromAction()
    {
        $action = Yii::$app->requestedAction;

        $permissions = array_filter([
            str_replace('/', '.', $action->getUniqueId()),
            str_replace('/', '.', $action->controller->getUniqueId()),
            str_replace('/', '.', $action->controller->module->getUniqueId())
        ]);

        array_walk($permissions, function (&$item) {
            $item .= '.all';
        });

        return $permissions;
    }

    /**
     * @param $query
     */
    protected static function extendFindConditionByPermissions(&$query)
    {

    }


}