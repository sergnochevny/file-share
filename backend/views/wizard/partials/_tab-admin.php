<?php

use ait\utilities\helpers\Url;
use backend\models\User;
use backend\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var $this \yii\web\View */
/** @var $userForm \backend\models\forms\UserForm */
/** @var bool $isUpdate */
/** @var array|null $selectedUser */

\backend\assets\WizardAdminAsset::register($this);

?>

<div id="tab-4" class="tab-pane active">
    <?php $form = ActiveForm::begin([
        'id' => 'admin-form',
        'action' => ['/wizard/admin', 'id' => $isUpdate ? $userForm->getUser()->id : null],
        'options' => [
            'data-pjax' => true,
            'data-create-url' => Url::to(['/wizard/admin'], true),
            //when select prompt in user send request to create url
        ],
    ]) ?>
    <?php if (Yii::$app->user->can('sadmin')): ?>
        <div class="col-lg-6 col-lg-offset-3">
            <h2 align="center">
                <span class="d-ib">Select Role</span>
            </h2>

            <div class="form-group<?= $userForm->hasErrors('role') ? ' has-error' : '' ?>">                            <?php /*todo get this list from db */ ?>
                <?= Html::activeDropDownList($userForm, 'role', $userForm->adminRoles,
                    ['id' => 'admin-role', 'class' => 'form-control', 'prompt' => 'Select a Role']); ?>
                <?= Html::error($userForm, 'role', ['class' => 'help-block']) ?>
            </div>
        </div>
    <?php endif ?>

    <?php if ($isUpdate) : ?>
        <?= $form->field($userForm, 'user')->hiddenInput(['placeholder' => 'User'])->label(false) ?>
    <?php else : ?>
        <div class="col-lg-6 col-lg-offset-3" id="admin-list-container" <?=
        $isUpdate ? '' : 'style="display: none"'
        ?>>
            <h2 align="center">
                <span class="d-ib">Select Users</span>
            </h2>

            <div class="form-group">
                <?= DepDrop::widget([
                    'name' => 'user',
                    'data' => $isUpdate
                        ? $userForm->getUser()->getColleaguesList()
                        : [],
                    'pluginOptions' => [
                        'depends' => ['admin-role'],
                        'placeholder' => 'Create a New User',
                        'url' => Url::to(['/wizard/company-users'])
                    ],
                    'options' => [
                        'id' => 'admin-list',
                        'prompt' => 'Create a New User',
                        'options' => [$selectedUser => ['selected' => 'selected']]
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="clearfix"></div>
    <hr/>
    <div id="inputs" class="row">
        <div class="col-sm-6">
            <?= $form->field($userForm, 'username')->textInput(['placeholder' => 'User Name']) ?>
            <?= $form->field($userForm, 'email')->textInput(['placeholder' => 'Actual Email Address']) ?>
            <?= $form->field($userForm, 'password')->passwordInput(['placeholder' => 'Your Password']) ?>
            <?= $form->field($userForm, 'password_repeat')->passwordInput(['placeholder' => 'Confirm Your Password']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($userForm, 'first_name')->textInput(['placeholder' => 'First Name']) ?>
            <?= $form->field($userForm, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>
            <?= $form->field($userForm, 'phone_number')->widget(MaskedInput::className(), [
                'mask' => '(999) 999-9999',
                'clientOptions' => ['removeMaskOnSubmit' => true,],
                'options' => ['class' => 'form-control']
            ]) ?>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button class="btn btn-sm btn-labeled  arrow-warning" type="submit">
                <span class="btn-label">
                    <span class="icon icon-check-square   icon-lg icon-fw"></span>
                </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
            <?php if (\Yii::$app->user->can('wizard.investigation')): ?>
                <a href="<?= Url::to(['/wizard/investigation'], true) ?>"
                   class="<?= $isUpdate ? '' : 'hidden ' ?>btn btn-sm btn-labeled  arrow-success">
                    <span class="btn-label">
                        <span class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                    </span>
                    Next
                </a>
            <?php endif ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
