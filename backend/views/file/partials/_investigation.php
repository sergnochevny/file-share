<?php

use backend\models\Investigation;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Investigation */
?>

<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12">
                        <?= strtoupper($model->fullName) ?>
                        <?php if (Investigation::STATUS_COMPLETED !== $model->status && !User::isClient()): ?>
                            <a class="pull-right btn btn-xs btn-labeled arrow-success" href="<?= Url::to(['/investigation/complete', 'id' => $model->id]) ?>"
                               data-confirm="This action will mark the investigation as completed . Are you sure you want to proceed?"
                               data-pjax="1" data-method = "post">
                                <span class="btn-label"><span class="icon icon-check icon-lg icon-fw"></span></span>
                                Complete
                            </a>
                        <?php endif ?>
                    </div>
                </div>

            </div>
            <div class="panel-body panel-collapse">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="label label-success"><?= Html::encode($model->first_name) ?></span>
                                </span>
                                <span class="icon icon-user icon-lg icon-fw"></span>
                                First Name
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="label label-success"><?= Html::encode($model->middle_name) ?></span>
                                </span>
                                <span class="icon icon-user icon-lg icon-fw"></span>
                                Middle Name
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="label label-success"><?= Html::encode($model->last_name) ?></span>
                                </span>
                                <span class="icon icon-user icon-lg icon-fw"></span>
                                Last Name
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="label label-success"><?= $model->formattedSsn ?></span>
                                </span>
                                <span class="icon icon-info icon-lg icon-fw"></span>
                                SSN
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="label label-success"><?= Yii::$app->formatter->asDate($model->birth_date) ?></span>
                                </span>
                                <span class="icon icon-calendar icon-lg icon-fw"></span>
                                Birth Date
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <span class="<?= Investigation::getStatusCSSClass($model->status) ?>-text">
                                        <?= Investigation::getStatusByCode($model->status)?>
                                    </span>

                                </span>
                                <span class="icon icon-tag icon-lg icon-fw"></span>
                                Status
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span title="<?= Yii::$app->formatter->asDate($model->start_date, 'full') ?>"
                                                               class=""><?= Yii::$app->formatter->asDate($model->start_date) ?></span></span>
                                <span class="icon icon-calendar  icon-lg icon-fw"></span>
                                Start date
                            </li>
                            <?php if ($model->createdBy): ?>
                            <li class="list-group-item">
                                <span class="pull-right"><span
                                            class="label label-success"><?= Html::encode($model->createdBy->fullName) ?></span></span>
                                <span class="icon icon-user-plus  icon-lg icon-fw"></span>
                                Created By
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>