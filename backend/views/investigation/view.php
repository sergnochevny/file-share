<?php

use backend\models\Investigation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Investigation */

$this->title = 'Investigation View | ' . Html::encode($model->company->name);
$this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous('back'), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-folder-open-o"></span> Company Investigation</span>
    </h1>
    <p class="title-bar-description">
        <small>General information about the company investigation</small>
    </p>
</div>



<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Investigation ID-<?= strtoupper($model->id) ?>
            </div>
            <div class="panel-body panel-collapse">
                <div class="row">

                    <div class="col-sm-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success"><?= Investigation::getStatusByCode($model->status) ?></span></span>
                                <span class="icon icon-tag icon-lg icon-fw"></span>
                                Status
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success">Hercule Puaro</span></span>
                                <span class="icon icon-user icon-lg icon-fw"></span>
                                Contact person
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success">8-800-555-22-55</span></span>
                                <span class="icon icon-phone icon-lg icon-fw"></span>
                                Phone number
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success">Puaro@detective.net</span></span>
                                <span class="icon icon-envelope-o icon-lg icon-fw"></span>
                                Email
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success"><?= Yii::$app->formatter->asDate($model->start_date) ?></span></span>
                                <span class="icon icon-calendar  icon-lg icon-fw"></span>
                                Start date
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success"><?= Yii::$app->formatter->asDate($model->end_date) ?></span></span>
                                <span class="icon icon-calendar  icon-lg icon-fw"></span>
                                End date
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success">Thomas Mor</span></span>
                                <span class="icon icon-user-plus  icon-lg icon-fw"></span>
                                Applicant
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-3 " for="form-control-8">Description</label>
                            <div class="col-sm-9">
                                <p><?= Html::encode($model->description) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>