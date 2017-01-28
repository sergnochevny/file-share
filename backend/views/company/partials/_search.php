<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'col-sm-12']
    ]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">Search <?= $this->title ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'name') ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'address') ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'city') ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'state') ?>
                    </div>
                </div>

                <?php // echo $form->field($model, 'zip') ?>

                <?php // echo $form->field($model, 'status') ?>

                <?php // echo $form->field($model, 'created_at') ?>

                <?php // echo $form->field($model, 'updated_at') ?>
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

</div>
