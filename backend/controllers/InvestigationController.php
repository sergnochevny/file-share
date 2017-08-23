<?php

namespace backend\controllers;

use backend\behaviors\RememberUrlBehavior;
use backend\models\Investigation;
use backend\models\search\InvestigationSearch;
use backend\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\InvestigationType;


/**
 * InvestigationController implements the CRUD actions for Investigation model.
 */
class InvestigationController extends BaseController
{

    public $layout = 'content';

    /**
     * @param mixed $parent
     * @return array
     */
    public static function prepareRenderInvestigations($parent = null)
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
     * @param null $parent
     * @return mixed
     */
    public function actionIndex($parent = null)
    {
        $renderParams = static::prepareRenderInvestigations($parent);
        return $this->render('index', $renderParams);
    }

    public function actionCreate($companyId = null)
    {
        $rq = Yii::$app->getRequest();
        $isUpdate = false;
        $investigation = new Investigation();

        try {
            // fills defaults investigation types
            // for selected company when selecting in dropdown
            if ($companyId !== null && User::isSuperAdmin()) {
                $investigation->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);
                $investigation->company_id = $companyId;
            }

            // fills defaults investigation types
            // when client creates a new investigation
            if (User::isClient()) {
                $companyId = User::getIdentity()->company->id;
                $investigation->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);
            }

            if ($rq->isPost && $investigation->load($rq->post())) {
                if (User::isClient()) {
                    //set company_id before validation in save
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

        return $this->smartRender('//wizard/index', [
            'isInvestigation' => true,
            'investigationForm' => $investigation,
            'selected' => $investigation->company_id,
            'isUpdate' => $isUpdate,
            'investigationTypes' => InvestigationType::find()->select('name')->indexBy('id')->column(),
        ]);
    }

    public function actionUpdate($id, $companyId = null)
    {
        $rq = Yii::$app->getRequest();
        $isUpdate = true;

        try {
            $investigation = Investigation::findOne($id);
            if ($investigation === null) {
                $investigation = new Investigation();
                throw new UserException('The applicant does not exits');
            }

            // fills defaults investigation types
            // for selected company when selecting in dropdown
            if ($companyId !== null && User::isSuperAdmin()) {
                $investigation->investigationTypeIds = InvestigationType::getDefaultIdsForCompanyId($companyId);
                $investigation->company_id = $companyId;
            }

            if ($rq->isPost && $investigation->load($rq->post())) {
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

        return $this->smartRender('//wizard/index', [
            'isInvestigation' => true,
            'investigationForm' => $investigation,
            'selected' => $investigation->company_id,
            'isUpdate' => $isUpdate,
            'investigationTypes' => InvestigationType::find()->select('name')->indexBy('id')->column(),
        ]);
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

        return $this->run('file/index', ['id' => $id]);
    }

}
