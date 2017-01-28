<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Investigation */

$this->title = 'Create Investigation';
$this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investigation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
