<?php

use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent(Yii::$app->layoutPath . DIRECTORY_SEPARATOR . Yii::$app->layout . '.php') ?>
    <body class="login-page">
    <?php $this->beginBody() ?>
        <?= $content ?>
        <?= Alert::widget() ?>
    <?php $this->endBody() ?>
    </body>
<?php $this->endContent() ?>