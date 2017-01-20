<?php
/** @var $this \yii\web\View */
/** @var $companyForm $activeFormConfig */

$activeFormConfig =[
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-sm-8\">{input}</div>\n{hint}\n{error}",
        'labelOptions' => ['class' => 'col-sm-4 control-label'],
        'errorOptions' => ['class' => 'col-sm-8 col-sm-offset-4 help-block'],
    ]
];

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
        <?php $form = \yii\widgets\ActiveForm::begin($activeFormConfig) ?>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'name')->textInput() ?>

            <?= $form->field($companyForm, 'city')->textInput() ?>

            <?= $form->field($companyForm, 'zip')->textInput() ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'address')->textInput() ?>

            <?= $form->field($companyForm, 'state')->textInput() ?>

        </div>

        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button class="btn btn-sm btn-labeled  arrow-warning" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-check-square   icon-lg icon-fw"></span>
                                                        </span>
                Save
            </button>
            <button class="btn btn-sm btn-labeled  arrow-success" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                                                        </span>
                Next
            </button>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>