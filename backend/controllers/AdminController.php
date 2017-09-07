<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace backend\controllers;

use ait\rbac\Item;
use backend\behaviors\RememberUrlBehavior;
use backend\models\forms\UserForm;
use backend\models\search\UserSearch;
use backend\models\services\UserService;
use backend\models\User;
use common\components\BaseController;
use Yii;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class AdminController extends BaseController
{

    public $layout = 'content';

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index', 'wizard'],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;

        return $this->smartRender('//user/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates user
     *
     * @return string
     */
    public function actionCreate()
    {
        $rq = Yii::$app->getRequest();
        $userForm = new UserForm([
            'scenario' => UserForm::SCENARIO_CREATE
        ]);
        $user = new User();

        $options = [
            'isAdmin' => true,
            'userForm' => $userForm,
            'isUpdate' => false,
            'selectedUser' => null,
        ];

        try {
            /** @var UserService $userService */
            $userService = Yii::createObject(UserService::class, [$user]);
            if ($rq->isPost && $userForm->load($rq->post())) {
                if ($userForm->validate() && $userService->save($userForm)) {
                    $this->setFlashMessage('success', 'user');

                    //reset password fields
                    $userForm->password = $userForm->password_repeat = null;

                    $options['isUpdate'] = true;
                    $options['selectedUser'] = $user->id;
//                    $userForm->scenario = UserForm::SCENARIO_UPDATE;

                } else {
                    $this->setFlashMessage('error', 'user');
                }
            }
        } catch (\Exception $e) {
            $this->setFlashMessage('error', null, null, $e->getMessage());
        }

        return $this->smartRender('//wizard/index', $options);
    }

    public function actionUpdate($id)
    {
        $rq = Yii::$app->getRequest();
        $userForm = new UserForm([
            'scenario' => UserForm::SCENARIO_UPDATE
        ]);

        $options = [
            'isUser' => true,
            'userForm' => $userForm,
            'isUpdate' => true,
            'selectedUser' => null,
        ];

        try {
            if ($user = User::findOne($id) === null) {
                throw new UserException('The user does not exists');
            }

            /** @var UserService $userService */
            $userService = Yii::createObject(UserService::class, [$user]);
            $userService->populateForm($userForm);
            $options['selectedUser'] = $user->id;

            if ($rq->isPost && $userForm->load($rq->post())) {
                if ($userForm->validate() && $userService->save($userForm)) {
                    $this->setFlashMessage('success', 'user', $options['isUpdate']);

                    //reset password fields
                    $userForm->password = $userForm->password_repeat = null;
                } else {
                    $this->setFlashMessage('error', 'user', $options['isUpdate']);
                }
            }

        } catch (\Exception $e) {
            $this->setFlashMessage('error', null, null, $e->getMessage());
        }

        return $this->smartRender('//wizard/index', $options);
    }

    /**
     * Archive an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class, [$model]);
        try {
            $service->delete();
            Yii::$app->session->setFlash('success', 'User deleted');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->actionIndex();
    }

}
