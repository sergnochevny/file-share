<?php

use sn\utilities\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model sn\auth\models\forms\PasswordRestoreForm */

$subtitle = 'Restore your password';
$this->title = Yii::$app->name . ' | ' . $subtitle;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<div class="login">
    <div class="login-body">
        <?= Html::a(Html::a(Html::img(Url::to(['/images/logo.png'], true), ['class' => 'img-responsive']), ['/']),
            Url::to(['/'], true), ['class' => 'login-brand']) ?>
        <h3 class="login-heading"><b><?= $subtitle ?></b>
        </h3>
        <div class="text-center outer-offset-bottom">
            Please fill out your username or email.<br>
            A link to reset password will be sent to you.
        </div>
        <div class="login-form">
            <?php $form = ActiveForm::begin(['id' => 'password-restore-form', 'enableClientValidation' => false]); ?>
            <?= $form->field($model, 'username', $fieldOptions1)->textInput(['autofocus' => true]) ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::submitButton('Send token', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <br>
        <div class="text-center outer-offset-top"><?= Html::a('Go back', Url::previous()) ?></div>
    </div>
</div>
