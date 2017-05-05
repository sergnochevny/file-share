<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\User;

/** @var $this \yii\web\View */
/** @var $userForm \backend\models\forms\UserForm */
/** @var bool $isUpdate */
/** @var array|null $selectedUser */

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
    <?php if (Yii::$app->user->can('admin')): ?>
        <?php if (Yii::$app->user->can('superAdmin')): ?>
        <div class="col-lg-6 col-lg-offset-3">
            <h2 align="center">
                <span class="d-ib">Select Role</span>
            </h2>

            <div class="form-group<?= $userForm->hasErrors('role') ? ' has-error' : '' ?>">                            <?php /*todo get this list from db */ ?>
                <?= Html::activeDropDownList($userForm, 'role', [
                    'superAdmin' => 'Super Admin',
                    'admin' => 'Admin',
                    'client' => 'Company User'
                ],
                    ['id' => 'user-role', 'class' => 'form-control', 'prompt' => 'Select a Role']); ?>
                <?= Html::error($userForm, 'role', ['class' => 'help-block']) ?>
            </div>
        </div>
        <?php endif ?>

    <div class="col-lg-6 col-lg-offset-3" id="company-list-container" <?=
    $userForm->company_id || User::isAdmin() ? '' : 'style="display: none"'
    ?>>
        <h2 align="center">
            <span class="d-ib">Select Company</span>
        </h2>

        <div class="form-group">
            <?= $this->render('_select-company', ['model' => $userForm]) ?>
        </div>
    </div>
    <?php endif ?>

    <div class="col-lg-6 col-lg-offset-3" id="user-list-container" <?=
    $isUpdate ? '' : 'style="display: none"'
    ?>>
        <h2 align="center">
            <span class="d-ib">Select Users</span>
        </h2>

        <div class="form-group">
            <?= \kartik\depdrop\DepDrop::widget([
                'name' => 'user',
                'data' => $isUpdate
                    ? $userForm->getUser()->getColleaguesList()
                    : [],
                'pluginOptions'=>[
                    'depends'=>['company-list', 'user-role'],
                    'placeholder' => 'Create a New User',
                    'url' => Url::to(['company-users'])
                ],
                'options' => [
                    'id'=>'user-list',
                    'prompt' => 'Create a New User',
                    'options' => [$selectedUser => ['selected'=>'selected']]
                ],
            ]) ?>
        </div>
    </div>


    <div class="clearfix"></div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">


            <?= $form->field($userForm, 'username')->textInput(['placeholder' => 'User Name']) ?>

            <?= $form->field($userForm, 'email')->textInput(['placeholder' => 'Actual Email Address']) ?>

            <?= $form->field($userForm, 'password')->passwordInput(['placeholder' => 'Your Password']) ?>

            <?= $form->field($userForm, 'password_repeat')->passwordInput(['placeholder' => 'Confirm Your Password']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($userForm, 'first_name')->textInput(['placeholder' => 'First Name']) ?>

            <?= $form->field($userForm, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>

            <?= $form->field($userForm, 'phone_number')->textInput(['placeholder' => 'Phone Number']) ?>



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
            <?php if (!User::isAdmin()): ?>
            <a href="<?= \yii\helpers\Url::to(['investigation'], true) ?>" class="<?= $isUpdate ? '' : 'hidden ' ?>btn btn-sm btn-labeled  arrow-success">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                                                        </span>
                Next
            </a>
            <?php endif ?>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>