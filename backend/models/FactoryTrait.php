<?php


namespace backend\models;

use yii\db\ActiveRecordInterface;


trait FactoryTrait
{
    /**
     * Find model by id or creates new one
     *
     * @param $id
     * @return ActiveRecordInterface
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