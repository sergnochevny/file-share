<?php


namespace backend\models;

use yii\db\ActiveRecord;


trait FactoryTrait
{
    /**
     * Find model by id or creates new one
     *
     * @param $id
     * @return ActiveRecord
     */
    public static function create($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            return static::findOne($id);
        }

        return new static();
    }
}