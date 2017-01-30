<?php
namespace backend\controllers;


use backend\models\forms\PasswordResetForm;
use backend\models\forms\PasswordResetRequestForm;
use backend\models\forms\RestorePasswordRequestForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\forms\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [[
                    'actions' => ['login', 'restore-password-request', 'error'],
                    'allow' => true,
                ],[
                    'actions' => ['logout', 'index', 'wizard'],
                    'allow' => true,
                    'roles' => ['@'],
                ]]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Url::remember(Yii::$app->request->url, 'back');
        if(Yii::$app->user->can('admin')){
            return $this->render('index');
        }else{
            return $this->render('client');
        }
    }

    public function actionWizard()
    {
        Url::remember(Yii::$app->request->url, 'back');
        return $this->render('wizard');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        Url::remember(Yii::$app->request->url, 'back');
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Password reset request action
     *
     * @return string
     */
    public function actionRestorePasswordRequest()
    {
        $this->layout = 'main-login';
        $model = new RestorePasswordRequestForm;

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $token = $model->generateRecoveryToken();
        }

        return $this->render('restore-password-request', ['model' => $model]);
    }

    /**
     * Password reset action
     *
     * @return string
     */
    public function actionPasswordReset($token)
    {
        $this->layout = 'main-login';
        Url::remember(Yii::$app->request->url, 'back');
        $model = new PasswordResetForm;

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $user = $model->getUserByRecoveryToken();
            $user->setPassword($model->password);
            $user->password_reset_token = null;

            $user->save();

            $notification = 'You password has been updated!';

            Yii::$app->session->setFlash('alert', [
                'body' => $notification,
                'options' => ['class' => 'success'],
            ]);

            return $this->redirect(['login']);

        }

        return $this->render('regenerate-password', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
