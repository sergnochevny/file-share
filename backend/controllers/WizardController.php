<?php


namespace backend\controllers;


use backend\models\Company;
use backend\models\CompanyService;
use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use backend\models\UserService;
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
        /** @var UserForm $userForm */
        $userForm = Yii::createObject(UserForm::class);
        if ($userForm->load(\Yii::$app->getRequest()->post())) {
            if ($this->isClient()) {
                //explicitly set role if client creates another user
                $userForm->role = 'client';
            }

            /** @var UserService $userService */
            $userService = Yii::createObject(UserService::class);
            $userService->save($userForm);
        }

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
     *
     * @return string JSON output
     */
    public function actionCompanyUsers()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $userList = [];
        $depDrops = Yii::$app->getRequest()->post('depdrop_all_params');
        $companyId = isset($depDrops['company-list']) ? (int) $depDrops['company-list'] : false;

        if ($companyId) {
            $company = Company::findOne($companyId);
            /** @var array $userList */
            $userList = $company->getUsers()->select(['id', 'username as name'])->asArray()->all();

        }

        return ['output' => $userList, 'selected'=>''];
    }

    /**
     * @return bool
     */
    private function isClient()
    {
        return Yii::$app->getUser()->can('client');
    }
}