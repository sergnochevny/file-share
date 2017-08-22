<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Investigation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="investigation-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'start_date')->widget(DatePicker::class, []) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'end_date')->widget(DatePicker::class, []) ?>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'company_id')->dropDownList($model->allCompaniesList)->label('Company') ?>
    <?= $form->field($model, 'status')->dropDownList($model->statusesList) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
