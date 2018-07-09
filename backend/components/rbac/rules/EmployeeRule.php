<?php

namespace backend\components\rbac\rules;

use sn\rbac\Rule;
use common\models\Company;
use common\models\Investigation;

class EmployeeRule extends Rule
{
    public $name = 'isEmployee';

    public function execute($user, $item, $params)
    {
        /**
         * @var Company $company
         * @var Investigation $investigation
         */
        if (isset($params['company']) && ($params['company'] instanceof Company)) {
            $company = $params['company'];
            foreach ($company->users as $item) {
                if ($item->id == $user) {
                    return true;
                }
            }
        } elseif (isset($params['investigation']) && ($params['investigation'] instanceof Investigation)) {
            $investigation = $params['investigation'];
            return $investigation->created_by == $user;
        } elseif (isset($params['allfiles']) && ($params['allfiles'] == 'root')) {
            return true;
        }

        return false;
    }

}