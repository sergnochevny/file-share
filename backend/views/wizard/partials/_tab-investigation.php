<?php
/** @var $this \yii\web\View */
/** @var $investigationForm \backend\models\Investigation*/
/** @var bool $isUpdate */

use yii\jui\DatePicker;

?>
<div id="tab-3" class="tab-pane active">
    <?php $form = \backend\widgets\ActiveForm::begin([
        'id' => 'investigation-form',
        'options' => ['data-pjax' => 'wizard-container'],
        'action' => ['investigation', 'id' => $investigationForm->id],
    ]) ?>
    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Select Company</span>
        </h2>

        <?= $this->render('_select-company', ['form' => $form, 'model' => $investigationForm])  ?>

    </div>
    <div class="clearfix"></div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($investigationForm, 'name')->textInput() ?>

            <?= $form->field($investigationForm, 'description')->textarea() ?>

            <?= $form->field($investigationForm, 'start_date')->widget(DatePicker::class) ?>

            <?= $form->field($investigationForm, 'end_date')->widget(DatePicker::class) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($investigationForm, 'contact_person')->textInput() ?>

            <?= $form->field($investigationForm, 'phone')->textInput() ?>

            <?= $form->field($investigationForm, 'email')->textInput() ?>
        </div>

        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button id="company-create" class="btn btn-sm btn-labeled  arrow-warning" type="submit">
                <span class="btn-label">
                    <span class="icon icon-check-square icon-lg icon-fw"></span>
                </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>