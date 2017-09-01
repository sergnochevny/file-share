<?php
/**
 * Date: 21.08.2017
 * Time: 17:57
 */

namespace backend\models;

use common\models\query\UndeleteableActiveQuery;
use Yii;
use yii\db\ActiveQuery;

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

    /**
     * @param ActiveQuery $query
     */
    protected static function extendFindConditionByPermissions(&$query)
    {
    }
}
