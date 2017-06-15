<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
</head>
<body>
<?php $this->beginBody() ?>
<table style="width: 50%; border: #431f4d 1px solid; background: #431f4d;" cellpadding="0" cellspacing="0" width="50%">
    <tr >
        <td colspan="2"><img src="<?= Url::to(['/images/mail-logo.png'], true) ?>" width="150px" alt=""></td>
    </tr>
</table>
<table style="width: 50%; padding: 10px 0 40px;">
    <?= $content ?>
</table>
<table style="width: 50%;border: #431f4d 1px solid; background: #431f4d;" cellpadding="0" cellspacing="0" width="50%">
    <tr >
        <td colspan="4" style="padding: 10px; text-align: center; color: #ccc0a3; font-size: 11px;" >PLAN. PROTECT. <b>PROSPER</b>.</td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>