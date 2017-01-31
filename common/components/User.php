<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 31.01.2017
 * Time: 14:23
 */

namespace common\components;

use Yii;

class User extends \yii\web\User
{
    public $backUrlParam = '__backUrl';

    /**
     * @inheritdoc
     */
    public function getReturnUrl($defaultUrl = null)
    {
        $url = Yii::$app->getSession()->get($this->returnUrlParam, $defaultUrl);
        if (is_array($url)) {
            if (isset($url[0])) {
                return Yii::$app->getUrlManager()->createUrl($url);
            } else {
                $url = null;
            }
        }

        return $url === null ? Yii::$app->getHomeUrl() : $url;
    }

    /**
     * @inheritdoc
     */
    public function setReturnUrl($url)
    {
        Yii::$app->getSession()->set($this->returnUrlParam, $url);
    }

    /**
     * @inheritdoc
     */
    public function getBackUrl($defaultUrl = null)
    {
        $url = Yii::$app->getSession()->get($this->backUrlParam, $defaultUrl);
        if (is_array($url)) {
            if (isset($url[0])) {
                return Yii::$app->getUrlManager()->createUrl($url);
            } else {
                $url = null;
            }
        }

        return $url === null ? Yii::$app->getHomeUrl() : $url;
    }

    /**
     * @inheritdoc
     */
    public function setBackUrl($url)
    {
        Yii::$app->getSession()->set($this->backUrlParam, $url);
    }

}