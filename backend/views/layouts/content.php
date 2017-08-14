<?php

use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent(Yii::$app->layoutPath . DIRECTORY_SEPARATOR . Yii::$app->layout . '.php') ?>
    <?= $this->render('partials/_header.php') ?>
    <div class="layout-main">
        <?= $this->render('partials/_left.php') ?>
        <?= Alert::widget() ?>
        <div class="layout-content">
            <div class="layout-content-body">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?= isset($this->blocks['fileDescription']) ? $this->blocks['fileDescription'] : '' ?>
<?php $this->endContent() ?>
