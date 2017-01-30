<?php

namespace backend\controllers;

use backend\actions\DownloadAction;
use backend\models\FileUpload;
use common\models\Investigation;
use Yii;
use common\models\File;
use backend\models\search\FileSearch;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return \common\models\File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
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
                    'upload' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['download'] = DownloadAction::className();
        return $actions;
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex($id = null, $parent = null)
    {
        $investigation = null;
        if (!empty($id) && empty($parent)) {
            $investigation = Investigation::findOne($id);
            if (!empty($investigation)) {
                $parent = $investigation->citrix_id;
            }
        } else {
            $parent = File::findOne(['parent' => 'root']);
            if (!empty($parent)) { $parent = $parent->citrix_id; }
        }
        $uploadModel = new FileUpload;
        if (!empty($id) && !empty($parent)) {
            $searchModel = new FileSearch(['scenario' => FileSearch::SCENARIO_APP]);
        } else {
            $searchModel = new FileSearch;
        }
        if(!empty($parent)){
            $uploadModel->parent = $parent;
            $searchModel->parent = $parent;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        Url::remember(Yii::$app->request->url, 'back');
        $renderParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
        ];
        if(!empty($investigation)) $renderParams['investigation'] = $investigation;
        return $this->render('index', $renderParams);
    }

    /**
     * Displays a single File model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember(Yii::$app->request->url, 'back');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new File();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpload($parent = null)
    {
        if(Yii::$app->user->can('admin') || (!Yii::$app->user->can('admin') && Yii::$app->user->can('employee',['parent'=>$parent]))){
        $model = new FileUpload(['parent'=>$parent]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        }
        }
        return $this->actionIndex();
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

}
