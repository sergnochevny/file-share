<?php

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="layout layout-header-fixed">
            <?php $this->beginBody() ?>
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
            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>

