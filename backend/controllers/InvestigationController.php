<?php

namespace backend\controllers;

use common\models\Company;
use common\models\User;
use Yii;
use backend\models\Investigation;
use backend\models\search\InvestigationSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvestigationController implements the CRUD actions for Investigation model.
 */
class InvestigationController extends Controller
{

    public static function prepareRenderInvestigations($parent = null)
    {
        $company = null;
        $searchModel = new InvestigationSearch();
        if (!(Yii::$app->user->can('admin'))) {
            $searchModel->parent = Yii::$app->user->identity->company->id;
            $company = Company::findOne($searchModel->parent);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        Url::remember(Yii::$app->request->url, 'back');
        $renderParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        if (!empty($company)) $renderParams['company'] = $company;
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
        ];
    }

    /**
     * Lists all Investigation models.
     * @return mixed
     */
    public function actionIndex($parent = null)
    {
        $renderParams = static::prepareRenderInvestigations($parent);
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
        $this->findModel($id)->archive();
        return $this->redirect(['index']);
    }

}
