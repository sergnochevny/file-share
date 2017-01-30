<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '@' . $model->username;

?>

<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous('back'), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-users"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>All files</small>
    </p>
</div>

<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']), ['class' => 'btn-label']) . ' Add a new user', Url::to(['/wizard/user']), ['class' => 'btn btn-sm btn-labeled arrow-success']) ?>
            </div>
            <div class="form-inline no-footer">

            </div>
        </div>
    </div>
</div>