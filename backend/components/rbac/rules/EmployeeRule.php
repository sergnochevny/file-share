<?php

namespace backend\components\rbac\rules;

use ait\rbac\Rule;
use backend\models\Company;

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
            $company = $params['investigation']->company;
        } elseif (isset($params['allfiles']) && ($params['allfiles'] == 'root')) {
            return true;
        } else {
            return false;
        }
        if (isset($company)) {
            foreach ($company->users as $item) {
                if ($item->id == $user) {
                    return true;
                }
            }
        }
        return false;
    }

}