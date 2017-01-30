<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $userForm \backend\models\forms\UserForm */
/** @var bool $isUpdate */

?>

<div id="tab-2" class="tab-pane active">
    <?php $form = \backend\widgets\ActiveForm::begin([
        'id' => 'user-form',
        'action' => ['user', 'id' => $isUpdate ? $userForm->getUser()->id : null],
        'options' => [
            'data-pjax' => true,
            'data-create-url' => Url::to(['user'], true), //when select prompt in user send request to create url
        ],
    ]) ?>
    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Role</span>
        </h2>

        <div class="form-group">                            <?php /*todo get this list from db */ ?>
            <?= Html::activeDropDownList($userForm, 'role', ['admin' => 'admin', 'client' => 'client'],
                ['id' => 'user-role', 'class' => 'form-control', 'prompt' => ' - - -']); ?>
            <!--<span class="help-block">There is a choice of two or more people.</span>-->
        </div>
    </div>

    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Company</span>
        </h2>

        <div class="form-group">
            <?= $this->render('_select-company', ['model' => $userForm]) ?>
        </div>
    </div>


    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Users</span>
        </h2>

        <div class="form-group">
            <?= \kartik\depdrop\DepDrop::widget([
                'name' => 'user',
                'options' => ['id'=>'user-list', 'prompt' => ' - - -'],
                'pluginOptions'=>[
                    'depends'=>['company-list', 'user-role'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['company-users'])
                ]
            ]) ?>
        </div>
    </div>


    <div class="clearfix"></div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">


            <?= $form->field($userForm, 'username')->textInput() ?>

            <?= $form->field($userForm, 'email')->textInput() ?>

            <?= $form->field($userForm, 'password')->passwordInput() ?>

            <?= $form->field($userForm, 'password_repeat')->passwordInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($userForm, 'first_name')->textInput() ?>

            <?= $form->field($userForm, 'last_name')->textInput() ?>

            <?= $form->field($userForm, 'phone_number')->textInput() ?>



        </div>
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button class="btn btn-sm btn-labeled  arrow-warning" type="submit">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-check-square   icon-lg icon-fw"></span>
                                                        </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
            <a href="<?= \yii\helpers\Url::to(['investigation'], true) ?>" class="hidden btn btn-sm btn-labeled  arrow-success">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                                                        </span>
                Next
            </a>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>
