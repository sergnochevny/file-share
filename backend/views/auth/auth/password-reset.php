<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ait\auth\models\forms\PasswordResetForm */

$this->title = 'Password Reset';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
];

?>
<div class="login">
    <div class="login-body">
        <?= Html::a(Html::a(Html::img(Url::to(['/images/logo.png'], true), ['class' => 'img-responsive']), ['/']), Url::to(['/'], true), ['class' => 'login-brand']) ?>
        <?php if (isset($model)): ?>
        <h3 class="login-heading"><b>Set new password</b></h3>
        <div class="login-form">
            <?php $form = ActiveForm::begin(['id' => 'password-reset-form', 'enableClientValidation' => false]); ?>
                <?= $form->field($model, 'password', $fieldOptions1)->passwordInput() ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::submitButton('Save new password', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php else: ?>
            <div class="text-center">
                <h4 style="color: white">
                    <?= Yii::$app->session->getFlash('alert')['body']; ?>
                </h4>
                <?= Html::a('Home', Url::home()); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
