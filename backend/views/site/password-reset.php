<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

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
        <h3 class="login-heading">Set new password</h3>
        <div class="login-form">

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                <?= $form->field($model, 'password', $fieldOptions1)->textInput() ?>
                <?= $form->field($model, 'passwordRepeat', $fieldOptions2)->passwordInput() ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::submitButton('Save new password', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                    </div>
                </div>


            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
