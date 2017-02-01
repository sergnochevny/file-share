<?php
namespace backend\controllers;


use backend\models\forms\PasswordResetRequestForm;
use backend\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\forms\LoginForm;
use yii\web\NotFoundHttpException;

/**
 * Profile controller
 */
class ProfileController extends Controller
{


    /**
     * Displays profile index.
     *
     * @param $username
     * @return string
     */
    public function actionIndex($username)
    {
        $model = $this->findModel($username)->profile;
        return $this->render('index', ['model' => $model]);
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
