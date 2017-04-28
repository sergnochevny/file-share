<?php
/** @var $this \yii\web\View */
/** @var $companyForm \backend\models\Company */
/** @var $isUpdate bool */
///** @var $companyId int|bool If user is not client then false */

use backend\models\Company;
use backend\models\User;
use yii\helpers\Url;


$isShowSelectCompany = !User::isClient() && (Company::find()->count() > 0);
$isReadOnly = User::isClient();
?>

<div id="tab-1" class="tab-pane active">
    <?php $form = \backend\widgets\ActiveForm::begin([
        'action' => ['company', 'id' => $companyForm->id],
        'id' => 'company-form',
        'options' => [
            'data-pjax' => 'wizard-container',
            'data-create-url' => Url::to(['company'], true), //when select prompt send request to create url
        ],
    ]) ?>

    <?php if ($isShowSelectCompany): ?>
    <div class="col-lg-6 col-lg-offset-3">
            <h2 align="center">
                <span class="d-ib">Select Company</span>
            </h2>
        <div class="form-group">
            <?= $this->render('_select-company', ['selected' => $selected]) ?>
        </div>
    </div>
    <?php endif ?>

    <div class="clearfix"></div>
    <?php if($isShowSelectCompany): ?><hr/><?php endif; ?>
    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($companyForm, 'name')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Company Name',
                'readonly' => $isReadOnly
            ]) ?>

            <?= $form->field($companyForm, 'city')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Location City',
                'readonly' => $isReadOnly
            ]) ?>

            <?= $form->field($companyForm, 'zip')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Zip Code',
                'maxlength' => '10',
                'readonly' => $isReadOnly
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'address')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Location Address',
                'readonly' => $isReadOnly
            ]) ?>

            <?= $form->field($companyForm, 'state')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Location State',
                'readonly' => $isReadOnly
            ]) ?>

            <?= $form->field($companyForm, 'case_number')->textInput([
                'placeholder' => $isReadOnly ? '' : 'Case Number',
                'readonly' => $isReadOnly,
                'maxlength' => true,
            ]) ?>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($investigationTypes) && !User::isClient()): ?>
        <div class="col-sm-6 investigation-types">
            <?= $form->field($companyForm, 'investigationTypeIds')-> checkboxList($investigationTypes) ?>
            <p>* Indicates additional information or form may be required</p>
        </div>
        <?php endif ?>
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <?php if (!User::isClient()): ?>
            <button class="btn btn-sm btn-labeled arrow-warning" type="submit">
                <span class="btn-label">
                    <span class="icon icon-check-square icon-lg icon-fw"></span>
                </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
            <?php endif ?>
            <a href="<?= \yii\helpers\Url::to([User::isClient() ? 'investigation' : 'user'], true) ?>" class="<?= $isUpdate ? '' : 'hidden ' ?>btn btn-sm btn-labeled  arrow-success" type="button">
                <span class="btn-label">
                    <span class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                </span>
                Next
            </a>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>