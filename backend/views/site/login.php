<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

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

<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Html::img(Url::to('/images/logo.png'), ['class' => 'img-responsive']), ['/']) ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="login-box-msg">Sign in</h3>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-12">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-12 text-center">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <a href="#">Forgot username?</a>
                <span> · </span>
                <a href="register.html">Forgot password?</a>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div>
         /.social-auth-links -->


    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<div class="col-xs-12 login-footer">
    <ul class="list-inline">
        <li><a href="#">Sign up</a></li>
        <li>|</li>
        <li><a href="#">Privacy Policy</a></li>
        <li>|</li>
        <li><a href="#">Terms</a></li>
        <li>|</li>
        <li><a href="#">Cookie Policy</a></li>
        <li>|</li>
        <li>&copy; Protus3 2016</li>
    </ul>
</div>
