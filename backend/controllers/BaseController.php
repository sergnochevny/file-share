<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param $view
     * @param array $viewData
     * @return string
     */
    protected function smartRender($view, array $viewData)
    {
        return Yii::$app->getRequest()->isPjax ? $this->renderAjax($view, $viewData) : $this->render($view, $viewData);
    }

    /**
     * @param $type
     * @param $entity
     * @param $isUpdate
     * @param string|null $message
     */
    protected function setFlashMessage($type, $entity, $isUpdate = false, $message = null)
    {
        $action = $isUpdate ? 'updated' : 'created';
        if (null === $message) {
            $message = ($type == 'success')
                ? "The $entity has been $action successfully"
                : "The $entity hasn't been $action";
        }

        Yii::$app->getSession()->setFlash($type, $message);
    }
}