<?php
namespace backend\controllers;


use backend\behaviors\RememberUrlBehavior;
use backend\models\forms\LoginForm;
use backend\models\forms\PasswordResetForm;
use backend\models\forms\RestorePasswordRequestForm;
use backend\models\Graph;
use backend\models\Statistics;
use common\helpers\Url;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    const EMAIL_USER = 'email_user';
    private $resetUrl;

    /**
     * Shows index page for admins
     * @return string
     */
    protected function renderIndex()
    {
        $statistics = new Statistics();
        $statistics->load(Yii::$app->request->post());

        $interval = new \DateInterval('P30D');
        $step = new \DateInterval('P1D');
        $graph = new Graph($interval, $step);

        return $this->render('index', [
            'stat' => $statistics,
            'graph' => $graph,
        ]);
    }

    /**
     * @return mixed
     */
    protected function getResetUrl()
    {
        return $this->resetUrl;
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
                    'logout' => ['post'],
                ],
            ],
            'remember' => [
                'class' => RememberUrlBehavior::className(),
                'actions' => ['index'],
            ],
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'restore-password-request', 'password-reset'],
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                ]
            ]
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
        if (Yii::$app->user->can('admin')) {
            return $this->renderIndex();
        } else {
            $renderParams = InvestigationController::prepareRenderInvestigations();
            return $this->render('client', $renderParams);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) $this->goHome();

        $this->layout = 'main-login';
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
        if (Yii::$app->user->isGuest) $this->goHome();

        $this->layout = 'main-login';
        $model = new RestorePasswordRequestForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->resetUrl = Url::to(['/site/password-reset', 'token' => $model->generateRecoveryToken()], true);
            $this->trigger(self::EMAIL_USER);
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
        if (Yii::$app->user->isGuest) $this->goHome();

        $this->layout = 'main-login';
        $model = null;
        if (!empty($token)) {
            try {
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
            } catch (\Exception $e) {
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
