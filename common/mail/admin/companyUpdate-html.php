<?php
/** @var $model \backend\models\Company */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<p>The <b><?= Html::encode($model->name) ?></b> company was updated at <b><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></b> by <b><?= Html::encode($identity->username) ?></b></p>
