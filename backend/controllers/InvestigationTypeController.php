<?php


namespace backend\controllers;


use common\models\InvestigationType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class InvestigationTypeController extends Controller
{
    /**
     * Shows list of types
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => InvestigationType::find()]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
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
                $session->setFlash('success', 'Type was successfully added');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type was not added');
            }
        }

        return $this->render('create', ['model' => $model]);
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
                $session->setFlash('success', 'Type was successfully updated');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type was not updated');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionViewType()
    {

    }

    public function actionDelete()
    {

    }

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
}