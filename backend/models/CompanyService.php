<?php


namespace backend\models;


use backend\models\forms\CompanyForm;

class CompanyService
{
    /**
     * @param CompanyForm $form
     * @return bool
     */
    public function save(CompanyForm $form)
    {
        $company = new Company();
        $company->setAttributes($form->getAttributes());
        return $company->save();
    }
}