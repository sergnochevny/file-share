<?php

namespace backend\controllers;

use ait\keystorage\models\KeyStorageFormModel;
use backend\behaviors\RememberUrlBehavior;
use backend\models\forms\LoginForm;
use backend\models\forms\PasswordResetForm;
use backend\models\forms\RestorePasswordRequestForm;
use backend\models\Graph;
use backend\models\ResetPassword;
use backend\models\Statistics;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $layout = 'content';

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

    public function actionSettings()
    {
        $rq = Yii::$app->getRequest();
        $session = Yii::$app->getSession();
        $commonRules = [
            ['trim'],
            ['required'],
            ['string', 'max' => 100]
        ];
        $model = new KeyStorageFormModel([
            'keys' => [
                'system.sendfrom' =>
                    [
                        'label' => 'System Send From email',
                        'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                        'rules' => array_merge([['email']], $commonRules),
                    ],
                'citrix.id' =>
                    [
                        'label' => 'Citrix ID',
                        'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                        'rules' => $commonRules,
                    ],
                'citrix.pass' =>
                    [
                        'label' => 'Citrix Password',
                        'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                        'rules' => $commonRules,
                    ],
                'citrix.secret' => [
                    'label' => 'Citrix Secret',
                    'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                    'rules' => $commonRules,
                ],
                'citrix.subdomain' => [
                    'label' => 'Citrix Subdomain',
                    'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                    'rules' => $commonRules,
                ],
                'citrix.user' => [
                    'label' => 'Citrix User',
                    'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
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
}
