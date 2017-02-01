<?php
/** @var $model \backend\models\Company */
/** @var $identity \backend\models\User */
?>

The <?= $model->name ?> company was created at <?= Yii::$app->formatter->asDatetime($model->created_at) ?> by <?= $identity->username ?>