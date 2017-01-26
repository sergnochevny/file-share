<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">

    <section class="content">
        <?php \yii\widgets\Pjax::begin(['id' => 'content-container', 'enablePushState' => false]) ?>

        <?= Alert::widget() ?>
        <?= $content ?>

        <?php \yii\widgets\Pjax::end() ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <a target="_blank" href="#"><small>Web Design & hosting by Firm name</small></a>
    </div>
    <small>2016 © Plan. Protect. Prosper.</small>
</footer>