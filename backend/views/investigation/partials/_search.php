<?php

use backend\models\search\InvestigationSearch;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InvestigationSearch */
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
            'class' => 'dataTables_length'
        ],
        'template' => '<label>Show {input} entries</label>',
    ])->dropDownList(InvestigationSearch::$output_size, [
        'class' => 'form-control input-sm',
        'placeholder' => 'Search',
    ])->label(false) ?>
</div>
<div class="col-sm-6">
    <?= $form->field($model, 'name', [
        'options' => [
            'class' => 'dataTables_filter'
        ]
    ])->textInput([
        'class' => 'form-control input-sm',
        'placeholder' => 'Search',
    ])->label(false) ?>
</div>
<?php ActiveForm::end(); ?>

