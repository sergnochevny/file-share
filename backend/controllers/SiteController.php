<?php
namespace backend\controllers;


use backend\models\forms\PasswordResetForm;
use backend\models\forms\PasswordResetRequestForm;
use backend\models\forms\RestorePasswordRequestForm;
use Yii;
use common\helpers\Url;
use yii\base\Model;
use yii\bootstrap\Html;
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
        Url::remember(Yii::$app->request->url);
        if (Yii::$app->user->can('admin')) {
            return $this->render('index');
        } else {
            $renderParams = InvestigationController::prepareRenderInvestigations();
            return $this->render('client', $renderParams);
        }
    }

    public function actionWizard()
    {
        Url::remember(Yii::$app->request->url);
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

        Url::remember(Yii::$app->request->url);
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $token = $model->generateRecoveryToken();
            echo Url::to(['/site/password-reset', 'token' => $token], true);
        }

        return $this->render('restore-password-request', ['model' => $model]);
    }

    /**
     * Password reset action
     *
     * @param $token
     * @return string
     */
    public function actionPasswordReset($token = null)
    {
        $this->layout = 'main-login';
        $model = null;
        if (!empty($token)) {
            try{
                $model = new PasswordResetForm($token);

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                    $model->resetPassword();
                    $notification = 'You password has been updated!';

                    Yii::$app->session->setFlash('alert', [
                        'body' => $notification,
                        'options' => ['class' => 'success'],
                    ]);

                    return $this->redirect(['login']);

                }
            } catch (\Exception $e){
                Yii::$app->session->setFlash('alert', [
                    'body' => $e->getMessage(),
                    'options' => ['class' => 'error'],
                ]);
            }
        } else {
            return $this->redirect(['/']);
        }

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
