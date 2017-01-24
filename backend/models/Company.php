<?php


namespace backend\models;


final class Company extends \common\models\Company
{
    /**
     * Gets list [id => name] of companies
     *
     * @return array
     */
    public static function getList()
    {
        $companies = self::find()->select(['id', 'name'])->asArray()->all();
        return array_column($companies, 'name', 'id');
    }

    public static function getUserList()
    {

    }
}