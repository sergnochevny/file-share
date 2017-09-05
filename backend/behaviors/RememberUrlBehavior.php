<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use ait\utilities\helpers\Url;
use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;

class RememberUrlBehavior extends Behavior
{

    public $actions = [];


    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws MethodNotAllowedHttpException when the request method is not allowed.
     */
    public function beforeAction($event)
    {
        $action = $event->action->id;
        if (in_array($action, $this->actions)) {
            Url::remember(Yii::$app->request->url);
        }
        return $event->isValid;
    }
}
