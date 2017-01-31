<?php
/** @var $model \backend\models\Company */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<p>The <b><?= Html::encode($model->name) ?></b> company was created at <b><?= $model->created_at ?></b> by <b><?= Html::encode($identity->username) ?></b></p>
