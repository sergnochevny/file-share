<?php
/** @var $this \yii\web\View */
/** @var $companyForm \backend\models\Company */
/** @var $isUpdate bool */
///** @var $companyId int|bool If user is not client then false */

use backend\models\Company;
use backend\models\User;
use yii\helpers\Url;

//@todo consider to move in css file
$this->registerCss('.investigation-types label {display: block;}');

$isShowCompany = User::isAdmin() && (Company::find()->count() > 0);
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

    <?php if ($isShowCompany): ?>
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
    <?php if($isShowCompany): ?><hr/><?php endif; ?>
    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($companyForm, 'name')->textInput(['placeholder' => 'Company Name']) ?>

            <?= $form->field($companyForm, 'city')->textInput(['placeholder' => 'Location City']) ?>

            <?= $form->field($companyForm, 'zip')->textInput(['placeholder' => 'Zip Code', 'maxlength' => '10']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'address')->textInput(['placeholder' => 'Location Address']) ?>

            <?= $form->field($companyForm, 'state')->textInput(['placeholder' => 'Location State']) ?>

            <?= $form->field($companyForm, 'description')->textarea(['placeholder' => 'Describe Your Company', 'rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 investigation-types">
            <?= $form->field($companyForm, 'investigationTypeIds')-> checkboxList($investigationTypes) ?>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button class="btn btn-sm btn-labeled arrow-warning" type="submit">
                <span class="btn-label">
                    <span class="icon icon-check-square icon-lg icon-fw"></span>
                </span>
                <?= $isUpdate ? 'Update' : 'Create' ?>
            </button>
            <a href="<?= \yii\helpers\Url::to(['user'], true) ?>" class="<?= $isUpdate ? '' : 'hidden ' ?>btn btn-sm btn-labeled  arrow-success" type="button">
                <span class="btn-label">
                    <span class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                </span>
                Next
            </a>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>