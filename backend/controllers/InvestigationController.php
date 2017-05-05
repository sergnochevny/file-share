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
            ],
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['complete'],
                        'roles' => ['superAdmin'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['complete'],
                        'roles' => ['client'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'complete'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['superAdmin', 'client']
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Investigation models.
     * @param null $parent
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
        $session = Yii::$app->getSession();
        try {
            $model = $this->findModel($id);
            $model->detachBehavior('citrixFolderBehavior');
            $model->archive();
            $session->setFlash('success', 'Archived successfully');
        } catch (\Exception $e) {
            $session->setFlash('error', $e->getMessage());
        }

        return $this->actionIndex();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionComplete($id)
    {
        $investigation = $this->findModel($id);
        $investigation->status = Investigation::STATUS_COMPLETED;
        if ($investigation->save(true, ['status'])) {
            Yii::$app->session->setFlash('success', 'Status has been changed');
        } else {
            Yii::$app->session->setFlash('error', 'Cannot change the status of applicant');
        }

        return $this->redirect(['/file', 'id' => $id]);
    }

    /**
     * @param mixed $parent
     * @return array
     */
    public static function prepareRenderInvestigations($parent = null)
    {
        $company = null;
        $searchModel = new InvestigationSearch();
        if (!(Yii::$app->user->can('admin'))) {
            $searchModel->parent = Yii::$app->user->identity->company->id;
            $company = Company::findOne($searchModel->parent);
            if(empty($company)) $searchModel->parent = 'no parent';
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
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

}
