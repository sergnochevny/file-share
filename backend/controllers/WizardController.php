<?php


namespace backend\controllers;


use backend\models\Company;
use backend\models\forms\InvestigationForm;
use backend\models\forms\UserForm;
use backend\models\services\InvestigationService;
use backend\models\services\UserService;
use backend\models\User;
use yii\web\BadRequestHttpException;
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

    /**
     * Shows Company tab
     *
     * @param string $id
     * @return string
     */
    public function actionCompany($id = null)
    {
        $company = Company::create($id);
        $request = Yii::$app->getRequest();

        $options = [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => null,
            'isUpdate' => false,
        ];

        if ($request->isPost && $company->load($request->post()) && $company->save()) {
            $options['companyForm'] = $company;
            $options['selected'] = $company->id;
            $options['isUpdate'] = true;
        }

        return $this->smartRender('index', $options);
    }

    /**
     * Gets info about company by id
     *
     * @param null $id
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCompanyInfo($id = null)
    {
        $request = Yii::$app->getRequest();
        $id = (int) $id;
        if ($id > 0 && $request->isPjax && $company = Company::findOne($id)) {

            return $this->renderAjax('index', [
                'isCompany' => true,
                'companyForm' => $company,
                'selected' => $company->id,
                'isUpdate' => true,
            ]);
        }

        throw new BadRequestHttpException();
    }

    /**
     * Shows User tab
     *
     * @param null $id
     * @return string
     */
    public function actionUser($id = null)
    {
        /** @var UserForm $userForm */
        $userForm = Yii::createObject(UserForm::class);
        /** @var UserService $userService */
        $userService = Yii::createObject(UserService::class, [User::create($id)]);
        $request = Yii::$app->getRequest();

        if ($request->isPost
            && $userForm->load($request->post())
            && $userForm->validate()
        ) {
            if ($this->isClient()) {
                //explicitly set role if client creates another user
                $userForm->role = 'client';
                //@todo set company id for another users who works with current user (client)
            }

            //new user with admin role can't have company
            if ($userForm->role == 'admin') {
                $userForm->company_id = null;
            }

            if ($userService->save($userForm)) {
                $userForm = Yii::createObject(UserForm::class);
            } else {
                $this->setFlash('error', 'The user was not created');
            }
        }

        return $this->smartRender('index', [
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
        /** @var InvestigationForm $investigationForm */
        $investigationForm = Yii::createObject(InvestigationForm::class);
        $request = Yii::$app->getRequest();

        if (
            $request->isPost
            && $investigationForm->load($request->post())
            && $investigationForm->validate()
        ) {
            /** @var InvestigationService $service */
            $service = Yii::createObject(InvestigationService::class);
            if ($service->save($investigationForm)) {
                $investigationForm = Yii::createObject(InvestigationForm::class);
            } else {
                $this->setFlash('error', 'The applicant was not saved');
            }
        }

        return $this->smartRender('index', [
            'isInvestigation' => true,
            'investigationForm' => $investigationForm,
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
        $companyId = isset($depDrops['company-list']) ? (int)$depDrops['company-list'] : false;

        if ($companyId) {
            $company = Company::findOne($companyId);
            /** @var array $userList */
            $userList = $company->getUsers()->select(['id', 'username as name'])->asArray()->all();

        }

        return ['output' => $userList, 'selected' => ''];
    }

    /**
     * @param $view
     * @param array $viewData
     * @return string
     */
    private function smartRender($view, array $viewData)
    {
        return Yii::$app->getRequest()->isPjax
            ? $this->renderAjax($view, $viewData)
            : $this->render($view, $viewData);
    }
}