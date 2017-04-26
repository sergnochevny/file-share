<?php

namespace backend\controllers;

use backend\behaviors\RememberUrlBehavior;
use backend\models\forms\LoginForm;
use backend\models\forms\PasswordResetForm;
use backend\models\forms\RestorePasswordRequestForm;
use backend\models\Graph;
use backend\models\Statistics;
use keystorage\models\KeyStroageFormModel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
                        'actions' => ['index', 'logout', 'error'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'restore-password-request', 'password-reset', 'password-regenerate'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['settings'],
                        'roles' => ['superAdmin']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
        if (!Yii::$app->user->isGuest) $this->goHome();

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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';
        $model = new RestorePasswordRequestForm;

        if ($model->load(Yii::$app->request->post()) && $model->sendRestoreLink()) {
            Yii::$app->session->setFlash('success', 'Mail with further instructions have been sent to your e-mail address.');
            return $this->goHome();
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
        if (!Yii::$app->user->isGuest) $this->goHome();

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
            return $this->goHome();
        }

        return $this->render('password-reset', ['model' => $model]);
    }

    public function actionPasswordRegenerate($token)
    {
        $this->generatePassword(10);
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

    public function actionSettings()
    {
        $rq = Yii::$app->getRequest();
        $session = Yii::$app->getSession();
        $commonRules = [
            ['trim'],
            ['required'],
            ['string', 'max' => 100]
        ];
        $model = new KeyStroageFormModel([
            'keys' => [
                'citrix.id' =>
                    [
                        'label' => 'Citrix ID',
                        'type' => KeyStroageFormModel::TYPE_TEXTINPUT,
                        'rules' => $commonRules,
                    ],
                'citrix.pass' =>
                    [
                        'label' => 'Citrix Password',
                        'type' => KeyStroageFormModel::TYPE_TEXTINPUT,
                        'rules' => $commonRules,
                    ],
                'citrix.secret' => [
                    'label' => 'Citrix Secret',
                    'type' => KeyStroageFormModel::TYPE_TEXTINPUT,
                    'rules' => $commonRules,
                ],
                'citrix.subdomain' => [
                    'label' => 'Citrix Subdomain',
                    'type' => KeyStroageFormModel::TYPE_TEXTINPUT,
                    'rules' => $commonRules,
                ],
                'citrix.user' => [
                    'label' => 'Citrix User',
                    'type' => KeyStroageFormModel::TYPE_TEXTINPUT,
                    'rules' => [
                        ['trim'],
                        ['required'],
                        ['string', 'max' => 100],
                        ['email']
                    ],
                ]
            ]
        ]);

        if ($rq->isPost && $model->load($rq->post())) {
            if ($model->save()) {
                $flashBody = 'All settings were saved';
                $flashType = 'success';

            } else {
                $flashBody = 'Settings were not saved';
                $flashType = 'danger';
            }

            $session->setFlash($flashType, $flashBody);
        }

        return $this->render('settings', ['model' => $model]);
    }

    private function generatePassword($length)
    {
        $chars = "!@#$%^&*()_-=+;:,.?abcdefghijklmnopqrstuvwxyzABCDEFGHI!@#$%^&*()_-=+;:,.?JKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle(sha1(mt_rand() . time()) . $chars ), 0, $length );
        return $password;
    }
}
