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
                        <?= strtoupper($model->name) ?>
                        <?php if (Investigation::STATUS_COMPLETED !== $model->status && !User::isClient()): ?>
                            <a class="pull-right btn btn-xs btn-labeled arrow-success" href="<?= Url::to(['/investigation/complete', 'id' => $model->id]) ?>">
                    <span class="btn-label">
                        <span class="icon icon-check icon-lg icon-fw"></span>
                    </span> Complete
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
                                    <span class="label label-<?= Investigation::getStatusCSSClass($model->status) ?>">
                                        <?= Investigation::getStatusByCode($model->status)?>
                                    </span>

                                </span>
                                <span class="icon icon-tag icon-lg icon-fw"></span>
                                Status
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span title="<?= Yii::$app->formatter->asDate($model->start_date, 'full') ?>"
                                                               class="label label-success"><?= Yii::$app->formatter->asDate($model->start_date) ?></span></span>
                                <span class="icon icon-calendar  icon-lg icon-fw"></span>
                                Start date
                            </li>
                            <?php if ($model->createdBy): ?>
                            <li class="list-group-item">
                                <span class="pull-right"><span
                                            class="label label-success"><?= Html::encode($model->createdBy->fullName) ?></span></span>
                                <span class="icon icon-user-plus  icon-lg icon-fw"></span>
                                Applicant
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-group">

                            <li class="list-group-item">
                                <span class="pull-right"><span
                                            class="label label-success"><?= $model->contact_person; ?></span></span>
                                <span class="icon icon-user icon-lg icon-fw"></span>
                                Contact person
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span class="label label-success"><?= $model->phone; ?></span></span>
                                <span class="icon icon-phone icon-lg icon-fw"></span>
                                Phone number
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right"><span
                                            class="label label-success"><?= Yii::$app->formatter->asEmail($model->email); ?></span></span>
                                <span class="icon icon-envelope-o icon-lg icon-fw"></span>
                                Email
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>