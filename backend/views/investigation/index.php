<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\InvestigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use sn\utilities\helpers\Url;
use yii\helpers\Html;

$this->title = 'Applicants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', ['/investigation/index'], ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-folder-open-o"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all applicants</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <?php if (\Yii::$app->user->can('wizard.investigation')): ?>
            <div class="panel-heading">
                <a class="btn btn-sm btn-labeled arrow-success" href="<?= Url::to(['/wizard/investigation']) ?>">
                    <span class="btn-label">
                        <span class="icon icon-plus icon-lg icon-fw"></span>
                    </span> Create a New Applicant
                </a>
            </div>
            <?php endif ?>
            <?= $this->render('partials/_list',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ]
            ); ?>
        </div>
    </div>
</div>