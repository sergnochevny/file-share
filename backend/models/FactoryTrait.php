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
        try {
            $id = (int)$id;
        } catch (\Exception $e){
            $id = null;
        }
        if (!empty($id)) {
            return static::findOne($id);
        }

        return new static();
    }
}