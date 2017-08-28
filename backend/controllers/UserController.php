<?php

namespace backend\controllers;

use ait\rbac\Item;
use backend\models\services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\behaviors\RememberUrlBehavior;
use backend\models\search\UserSearch;
use backend\models\User;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        $searchModel = new UserSearch();//var_dump(Yii::$app->request->queryParams);exit;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

    /**
     * Shows only users who work on protus3
     *
     * @return mixed
     */
    public function actionProtus()
    {
        $this->setAdditionalQueryParams(['role_type' => Item::TYPE_ROLE]);
        return $this->runAction('index');
    }

    /**
     * Shows all users who do not belong to protus3 (i.e protus3's clients)
     *
     * @return mixed
     */
    public function actionOthers()
    {
        $this->setAdditionalQueryParams(['role_type' => Item::TYPE_CUSTOM_ROLE]);
        return $this->runAction('index');
    }

    private function setAdditionalQueryParams(array $params)
    {
        $rq = Yii::$app->request;
        $params = array_merge($rq->queryParams, $params);
        $rq->setQueryParams($params);
    }
}
