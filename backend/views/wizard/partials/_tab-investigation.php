<?php
/** @var $this \yii\web\View */
/** @var $investigationForm \backend\models\Investigation*/
/** @var bool $isUpdate */

use backend\models\Company;
use common\helpers\Url;
use yii\widgets\MaskedInput;

$isDbHasCompany = Company::find()->count() > 0;
$isShowCompany = Yii::$app->user->can('admin') && $isDbHasCompany;

?>
<div id="tab-3" class="tab-pane active">
    <?php $form = \backend\widgets\ActiveForm::begin([
        'id' => 'investigation-form',
        'options' => ['data-pjax' => 'wizard-container'],
        'action' => ['investigation', 'id' => $investigationForm->id],
    ]) ?>
    <?php if ($isShowCompany): ?>
    <div class="col-lg-6 col-lg-offset-3">
            <h2 align="center">
                <span class="d-ib">Select Company</span>
            </h2>
        <?= $this->render('_select-company', ['form' => $form, 'model' => $investigationForm])  ?>
    </div>
    <?php endif ?>
    <div class="clearfix"></div>
    <?php if($isShowCompany): ?><hr/><?php endif; ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($investigationForm, 'first_name')->textInput(['placeholder' => 'Name', 'maxlength' => true]) ?>
            <?= $form->field($investigationForm, 'middle_name')->textInput(['placeholder' => 'Name', 'maxlength' => true]) ?>
            <?= $form->field($investigationForm, 'last_name')->textInput(['placeholder' => 'Name', 'maxlength' => true]) ?>

            <?php if (!empty($investigationTypes)): ?>
            <?= $this->render('_investigation-types', [
                'types' => $investigationTypes,
                'form' => $form,
                'model' => $investigationForm
            ]) ?>
            <div class="other<?= $investigationForm->other_type ? '' : ' hidden' ?>">
                <?= $form->field($investigationForm, 'other_type')->textInput(['maxlength' => true]) ?>
            </div>
            <p>* Indicates additional information or form may be required</p>
            <?php endif ?>
        </div>
        <div class="col-sm-6">

            <?= $form->field($investigationForm, 'ssn')->widget(MaskedInput::className(), [
                'mask' => '999-99-9999',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ]
            ]) ?>
            <?= $form->field($investigationForm, 'birthDate')->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' =>  'mm/dd/yyyy',
                    'yearrange' => ['minyear' => 1920, 'maxyear' => 2000 ],
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <?php if ($isDbHasCompany): ?>
            <button id="company-create" class="btn btn-sm btn-labeled  arrow-warning" type="submit">
                <span class="btn-label">
                    <span class="icon icon-check-square icon-lg icon-fw"></span>
                </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
            <?php else: ?>
                <p class="text-danger">Please create at least one company before creating the applicant</p>
            <?php endif ?>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>