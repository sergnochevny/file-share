<?php
namespace backend\controllers;


use backend\models\PasswordResetRequestForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;

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
            'access' => array(
                'class' => AccessControl::className(),
                'rules' => array(
                    array(
                        'actions' => array('login', 'password-reset', 'error'),
                        'allow' => true,
                    ),
                    array(
                        'actions' => array('logout', 'index', 'wizard'),
                        'allow' => true,
                        'roles' => array('@'),
                    ),
                ),
            ),
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
        Url::remember();
        return $this->render('index');
    }

    public function actionWizard()
    {
        Url::remember();
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

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Url::remember();
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
     * Password reset action
     *
     * @return string
     */
    public function actionPasswordReset()
    {
        Url::remember();
        $model = new PasswordResetRequestForm();
        return $this->render('password-reset', ['model' => $model]);
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
