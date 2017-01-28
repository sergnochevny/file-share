<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'col-sm-12 hidden']
]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">Search <?= $this->title ?></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'first_name') ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'last_name') ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'phone_number') ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'email') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'username') ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'status')->dropDownList($model::getStatusesList()) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'created_at')->widget(DatePicker::class) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'updated_at')->widget(DatePicker::class) ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">

                <div class="col-sm-6">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="col-sm-6 text-right">
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                </div>

            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>

