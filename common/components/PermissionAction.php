<?php
/**
 * Date: 20.03.2017
 * Time: 16:43
 */

namespace common\components;


use yii\base\Action;
use yii\base\InvalidParamException;

class PermissionAction extends Action
{
    public $controller;

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        if ($controller instanceof PermissionController) $this->controller = $controller;
        else throw new InvalidParamException('controller must be instance of PermissionController');
    }


}