<?php

use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $userForm \backend\models\forms\UserForm */

?>

<div id="tab-2" class="tab-pane">
    <?php \yii\widgets\Pjax::begin(['id' => 'user-manage', 'enablePushState' => false]) ?>
    <?php $form = \backend\widgets\ActiveForm::begin(['options' => ['data-pjax'=>'']]) ?>
    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Role</span>
        </h2>

        <div class="form-group">
            <?= Html::activeDropDownList($userForm, 'role', [
                'admin' => 'admin', 'client' => 'client'
            ], ['id' => 'demo-select2-1', 'class' => 'form-control']); ?>
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
            <select id="demo-select2-1" class="form-control" >
                <option value="">Harry Potter</option>
            </select>
            <!--<span class="help-block">There is a choice of two or more people.</span>-->
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
                Create
            </button>
            <button class="btn btn-sm btn-labeled  arrow-success" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                                                        </span>
                Next
            </button>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
