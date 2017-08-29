<?php
namespace backend\controllers;


use backend\behaviors\RememberUrlBehavior;
use backend\models\User;
use common\components\BaseController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Profile controller
 */
class ProfileController extends BaseController
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
                    'delete' => ['post'],
                ],
            ],
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index'],
            ],
        ];
    }

    /**
     * Displays profile index.
     *
     * @param $username
     * @return string
     */
    public function actionIndex($username)
    {
        $model = $this->findModel($username)->profile;
        return $this->smartRender('index', ['model' => $model]);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $username
     * @return User
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($username)
    {
        if (($model = User::findOne(['username' => $username])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
