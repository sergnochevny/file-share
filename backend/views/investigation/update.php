<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Investigation */

$this->title = 'Update Investigation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="investigation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
