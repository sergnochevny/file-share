<?php

namespace backend\actions;

use Yii;
use backend\models\File;
use Citrix\CitrixApi;
use yii\base\Action;
use yii\base\InvalidParamException;
use yii\web\Response;

class DownloadAction extends Action
{

    protected $subdomain;
    protected $user;
    protected $pass;
    protected $clientid;
    protected $secret;

    protected function renderFile($id)
    {
        if (isset($id)) {
        } else {
            throw new InvalidParamException("Expected id parameter");
        }
    }

    /**
     * Sets the HTTP headers needed by image response.
     */
    protected function setHttpHeaders()
    {
        Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', 'image/png');
    }

    public function init()
    {
        parent::init();

        $this->subdomain = \Yii::$app->keyStorage->get('citrix.subdomain');
        $this->user = \Yii::$app->keyStorage->get('citrix.user');
        $this->pass = \Yii::$app->keyStorage->get('citrix.pass');
        $this->clientid = \Yii::$app->keyStorage->get('citrix.id');
        $this->secret = \Yii::$app->keyStorage->get('citrix.secret');

    }

    /**
     * Runs the action.
     */
    public function run($id = null)
    {
        $response = '';

        $model = File::findOne(['citrix_id' => $id]);
        $investigation = $model->investigations;
        if (Yii::$app->user->can('admin') ||
            (
                !Yii::$app->user->can('admin') &&
                ((!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent])))
            )
        ) {
            $Citrix = CitrixApi::getInstance();
            $Citrix->setSubdomain($this->subdomain)
                ->setUsername($this->user)
                ->setPassword($this->pass)
                ->setClientId($this->clientid)
                ->setClientSecret($this->secret)
                ->Initialize();

            $items = $Citrix->Items;
            $item_content = $items
                ->setId($id)
                ->setRedirect(CitrixApi::FALSE)
                ->setIncludeAllVersions(CitrixApi::FALSE)
                ->ItemContent;
            $response = $this->controller->redirect($item_content->DownloadUrl);
        }

        return $response;
    }

}