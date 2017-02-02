<?php

namespace backend\controllers;

use backend\actions\DownloadAction;
use backend\behaviors\RememberUrlBehavior;
use backend\models\File;
use backend\models\FileUpload;
use backend\models\Investigation;
use backend\models\search\FileSearch;
use common\helpers\Url;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index'],
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
     * @param null $id
     * @param null $parent
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
            if (!empty($parent)) {
                $parent = $parent->citrix_id;
            }
        }
        $uploadModel = new FileUpload;
        if (!empty($id) && !empty($parent)) {
            $searchModel = new FileSearch(['scenario' => FileSearch::SCENARIO_APP]);
        } else {
            $searchModel = new FileSearch;
        }
        if (!empty($parent)) {
            $uploadModel->parent = $parent;
            $searchModel->parent = $parent;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        $renderParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
            'investigation' => $investigation,
        ];
        return $this->render('index', $renderParams);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param null $parent
     * @return mixed
     */
    public function actionUpload($parent = null)
    {
        if (Yii::$app->user->can('admin') || (!Yii::$app->user->can('admin') &&
                Yii::$app->user->can('employee', ['investigation' => Investigation::findOne(['citrix_id' => $parent])]))
        ) {
            try {
                $model = new FileUpload(['parent' => $parent]);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'File added successfully');
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        if (!empty($parent)) return $this->actionIndex(Investigation::findOne(['citrix_id' => $parent]));
        return $this->actionIndex();
    }

    /**
     * Archive an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        $model->detachBehavior('uploadBehavior');
        $investigation = $model->investigations;
        try {
            if (Yii::$app->user->can('admin') || (!Yii::$app->user->can('admin') && Yii::$app->user->can('employee', ['investigation' => $investigation]))) {
                $model->archive();
                Yii::$app->session->setFlash('success', 'Archived successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Permission denied');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if (!empty($investigation)) return $this->actionIndex($investigation->id);
        return $this->actionIndex();
    }

}
