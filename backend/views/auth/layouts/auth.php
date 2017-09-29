<?php

use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent(Yii::$app->layoutPath . DIRECTORY_SEPARATOR . Yii::$app->layout . '.php');

echo $content;
if (Yii::$app->session->hasFlash('alert')) {
    $body = ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body');
    echo Html::beginTag('div', ['class' => 'alert-container']);
    echo Alert::widget([
        'body' => is_array($body) ? implode('<br>', $body) : $body,
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]);
    echo Html::endTag('div');
}

$this->endContent();
