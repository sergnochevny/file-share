<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\History;
use backend\behaviors\RememberUrlBehavior;
use backend\models\search\HistorySearch;

/**
 * HistoryController implements the CRUD actions for File model.
 */
class HistoryController extends Controller
{

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return History the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = History::findOne($id)) !== null) {
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
                    'recover' => ['POST'],
                ],
            ],
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index'],
            ],
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['recover'],
                        'allow' => true,
                        'roles' => ['superAdmin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single File model.
//     * @param string $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//        return $this->render('view', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Company model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//        return $this->redirect(['index']);
//    }

    public function actionRecover($id)
    {
        try{
            $model = $this->findModel($id);
            $model->recover();
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Entry has been recovered successful');
            }
        } catch (\Exception $e ){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->run('index');
    }
}