<?php

namespace backend\controllers;

use backend\models\User;
use backend\behaviors\RememberUrlBehavior;
use backend\models\Company;
use backend\models\search\CompanySearch;
use common\helpers\Url;
use common\models\InvestigationType;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\base\UserException;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends BaseController
{

    public $layout = 'content';

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
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $rq = Yii::$app->getRequest();
        //after create gives ability to update new created record
        $isUpdate = false;

        try {
            $company = new Company();
            if ($rq->isPost && $company->load($rq->post())) {
                if ($company->save()) {
                    $this->setFlashMessage('success', 'company', $isUpdate);
                    $isUpdate = true;

                } else {
                    $this->setFlashMessage('error', 'company', $isUpdate);
                }
            }
        } catch (\Exception $e){
            $this->setFlashMessage('error', 'company', $isUpdate, $e->getMessage());
        }

        return $this->smartRender('//wizard/index', [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => $company->id,
            'isUpdate' => $isUpdate,
            'investigationTypes' => $this->getListOfInvestigationTypes(),
        ]);

    }

    /**
     * @param $id
     * @return string
     * @throws UserException
     */
    public function actionUpdate($id)
    {
        $rq = Yii::$app->getRequest();
        //after create gives ability to update new created record
        $isUpdate = true;
        $company = null;

        $user = User::getIdentity();
        if ($user && $user->company) {
            $id = $user->company->id;
        }

        try {
            $company = Company::findOne($id);
            if ($company === null) {
                $company = new Company(); //to prevent NPE
                throw new UserException('The company does not exists');
            }

            if ($rq->isPost && $company->load($rq->post())) {
                if ($company->save()) {
                    $this->setFlashMessage('success', 'company', $isUpdate);
                    $isUpdate = true;

                } else {
                    $this->setFlashMessage('error', 'company', $isUpdate);
                }
            }

        } catch (\Exception $e){
            $this->setFlashMessage('error', 'company', $isUpdate, $e->getMessage());
        }

        return $this->smartRender('//wizard/index', [
            'isCompany' => true,
            'companyForm' => $company,
            'selected' => $company->id,
            'isUpdate' => $isUpdate,
            'investigationTypes' => $this->getListOfInvestigationTypes(),
        ]);

    }

    /**
     * Archive an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        try{
            $model->archive();
            Yii::$app->session->setFlash('success', 'Archived successfully');
        } catch (\Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->actionIndex();
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getListOfInvestigationTypes()
    {
        return InvestigationType::find()->select('name')->indexBy('id')->column();
    }
}
