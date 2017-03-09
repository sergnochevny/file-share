<?php


namespace backend\controllers;


use common\models\InvestigationType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class InvestigationTypeController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => InvestigationType::find()]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionAddType()
    {

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