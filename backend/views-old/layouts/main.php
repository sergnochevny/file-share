<?php
/** @var $this \yii\web\View */

\backend\assets\AppAsset::register($this);
?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>

<?= $this->render('tpl/header.php') ?>

<div class="layout-main">
    <?= $this->render('tpl/sidebar.php') ?>
    <div class="layout-content">
        <div class="layout-content-body">

            <?= $content ?>

        </div>
    </div>
    <?= $this->render('tpl/footer.php') ?>
</div>
<?php $this->endContent() ?>