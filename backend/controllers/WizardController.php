<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\forms\UserForm;
use backend\models\Investigation;
use backend\models\services\UserService;
use backend\models\User;
use Yii;
use yii\base\UserException;
use yii\web\Controller;
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
     * @param string $id
     * @return string
     * @throws UserException
     */
    public function actionCompany($id = null)
    {
        $request = Yii::$app->getRequest();
        /** @var Company $company */
        $company = Company::create($id);
        if (null === $company) {
            throw new UserException('The company does not exists');
        }
        $isUpdate = $company->id > 0 ? true : false;

        if ($request->isPost && $company->load($request->post())) {
            if ($company->save()) {
                $this->setFlashMessage('success', 'company', $isUpdate);

            } else {
                $this->setFlashMessage('error', 'company', $isUpdate);
            }
        }

        return $this->smartRender('index', [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => $company->id,
            'isUpdate' => $isUpdate,
        ]);
    }

    /**
     * Shows User tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     */
    public function actionUser($id = null)
    {
        $request = Yii::$app->getRequest();
        /** @var User $identity current user */
        $identity = Yii::$app->getUser()->getIdentity();
        /** @var User $user */
        $user = User::create($id);
        if (null === $user) {
            throw new UserException('The user does not exists');
        }

        /** @var UserForm $userForm */
        $userForm = Yii::createObject(UserForm::class);
        /** @var UserService $userService */
        $userService = Yii::createObject(UserService::class, [$user]);

        $options = [
            'isUser' => true,
            'userForm' => $userForm,
            'isUpdate' => false,
            'selectedUser' => null,
        ];
        if ($user->id) {
            $userService->populateForm($userForm);
            $options['isUpdate'] = true;
            $options['selectedUser'] = $user->id;
        } else {
            $userForm->scenario = UserForm::SCENARIO_CREATE;
        }

        if ($request->isPost && $userForm->load($request->post())) {
            if ($identity->isClient()) {
                //explicitly set role if client creates another user
                $userForm->role = 'client';
            }
            //new user with admin role can't have company
            if ($userForm->role == 'admin') {
                $userForm->company_id = null;
            }

            if ($userForm->validate() && $userService->save($userForm)) {
                //reset password fields
                $userForm->password = $userForm->password_repeat = null;
                $options['isUpdate'] = true;
                $options['selectedUser'] = $user->id;
                $this->setFlashMessage('success', 'user', $options['isUpdate']);

            } else {
                $this->setFlashMessage('error', 'user', $options['isUpdate']);
            }
        }

        return $this->smartRender('index', $options);
    }

    /**
     * Shows Investigation(Applicant) tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     */
    public function actionInvestigation($id = null)
    {
        $request = Yii::$app->getRequest();
        /** @var Investigation $investigation */
        $investigation = Investigation::create($id);
        if (null === $investigation) {
            throw new UserException('The investigation does not exits');
        }
        $isUpdate = $investigation->id > 0 ? true : false;

        if (!Yii::$app->user->can('admin')) {
            $investigation->company_id = Yii::$app->user->identity->company->id;
        }

        if ($request->isPost && $investigation->load($request->post())) {
            if ($investigation->save()) {
                $this->setFlashMessage('success', 'applicant', $isUpdate);
                return $this->redirect(['/file', 'id' => $investigation->id]);

            } else {
                $this->setFlashMessage('error', 'applicant', $isUpdate);
            }
        }

        return $this->smartRender('index', [
            'isInvestigation' => true,
            'investigationForm' => $investigation,
            'selected' => $investigation->company_id,
            'isUpdate' => $investigation->id > 0 ? true : false,
        ]);
    }

    /**
     * list users in company || admins for dep dropdown
     *
     * @return string JSON output
     */
    public function actionCompanyUsers()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $userList = [];
        $depDrops = Yii::$app->getRequest()->post('depdrop_all_params');
        $companyId = isset($depDrops['company-list']) ? (int)$depDrops['company-list'] : false;
        $userRole = isset($depDrops['user-role']) ? $depDrops['user-role'] : false;

        if ('admin' == $userRole) {
            $userList = User::findByRole($userRole)->select(['id', 'username as name'])->asArray()->all();
        } else if ($companyId) {
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
        return Yii::$app->getRequest()->isPjax ? $this->renderAjax($view, $viewData) : $this->render($view, $viewData);
    }

    /**
     * @param $type
     * @param $entity
     * @param $isUpdate
     * @param string|null $message
     */
    private function setFlashMessage($type, $entity, $isUpdate = false, $message = null)
    {
        $action = $isUpdate ? 'updated' : 'created';
        if (null === $message) {
            $message = ($type == 'success')
                ? "The $entity was $action successfully"
                : "The $entity was not $action";
        }

        Yii::$app->getSession()->setFlash($type, $message);
    }

}