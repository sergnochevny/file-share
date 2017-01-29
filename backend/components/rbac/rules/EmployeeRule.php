<?php


namespace backend\components\rbac\rules;


use backend\models\Company;
use yii\rbac\Rule;

class EmployeeRule extends Rule
{
    public $name = 'isEmployee';

    public function execute($user, $item, $params)
    {
        /**
         * @var Company $company
         */
        if (isset($params['company'])) {
            $company = $params['company'];
        } elseif (isset($params['investigation'])) {

        } elseif (isset($params['allfiles'])) {
            return true;
        } else return false;
        if(isset($company))
            foreach ($company->users as $item)
             if ($item == $user) return true;
        return false;
    }

}