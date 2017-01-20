<?php


namespace backend\controllers;


use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use yii\web\Controller;

class WizardController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'companyForm' => new CompanyForm(),
            'userForm' => new UserForm(),
        ]);
    }
}