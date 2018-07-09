<?php

namespace backend\controllers;

use sn\keystorage\models\KeyStorageFormModel;
use backend\behaviors\RememberUrlBehavior;
use backend\models\Graph;
use backend\models\Statistics;
use common\components\BaseController;
use Yii;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends BaseController
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

        return $this->smartRender('index', [
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
            return $this->smartRender('client', $renderParams);
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
                'system.sendfrom' => [
                    'label' => 'System Send From email',
                    'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                    'rules' => array_merge([['email']], $commonRules),
                ],
                'citrix.id' => [
                    'label' => 'Citrix ID',
                    'type' => KeyStorageFormModel::TYPE_TEXTINPUT,
                    'rules' => $commonRules,
                ],
                'citrix.pass' => [
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

        return $this->smartRender('settings', ['model' => $model]);
    }
}
