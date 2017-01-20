<?php
/** @var $this \yii\web\View */
/** @var $companyForm \backend\models\forms\CompanyForm */
///** @var $companyId int|bool If user is not client then false */


?>

<div id="tab-1" class="tab-pane active">
    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Company</span>
        </h2>

        <div class="form-group">
            <?= $this->render('_select-company') ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr/>
    <div class="row">

        <?php $form = \backend\widgets\ActiveForm::begin([
                'id' => 'company-form',
                'action' => ['company/create'],
        ]) ?>
        <div class="col-sm-6">

            <?= $form->field($companyForm, 'name')->textInput() ?>

            <?= $form->field($companyForm, 'city')->textInput() ?>

            <?= $form->field($companyForm, 'zip')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'address')->textInput() ?>

            <?= $form->field($companyForm, 'state')->textInput() ?>
        </div>
        <?php \backend\widgets\ActiveForm::end() ?>

        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button id="company-create" class="btn btn-sm btn-labeled  arrow-warning" type="button">
                <span class="btn-label">
                    <span class="icon icon-check-square   icon-lg icon-fw"></span>
                </span>
                Create
            </button>
            <button class="btn btn-sm btn-labeled  arrow-success" type="button">
                <span class="btn-label">
                    <span class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                </span>
                Next
            </button>
        </div>
    </div>
</div>