<?php


namespace backend\models\rbac\rules;


use yii\filters\AccessRule;
use yii\rbac\Rule;

class CompanyEmployeeRule extends Rule
{
    public function execute($user, $item, $params)
    {
        return false;
        //check if user is work for company and return true;
    }

}