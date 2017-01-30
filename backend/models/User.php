<?php


namespace backend\models;


use common\models\query\UndeletableActiveQuery;

class User extends \common\models\User
{
    use FactoryTrait;


    /**
     * Finds by role and returns ActiveQuery
     *
     * @param $role
     * @return UndeletableActiveQuery
     */
    public static function findByRole($role)
    {
        $ids = \Yii::$app->getAuthManager()->getUserIdsByRole($role);

        return static::find()->andWhere(['id' => $ids]);
    }
}