<?php

namespace backend\controllers;

use backend\actions\DownloadAction;
use backend\behaviors\RememberUrlBehavior;
use backend\behaviors\VerifyPermissionBehavior;
use backend\models\File;
use backend\models\FileUpload;
use backend\models\Investigation;
use backend\models\MultiDownload;
use backend\models\search\FileSearch;
use common\components\PermissionController;
use common\helpers\Url;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends PermissionController
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
                    'multi-download' => ['POST'],
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
                        'actions' => ['download', 'download-archive', 'multi-download', 'upload', 'index', 'archive'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['admin', 'superAdmin'],
                    ]
                ]
            ],
            'permission' => VerifyPermissionBehavior::className()
        ];
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), ['download' => DownloadAction::className()]);
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
            $investigation = Investigation::findOne(['id' => $id]);
            if (!empty($investigation)) {
                $parent = $investigation->citrix_id;
            } else $parent = 'no investigation';
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
        //Save request params, except parent
        // if parent set then loads all files instead of investigation's files
        /** @var Request $rq */
        $params = Yii::$app->request->queryParams;
        $params['parent'] = $parent;
        $params['id'] = $id;

        $dataProvider = $searchModel->search($params);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;
        $renderParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
            'investigation' => $investigation,
        ];
        if (Yii::$app->request->isAjax)
            return $this->renderAjax('index', $renderParams);
        return $this->render('index', $renderParams);
    }

    public function actionUpload($parent = null)
    {
        if ($this->verifyPermission(VerifyPermissionBehavior::EVENT_VERIFY_FILE_PERMISSION,
            ['investigation' => Investigation::findOne(['citrix_id' => $parent])])
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

        $inv = Investigation::findOne(['citrix_id' => $parent]);

        if (!empty($parent)) return $this->actionIndex($inv->id);
        return $this->actionIndex();
    }

    /**
     * Archive an existing File model.
     * If archiving is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        $model->detachBehavior('uploadBehavior');
        $investigation = $model->investigation;

        try {
            if ($this->verifyPermission(VerifyPermissionBehavior::EVENT_VERIFY_FILE_PERMISSION,
                ['investigation' => $investigation])
            ) {
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

    /**
     * Delete an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->detachBehavior('uploadBehavior');
        $investigation = $model->investigation;
        try {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Deleted successfully');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if (!empty($investigation)) return $this->actionIndex($investigation->id);
        return $this->actionIndex();
    }

    /**
     * Creates one archive with selected files and returns downloadUrl
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionMultiDownload()
    {
        set_time_limit(0); //!important

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new MultiDownload();
        $errorMessage = 'Something went wrong';

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->packIntoArchive();
                return ['downloadUrl' => Url::to(['download-archive',
                        'name' => str_replace('.zip', '', $model->archiveFilename)
                    ])
                ];

            } catch (\Exception $exception) {
                $errorMessage = $exception->getMessage();
            }
        }

        throw new BadRequestHttpException($errorMessage);
    }

    /**
     * @param $name
     * @return Response
     */
    public function actionDownloadArchive($name)
    {
        set_time_limit(0); //!important

        if (empty($name)) {
            return $this->redirect(['/investigation/index']);
        }

        $name = $name . '.zip';
        $path = Yii::getAlias('@webroot/temp/' . $name);

        if (!is_file($path) || !is_readable($path)) {
            return $this->redirect(['/investigation/index']);
        }

        Yii::$app->response->setDownloadHeaders($name, 'application/zip', false, filesize($path));

        Yii::$app->response->sendFile($path)->send();

        if (is_writable($path)) {
            unlink($path);
        }
    }
}
