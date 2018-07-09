<?php

use sn\utilities\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \common\models\InvestigationType */

$this->title = 'Update Investigative Service: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Investigative Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="title-bar">
    <div class="title-bar-actions">
        <a class="btn btn-labeled arrow-default" href="<?= Url::previous() ?>">
            <span class="btn-label"><span class="icon icon-chevron-circle-left icon-lg icon-fw"></span></span>Back
        </a>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-info-circle"></span> <b><?= Html::encode($this->title) ?></b></span>
    </h1>
    <p class="title-bar-description">
        <small>Description</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-collapse">
            <div class="panel-body">
                <?= $this->render('_form', ['model' => $model,]) ?>
            </div>
        </div>
    </div>
</div>
