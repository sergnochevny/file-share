<?php


namespace backend\controllers;


use backend\models\CompanyService;
use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use yii\web\Controller;

class WizardController extends Controller
{
    public function actionIndex()
    {
        $data = \Yii::$app->getRequest()->post();

        $companyForm = new CompanyForm();
        $userForm = new UserForm();

        if ($companyForm->load($data)) {
            $companyService = new CompanyService();
            $companyService->save($companyForm);
        }

        if ($userForm->load($data)) {

        }

        return $this->render('index', [
            'companyForm' => new CompanyForm(),
            'userForm' => new UserForm(),
        ]);
    }


    public function actionCompany()
    {

    }
}