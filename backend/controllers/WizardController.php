<?php


namespace backend\controllers;


use backend\models\forms\CompanyForm;
use yii\web\Controller;

class WizardController extends Controller
{
    public function actionIndex()
    {
        $companyForm = new CompanyForm();
        return $this->render('index', ['companyForm' => $companyForm]);
    }
}