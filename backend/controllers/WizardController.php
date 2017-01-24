<?php


namespace backend\controllers;


use backend\models\Company;
use backend\models\CompanyService;
use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use yii\web\Controller;
use Yii;
use yii\web\Response;

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
        /** @var CompanyForm $companyForm */
        $companyForm = Yii::createObject(CompanyForm::class);
        if ($companyForm->load(\Yii::$app->getRequest()->post())) {
            /** @var CompanyService $companyService */
            $companyService = Yii::createObject(CompanyService::class);
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


    /**
     * list users in company
     */
    public function actionCompanyUsers()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $userList = [];
        $companyId = (int) Yii::$app->getRequest()->post('company-list');
        if ($companyId) {
            $company = Company::findOne($companyId);
            /** @var array $userList */
            $userList = $company->getUsers()->select(['id', 'username'])->asArray()->all();
            $userList = array_column($userList, 'username', 'id');

        }

        return ['output' => $userList];
    }
}