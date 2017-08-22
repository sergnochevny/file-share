<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\behaviors\RememberUrlBehavior;
use backend\models\Company;
use backend\models\Investigation;
use backend\models\search\InvestigationSearch;

/**
 * InvestigationController implements the CRUD actions for Investigation model.
 */
class InvestigationController extends Controller
{

    public $layout = 'content';

    /**
     * @return array
     */
    public static function prepareRenderInvestigations()
    {
        $company = null;
        $searchModel = new InvestigationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        $renderParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        return $renderParams;
    }

    /**
     * Finds the Investigation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Investigation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Investigation::findOne($id)) !== null) {
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
                'actions' => ['index'],
            ]
        ];
    }

    /**
     * Lists all Investigation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $renderParams = static::prepareRenderInvestigations();
        return $this->render('index', $renderParams);
    }

    /**
     * Archive an existing Investigation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        try {
            $model = $this->findModel($id);
            if ($model->archive()) {
                Yii::$app->session->setFlash('success', 'Investigation ' . $model->name . ' is archived');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->actionIndex();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionComplete($id)
    {
        try {
            $model = $this->findModel($id);
            if ($model->complete()) {
                Yii::$app->session->setFlash('success', 'Investigation ' . $model->name . ' is completed.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->run('file/index', ['id' => $id]);
    }

}
