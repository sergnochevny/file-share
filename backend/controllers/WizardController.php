<?php


namespace backend\controllers;


use backend\models\Company;
use backend\models\services\CompanyService;
use backend\models\forms\CompanyForm;
use backend\models\forms\UserForm;
use backend\models\services\UserService;
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
        $options = [
            'isCompany' => true,
            'companyForm' => $companyForm,
            'selected' => null,
        ];
        if (Yii::$app->request->isPost && $companyForm->load(\Yii::$app->getRequest()->post())) {
            /** @var CompanyService $companyService */
            $companyService = Yii::createObject(CompanyService::class);
            if ($companyService->save($companyForm)){
                unset($companyForm );
                $companyForm = Yii::createObject(CompanyForm::class);
                $options['companyForm'] = $companyForm;
                $options['selected'] = $companyService->getCompany()->id;
            } else {
                $this->setFlash('error', 'The company was not saved');
            }
        }

        return $this->render('index', $options);
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
                //@todo set company id for another users who works with current user (client)
            }

            //new user with admin role can't have company
            if ($userForm->role == 'admin') {
                $userForm->company_id = null;
            }

            /** @var UserService $userService */
            $userService = Yii::createObject(UserService::class);
            if ($userService->save($userForm)) {
                $userForm = Yii::createObject(UserForm::class);
            } else {
                $this->setFlash('error', 'The user was not created');
            }
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
        return !Yii::$app->getUser()->can('admin');
    }

    /**
     * @return bool
     */
    private function isAdmin()
    {
        return Yii::$app->getUser()->can('admin');
    }

    /**
     * @param $type
     * @param $message
     * @return void
     */
    private function setFlash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type, $message);
    }
}