<?php

namespace backend\controllers;

use ait\utilities\helpers\Url;
use backend\actions\DownloadAction;
use backend\behaviors\RememberUrlBehavior;
use backend\behaviors\VerifyPermissionBehavior;
use backend\models\File;
use backend\models\FileUpload;
use backend\models\Investigation;
use backend\models\MultiDownload;
use backend\models\search\FileSearch;
use backend\models\User;
use common\components\PermissionController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends PermissionController
{

    public $layout = 'content';

    private function prepareMultiUploadResponse(FileUpload $model)
    {
        $item = [
            'id' => $model->model->id,
            'update' => $model->update,
            'name' => $model->file->name,
            'type' => FileUpload::fileExt($model->model->type),
            'size' => $model->file->size,
        ];
        if (Yii::$app->user->can('file.delete')) {
            $item['deleteUrl'] = Url::to(['/file/delete', 'id' => $model->model->id], true);
        };
        if (Yii::$app->user->can('file.download') ||
            (
                !empty($investigation) &&
                Yii::$app->user->can('employee', ['investigation' => $investigation])
            ) ||
            Yii::$app->user->can('employee', ['allfiles' => $model->model->parents->parent])
        ) {
            $item['downloadUrl'] = Url::to(['/file/download', 'id' => $model->model->citrix_id], true);
        };
        if (Yii::$app->user->can('file.archive') ||
            (
                !empty($investigation) &&
                Yii::$app->user->can('employee', ['investigation' => $investigation])
            )
        ) {
            $item['archiveLabel'] = User::isClient() ? 'Remove' : 'Archive';
            $item['archiveUrl'] = Url::to(['/file/archive', 'id' => $model->model->id], true);
        }
        $item['width'] = isset($item['deleteUrl']) ? 220 : 150;

        return $item;
    }

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
     * @return mixed
     * @internal param null $parent
     */
    public function actionIndex($id = null)
    {
        $investigation = null;
        if (!empty($id)) {
            $investigation = Investigation::findOne($id);
            if (!empty($investigation)) {
                $parent = $investigation->citrix_id;
            } else {
                $parent = 'no investigation';
            }
        } else {
            $parent = File::findOne(['parent' => 'root']);
            if (!empty($parent)) {
                $parent = $parent->citrix_id;
            }
        }
        $parameters = Yii::$app->request->queryParams;
        $uploadModel = new FileUpload();
        $searchModel = new FileSearch();
        if (!empty($parent)) {
            $uploadModel->parent = $parent;
            $searchModel->parent = $parent;
        }

        $dataProvider = $searchModel->search($parameters);
        $dataProvider->pagination->pageSize = $searchModel->pagesize;

        return $this->smartRender('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
            'investigation' => $investigation,
        ]);
    }

    /**
     * @param null $parent
     * @return array
     */
    public function actionMultiUpload($parent = null)
    {
        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $model = new FileUpload(['parent' => $parent]);
        $parentFile = File::findOne(['file.citrix_id' => $parent]);
        $investigation = Investigation::findOne(['investigation.citrix_id' => $parent]);
        if ($this->verifyPermission(
            VerifyPermissionBehavior::EVENT_VERIFY_FILE_MUPLOAD_PERMISSION,
            ['model' => $parentFile, 'investigation' => $investigation]
        )) {
            try {
                if ($model->save()) {
                    $response['files'][] = $this->prepareMultiUploadResponse($model);
                } else {
                    if ($model->hasErrors([$model->file])) {
                        $response[] = ['errors' => $model->getModelErrors()];
                    } else {
                        throw new HttpException(500, 'Could not upload file.');
                    }
                }

            } catch (\Exception $e) {
                $response[] = [
                    'error' => 'Unable to save file: ' . $e->getMessage()
                ];
                @unlink($model->file->tempName);
            }
        } else {
            $response[] = [
                'error' => 'Unable to save file: You haven`t got permissions on this action!'
            ];
            @unlink($model->file->tempName);
        }
        return $response;
    }

    /**
     * @param null $parent
     * @return mixed
     * @deprecated
     */
    public function actionUpload($parent = null)
    {
        $model = File::findOne(['file.citrix_id' => $parent]);
        $investigation = Investigation::findOne(['investigation.citrix_id' => $parent]);
        if ($this->verifyPermission(
            VerifyPermissionBehavior::EVENT_VERIFY_FILE_UPLOAD_PERMISSION,
            ['model' => $model, 'investigation' => $investigation]
        )) {
            try {
                $model = new FileUpload(['parent' => $parent]);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'File added successfully');
                }
            } catch (\Exception $e) {
                @unlink($model->file->tempName);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        } else {
            Yii::$app->session->setFlash('error', 'Unable to save file: You haven`t got permissions on this action!');
        }

        if (!empty($investigation)) {
            return $this->actionIndex($investigation->id);
        }
        return $this->actionIndex();
    }

    /**
     * Creates one archive with selected files and returns downloadUrl
     *
     * @param null $parent
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionMultiDownload($parent = null)
    {
        set_time_limit(0); //!important

        try {
            $investigation = Investigation::findOne(['investigation.citrix_id' => $parent]);
            $model = File::findOne(['file.citrix_id' => $parent]);

            if ($this->verifyPermission(
                VerifyPermissionBehavior::EVENT_VERIFY_FILE_ARCHIVE_PERMISSION,
                ['model' => $model, 'investigation' => $investigation]
            )) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model = new MultiDownload();
                $errorMessage = 'Something went wrong';
                if ($model->load(Yii::$app->request->post())) {
                    try {
                        $model->packIntoArchive();
                        return [
                            'downloadUrl' => Url::to([
                                'download-archive',
                                'name' => str_replace('.zip', '', $model->archiveFilename)
                            ])
                        ];

                    } catch (\Exception $exception) {
                        $errorMessage = $exception->getMessage();
                    }
                }
            } else {
                $errorMessage = 'Unable to download: You haven`t got permissions on this action!';
            }
        } catch (\Exception $e) {
            $errorMessage = 'Unable to download: ' . $e->getMessage();
        }

        throw new BadRequestHttpException($errorMessage);
    }

    /**
     * Archive an existing File model.
     * If archiving is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        try {
            $model = $this->findModel($id);
            $model->detachBehavior('uploadBehavior');
            $investigation = $model->investigation;
            $model = File::findOne(['file.citrix_id' => $id]);
            if ($this->verifyPermission(
                VerifyPermissionBehavior::EVENT_VERIFY_FILE_ARCHIVE_PERMISSION,
                ['model' => $model->parents, 'investigation' => $investigation]
            )) {
                $model->archive();
                Yii::$app->session->setFlash('success', 'Archived successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Permission denied');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        if (!empty($investigation)) {
            return $this->actionIndex($investigation->id);
        }
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
        try {
            $model = $this->findModel($id);
            $model->detachBehavior('uploadBehavior');
            $investigation = $model->investigation;
            $model->delete();
            Yii::$app->session->setFlash('success', 'Deleted successfully');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if (!empty($investigation)) {
            return $this->actionIndex($investigation->id);
        }
        return $this->actionIndex();
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
