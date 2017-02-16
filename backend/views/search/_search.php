<?php

use yii\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileSearch */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(YII_ENV_DEV ? '@web/js/form_search.js' : '@web/js/form_search.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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
            'placeholder' => 'Search',
        ])->label(false) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'name', [
            'options' => [
                'class' => 'search-line',
            ],
        ])->textInput([
            'class' => 'form-control input-sm',
            'placeholder' => 'Search',
        ])->label(false) ?>
    </div>
<?php ActiveForm::end(); ?>