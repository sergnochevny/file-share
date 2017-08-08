<?php


namespace backend\controllers;


use backend\behaviors\RememberUrlBehavior;
use common\models\InvestigationType;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class InvestigationTypeController extends Controller
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
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                    [
                        //all actions
                        'allow' => true,
                        'roles' => ['superAdmin']
                    ],
                ]
            ],
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
                $session->setFlash('success', 'Type has been successfully added');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type hasn\'t been added');
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
                $session->setFlash('success', 'Type has been successfully updated');
                return $this->redirect(['index']);

            } else {
                $session->setFlash('danger', 'Type hasn\'t been updated');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionRemove($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', 'Type has been successfully removed');
        return $this->redirect(['index']);
    }
}