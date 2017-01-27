<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileSearch */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="row">
    <div class="file-search">
        <?php $form = ActiveForm::begin([
            'id' => 'file_search_form',
            'options' => ['data-pjax' => true],
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
        <div class="col-sm-6">
            <?= $form->field($model, 'pagesize',
                ['template' => '<div class="dataTables_length">Show {input} entries</div>']
            )->dropDownList(
                [10 => 10, 20 => 20, 50 => 50, 100 => 100],
                ['id' => 'pagesize', 'class' => 'form-control input-sm', 'data-submit' => true]

            ) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'name',
                [
                    'template' => "<label>{input}</label>\n{hint}\n{error}",
                    'options' => ['class' => 'dataTables_filter'],
                    'inputOptions' => [
                        'type' => 'search',
                        'class' => "form-control input-sm",
                        'placeholder' => "Search…",
                        'data-submit' => true
                    ]
                ]
            ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
