<?php
/**
 * Copyright (c) 2017. sn
 */

/**
 * @var $this  yii\web\View
 * @var $form  yii\bootstrap\ActiveForm
 * @var $model SignUpForm
 * @var $fb_ref boolean
 * */

use sn\auth\models\forms\SignUpForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-sm-6 col-sm-offset-3 singup-style-form">
    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
        'options' => [
            'class' => 'panel panel-form auth-panel outer-offset-top',
        ],
    ]); ?>
    <div class="panel-heading text-center no-inner-offset-top">
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'your username']) ?>
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'youremail@example.com']) ?>
        <?= $form->field($model, 'password', ['options' => ['class' => 'relative']])->passwordInput([
            'placeholder' => 'Type your password',
            'class' => 'watch-password-field form-control'
        ]) ?>
    </div>
    <div class="panel-footer no-inner-offset-bottom">
        <div class="row">
            <?= Html::submitButton('Sign up', [
                'class' => 'btn btn-success btn-block no-border-radius-top to-uppercase',
                'name' => 'sign-up-button'
            ]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
