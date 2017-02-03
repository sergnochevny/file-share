<?php
/** @var $this \yii\web\View */
/** @var $investigationForm \backend\models\Investigation*/
/** @var bool $isUpdate */

use backend\models\Company;
use yii\jui\DatePicker;

?>
<div id="tab-3" class="tab-pane active">
    <?php $form = \backend\widgets\ActiveForm::begin([
        'id' => 'investigation-form',
        'options' => ['data-pjax' => 'wizard-container'],
        'action' => ['investigation', 'id' => $investigationForm->id],
    ]) ?>
    <div class="col-lg-6 col-lg-offset-3">
        <?php if(Company::find()->count() > 0): ?>
            <h2 align="center">
                <span class="d-ib">Select Company</span>
            </h2>
        <?php endif; ?>
        <?= $this->render('_select-company', ['form' => $form, 'model' => $investigationForm])  ?>

    </div>
    <div class="clearfix"></div>
    <?php if(Company::find()->count() > 0): ?><hr/><?php endif; ?>
    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($investigationForm, 'name')->textInput(['placeholder' => 'Name']) ?>

            <?= $form->field($investigationForm, 'description')->textarea(['placeholder' => 'Provide description']) ?>

            <?= $form->field($investigationForm, 'start_date')->widget(DatePicker::class, [
                'clientOptions' => [
                    'onSelect' => new \yii\web\JsExpression('function (dateText, inst) {
                        $("#'.\yii\helpers\Html::getInputId($investigationForm, 'end_date').'").datepicker("option", "minDate", new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
                    }'),
                ],
            ]) ?>

            <?= $form->field($investigationForm, 'end_date')->widget(DatePicker::class, [
                'clientOptions' => [
                    'onSelect' => new \yii\web\JsExpression('function (dateText, inst) {
                        $("#'.\yii\helpers\Html::getInputId($investigationForm, 'start_date').'").datepicker("option", "maxDate", new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
                    }'),
                ],
            ]) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($investigationForm, 'contact_person')->textInput(['placeholder' => 'Contact person']) ?>

            <?= $form->field($investigationForm, 'phone')->input('tel', ['placeholder' => 'Phone number']) ?>

            <?= $form->field($investigationForm, 'email')->textInput(['placeholder' => 'Contact email address']) ?>

            <?= $form->field($investigationForm, 'status')->dropDownList(\backend\models\Investigation::getStatusesList(),['prompt' => 'Select status']) ?>
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