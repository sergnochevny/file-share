<?php
/** @var $this \yii\web\View */
/** @var $model \backend\models\PasswordResetRequestForm */

use yii\widgets\ActiveForm;
?>

<h3 class="login-heading">Reset Your Password</h3>
<div class="login-form">
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <button class="btn btn-primary btn-block" type="submit">Send password reset email</button>
    </div>

    <div class="form-group">
        <ul class="list-inline">
            <li>
                <small>If you've forgotten your password, we'll send you an email to reset your password.</small>
            </li>
        </ul>
    </div>

    <?php ActiveForm::end() ?>
</div>