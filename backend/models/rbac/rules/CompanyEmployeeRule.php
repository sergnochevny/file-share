<?php


namespace backend\models\rbac\rules;


use yii\rbac\Rule;

class CompanyEmployeeRule extends Rule
{
    public function execute($user, $item, $params)
    {
        //check if user is work for company and return true;
    }

}