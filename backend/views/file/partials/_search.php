<?php

use backend\models\search\FileSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileSearch */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '<label>{input}</label>',
    ],
    'options' => ['class' => 'row']
]); ?>
<div class="col-sm-6">
    <?= $form->field($model, 'name', [
        'options' => [
            'id' => 'pagesize',
            'data-submit' => true,
            'class' => 'search-select'
        ],
        'template' => '<label>Show {input} entries</label>',
    ])->dropDownList(FileSearch::$output_size, [
        'class' => 'form-control input-sm',
        'placeholder' => 'Search',
    ])->label(false) ?>
</div>
<div class="col-sm-6">
    <?= $form->field($model, 'name', [
        'options' => [
            'class' => 'search-line'
        ]
    ])->textInput([
        'class' => 'form-control input-sm',
        'placeholder' => 'Search',
    ])->label(false) ?>
</div>
<?php ActiveForm::end(); ?>

