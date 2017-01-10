<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>-->

<h3 class="login-heading">Log in</h3>
<div class="login-form">

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
    </div>

    <?php ActiveForm::end(); ?>


    <form data-toggle="validator">
        <div class="form-group">
<!--            <label for="username" class="control-label">Username or Email</label>-->

        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
        </div>
        <div class="form-group">
            <ul class="list-inline">
                <li>
                    <label class="custom-control custom-control-primary custom-checkbox">
                        <input class="custom-control-input" type="checkbox">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-label">Keep me signed in</span>
                    </label>
                </li>
            </ul>
            <ul class="list-inline">

                <li><a href="<?= \yii\helpers\Url::to(['/site/password-reset']) ?>">Forgot password?</a></li>
            </ul>
        </div>
    </form>
</div>
