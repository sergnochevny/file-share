<?php

use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent(Yii::$app->layoutPath . DIRECTORY_SEPARATOR . Yii::$app->layout . '.php') ?>
    <?= $content ?>
    <?= Alert::widget() ?>
<?php $this->endContent() ?>