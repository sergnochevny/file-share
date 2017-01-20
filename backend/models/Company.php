<?php


namespace backend\models;


class Company extends \common\models\Company
{
    /**
     * Gets list [id => name] of companies
     *
     * @return array
     */
    public static function getList()
    {
        $companies = Company::find()->select(['id', 'name'])->asArray()->all();
        return array_column($companies, 'name', 'id');
    }
}