<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\forms\RestorePasswordRequestForm */

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
        <?= Html::a(Html::a(Html::img(Url::to(['/images/logo.png'], true), ['class' => 'img-responsive']), ['/']), Url::to(['/'], true), ['class' => 'login-brand']) ?>
        <h3 class="login-heading"><b><?= $subtitle ?></b></h3>
        <div class="login-form">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                <?= $form ->field($model, 'identificator', $fieldOptions1)->textInput() ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::submitButton('Send regeneration tooken', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <br>
        <div class="text-center outer-offset-top"><?= Html::a('Go back', Url::previous()) ?></div>
    </div>
</div>
