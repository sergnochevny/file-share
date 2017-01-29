<?php


namespace backend\controllers;


use backend\models\Company;
use backend\models\forms\UserForm;
use backend\models\Investigation;
use backend\models\services\UserService;
use backend\models\User;
use Yii;
use yii\web\Controller;
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
        /** @var Company $company */
        $company = Company::create($id);
        $request = Yii::$app->getRequest();

        if ($request->isPost && $company->load($request->post())) {
            $company->save();
        }

        return $this->smartRender('index', [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => $company->id,
            'isUpdate' => $company->id > 0 ? true : false,
        ]);
    }

    /**
     * Shows User tab
     *
     * @param string $id
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
     * @param string $id
     * @return string
     */
    public function actionInvestigation($id = null)
    {
        /** @var Investigation $investigation */
        $investigation = Investigation::create($id);
        $request = Yii::$app->getRequest();

        if ($request->isPost && $investigation->load($request->post()) && $investigation->save()) {
            return $this->redirect(['investigation/view', 'id' => $investigation->id]);
        }

        return $this->smartRender('index', [
            'isInvestigation' => true,
            'investigationForm' => $investigation,
            'selected' => $investigation->company_id,
            'isUpdate' => $investigation->id > 0 ? true : false,
        ]);
    }

    /**
     * list users in company for dep dropdown
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