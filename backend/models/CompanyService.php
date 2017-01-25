<?php


namespace backend\models;


use backend\models\forms\CompanyForm;
use yii\base\Object;

;

class CompanyService
{
    /**
     * @var Company AR
     */
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
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