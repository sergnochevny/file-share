<?php
/** @var $model \backend\models\Company */
/** @var $identity \backend\models\User */
?>

The <?= $model->name ?> company was updated at <?= Yii::$app->formatter->asDatetime($model->updated_at) ?> by <?= $identity->username ?>