<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ait\auth\models\forms\LoginForm */

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
        <?= Html::a(Html::a(Html::img(Url::to('@web/images/logo.png', true), ['class' => 'img-responsive']), ['/']), Url::to(['/'], true), ['class' => 'login-brand']) ?>
        <h3 class="login-heading"><b>Sign in</b></h3>
        <div class="login-form">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-12 text-center">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <a href="<?= Url::to(['/auth/auth/password-restore'], true) ?>">Forgot password?</a>
                </div>
                <!-- /.col -->
            </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="login-footer">
        <ul class="list-inline">
            <li><a  href="#">Sign up</a></li>
            <li>|</li>
            <li><a  href="#">Privacy Policy</a></li>
            <li>|</li>
            <li><a  href="#">Terms</a></li>
            <li>|</li>
            <li><a  href="#">Cookie Policy</a></li>
            <li>|</li>
            <li>© <?= Yii::$app->name . ' ' . date('Y') ?></li>
        </ul>
    </div>
</div>
