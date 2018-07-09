<?php

use sn\utilities\helpers\Url;
use backend\assets\FormSearchAsset;
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\FileSearch */
/* @var $form yii\widgets\ActiveForm */


FormSearchAsset::register($this);

$action = !empty($action) ? $action : Url::to([null], true);
?>
<?php $form = ActiveForm::begin([
    'id' => 'form_search',
    'action' => $action,
    'method' => 'get',
    'fieldConfig' => [
        'template' => '<label>{input}</label>',
    ],
    'options' => [
        'class' => 'row',
        'data-pjax' => true
    ]
]); ?>
    <div class="col-sm-6">
        <?= $form->field($model, 'pagesize', [
            'options' => [
                'id' => 'pagesize',
                'data-submit' => true,
                'class' => 'search-select'
            ],
            'template' => '<label>Show {input} entries</label>',
        ])->dropDownList([10 => 10, 25 => 25, 50 => 50, 100 => 100], [
            'class' => 'form-control input-sm',
        ])->label(false) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'searchname', [
            'options' => [
                'class' => 'search-line',
            ],
        ])->textInput([
            'class' => 'form-control input-sm',
            'placeholder' => 'Search',
        ])->label(false) ?>
    </div>
<?php ActiveForm::end(); ?>