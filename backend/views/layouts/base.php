<?php
/** @var $this \yii\web\View */
/** @var $content string */

use yii\helpers\Html;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <?= Html::csrfMetaTags() ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">
    <?php $this->head() ?>
</head>
<body class="layout layout-header-fixed">
<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>