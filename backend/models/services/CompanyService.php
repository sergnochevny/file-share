<?php


namespace backend\models\services;


use backend\models\Company;
use backend\models\forms\CompanyForm;

final class CompanyService
{
    /**
     * @var Company AR
     */
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function populateForm(CompanyForm $form)
    {
        $form->setAttributes($this->company->getAttributes());
    }

    /**
     * @param CompanyForm $form
     * @return bool
     */
    public function save(CompanyForm $form)
    {
        $this->company->setAttributes($form->getAttributes());
        return $this->company->save();
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}