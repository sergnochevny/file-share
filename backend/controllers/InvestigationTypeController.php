<?php


namespace backend\controllers;


use backend\behaviors\RememberUrlBehavior;
use common\components\BaseController;
use common\models\InvestigationType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class InvestigationTypeController extends BaseController
{

    public $layout = 'content';

    /**
     * @param int $id
     * @return InvestigationType
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        $type = InvestigationType::findOne($id);
        if ($type) {
            return $type;
        }

        throw new NotFoundHttpException('Type not found');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index','update','create'],
            ],
        ];
    }

    /**
     * Shows list of types
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => InvestigationType::find()]);
        return $this->smartRender('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Creates new type
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->getRequest();
        $session = Yii::$app->getSession();
        $model = new InvestigationType();
        if ($request->isPost) {
            if ($model->load($request->post()) && $model->save()) {
                $session->setFlash('success', 'Type has been successfully added');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type hasn\'t been added');
            }
        }

        return $this->smartRender('create', ['model' => $model]);
    }

    /**
     * Updates type
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->getRequest();
        $session = Yii::$app->getSession();
        $model = $this->findModel($id);
        if ($request->isPost) {
            if ($model->load($request->post()) && $model->save()) {
                $session->setFlash('success', 'Type has been successfully updated');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type hasn\'t been updated');
            }
        }

        return $this->smartRender('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', 'Type has been successfully removed');
        return $this->redirect(['index']);
    }
}