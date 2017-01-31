<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseUrl;

class Url extends BaseUrl
{

    /**
     * @inheritdoc
     */
    public static function remember($url = '', $name = null)
    {
        $url = static::to($url);

        if ($name === null) {
            $backUrl = Yii::$app->getUser()->getBackUrl();
            if ($backUrl !== $url){
                Yii::$app->getUser()->setReturnUrl($backUrl);
                Yii::$app->getUser()->setBackUrl($url);
            }
        } else {
            Yii::$app->getSession()->set($name, $url);
        }
    }

    /**
     * @inheritdoc
     */
    public static function back($name = null)
    {
        if ($name === null) {
            return Yii::$app->getUser()->getBackUrl();
        } else {
            return Yii::$app->getSession()->get($name);
        }
    }

}
