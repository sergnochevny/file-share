<?php


namespace backend\controllers;


use backend\models\CompanyService;
use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use yii\web\Controller;

class WizardController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'company';

    /**
     * Shows Company tab
     *
     * @return string
     */
    public function actionCompany()
    {
        $companyForm = new CompanyForm();
        if ($companyForm->load(\Yii::$app->getRequest()->post())) {
            $companyService = new CompanyService();
            $companyService->save($companyForm);
        }

        return $this->render('index', [
            'isCompany' => true,
            'companyForm' => $companyForm,
        ]);
    }

    /**
     * Shows User tab
     *
     * @return string
     */
    public function actionUser()
    {
        $userForm = new UserForm();
        return $this->render('index', [
            'isUser' => true,
            'userForm' => $userForm
        ]);
    }

    /**
     * Shows Investigation(Applicant) tab
     *
     * @return string
     */
    public function actionInvestigation()
    {
        return $this->render('index', [
            'isInvestigation' => true,
        ]);
    }
}