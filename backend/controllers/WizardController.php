<?php

namespace backend\controllers;

use backend\models\Company;
use backend\models\forms\UserForm;
use backend\models\Investigation;
use backend\models\services\UserService;
use backend\models\User;
use backend\widgets\ActiveForm;
use common\components\BaseController;
use common\models\InvestigationType;
use Yii;
use yii\base\UserException;
use yii\web\Response;

/**
 * Class WizardController
 * @package backend\controllers
 */
class WizardController extends BaseController
{

    /**
     * @var string
     */
    public $layout = 'content';

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
        if ($id !== null) {
            return $this->run('/company/update', ['id' => $id]);
        }

        return $this->run('/company/create');
    }

    /**
     * Shows Company tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     * @deprecated
     */
    public function actionCompanyP($id = null)
    {
        if (User::isClient()) {
            $user = User::getIdentity();
            $id = $user->company->id;
        }

        $request = Yii::$app->getRequest();
        try {
            /** @var Company $company */
            $company = Company::create($id);
            if (null === $company) {
                throw new UserException('The company does not exists');
            }
            $isUpdate = $company->id > 0 ? true : false;

            //User cannot edit company, just only browse
            if ($request->isPost && !User::isClient() && $company->load($request->post())) {
                if ($company->save()) {
                    $this->setFlashMessage('success', 'company', $isUpdate);
                    $isUpdate = true;

                } else {
                    $this->setFlashMessage('error', 'company', $isUpdate);
                }
            }

        } catch (\Exception $e) {
            $this->setFlashMessage('error', 'company', $isUpdate, $e->getMessage());
        }

        return $this->smartRender('index', [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => $company->id,
            'isUpdate' => $isUpdate,
            'investigationTypes' => InvestigationType::find()->select('name')->indexBy('id')->column(),
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
        if ($id !== null) {
            return $this->run('/user/update', ['id' => $id]);
        }

        return $this->run('/user/create');
    }

    /**
     * Shows Admins tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     */
    public function actionAdmin($id = null)
    {
        if ($id !== null) {
            return $this->run('/admin/update', ['id' => $id]);
        }

        return $this->run('/admin/create');
    }

    /**
     * Shows User tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     * @deprecated
     */
    public function actionUserO($id = null)
    {
        $request = Yii::$app->getRequest();
        try {
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
                $userForm->scenario = UserForm::SCENARIO_UPDATE;
            } else {
                $userForm->scenario = UserForm::SCENARIO_CREATE;
            }

            if ($request->isPost && $userForm->load($request->post())) {
                if (User::isAdmin()) {
                    //admin can create only clients
                    $userForm->role = 'user';
                }
                //new user with admin role can't have company
                if ($userForm->role == 'admin' || $userForm->role == 'sadmin') {
                    $userForm->company_id = null;
                }

                if ($userForm->validate() && $userService->save($userForm)) {
                    $this->setFlashMessage('success', 'user', $options['isUpdate']);

                    //reset password fields
                    $userForm->password = $userForm->password_repeat = null;

                    $options['isUpdate'] = true;
                    $options['selectedUser'] = $user->id;
//                    $userForm->scenario = UserForm::SCENARIO_DEFAULT;

                } else {
                    $this->setFlashMessage('error', 'user', $options['isUpdate']);
                }
            }
        } catch (\Exception $e) {
            $this->setFlashMessage('error', null, null, $e->getMessage());
        }

        return $this->smartRender('index', $options);
    }

    /**
     * list users in company || admins for dep dropdown
     *
     * @return array
     */
    public function actionCompanyUsers()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $userList = [];
        $depDrops = Yii::$app->getRequest()->post('depdrop_all_params');
        $companyId = isset($depDrops['company-list']) ? (int)$depDrops['company-list'] : false;
        $adminRole = isset($depDrops['admin-role']) ? $depDrops['admin-role'] : false;

        if (!empty($adminRole)) {
            $userList = User::findByRole($adminRole)->select(['id', 'username as name'])->asArray()->all();
        } else {
            if ($companyId) {
                $company = Company::findOne($companyId);
                /** @var array $userList */
                $userList = $company->getUsers()->select(['id', 'username as name'])->asArray()->all();
            }
        }

        return ['output' => $userList, 'selected' => ''];
    }

    /**
     * Shows Investigation(Applicant) tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     */
    public function actionInvestigation($id = null, $companyId = null)
    {
        if ($id !== null) {
            return $this->run('/investigation/update', ['id' => $id, 'companyId' => $companyId]);
        }

        return $this->run('/investigation/create', ['companyId' => $companyId]);
    }

    /**
     * Shows Investigation(Applicant) tab
     *
     * @param string $id
     * @return string
     * @throws UserException
     * @deprecated
     */
    public function actionInvestigationO($id = null, $companyId = null)
    {
        $request = Yii::$app->getRequest();
        try {
            /** @var Investigation $investigation */
            $investigation = Investigation::create($id);
            if (null === $investigation) {
                throw new UserException('The applicant does not exits');
            }
            $isUpdate = $investigation->id > 0 ? true : false;

            // fills defaults investigation types
            // for selected company when selecting in dropdown
            if ($companyId !== null && User::isSuperAdmin()) {
                $investigation->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);
                $investigation->company_id = $companyId;
            }

            // fills defaults investigation types
            // when client creates a new investigation
            if (User::isClient() && $investigation->isNewRecord) {
                $companyId = User::getIdentity()->company->id;
                $investigation->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);
            }

            if ($request->isPost && $investigation->load($request->post())) {
                if (User::isClient()) {
                    $investigation->company_id = Yii::$app->user->identity->company->id;
                }

                if ($investigation->save()) {
                    $this->setFlashMessage('success', 'applicant', $isUpdate);
                    return $this->redirect(['/file', 'id' => $investigation->id]);

                } else {
                    $this->setFlashMessage('error', 'applicant', $isUpdate);
                }
            }
        } catch (\Exception $e) {
            $this->setFlashMessage('error', null, null, $e->getMessage());
        }


        return $this->smartRender('index', [
            'isInvestigation' => true,
            'investigationForm' => $investigation,
            'selected' => $investigation->company_id,
            'isUpdate' => $investigation->id > 0 ? true : false,
            'investigationTypes' => InvestigationType::find()->select('name')->indexBy('id')->column(),
        ]);
    }

    /**
     * @param $companyId
     * @return string
     */
    public function actionUpdateTypes($companyId)
    {
        $model = new Investigation();
        $model->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);

        return $this->smartRender('partials/_investigation-types', [
            'model' => $model,
            'types' => InvestigationType::find()->select('name')->indexBy('id')->column(),
            'form' => new ActiveForm(),
        ]);
    }

}