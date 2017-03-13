<?php
/** @var $this \yii\web\View */
/** @var $investigationForm \backend\models\Investigation*/
/** @var bool $isUpdate */

use backend\models\Company;
use backend\models\User;
use yii\jui\DatePicker;

$isShowCompany = User::isAdmin() && (Company::find()->count() > 0);

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

            <?= $form->field($investigationForm, 'name')->textInput(['placeholder' => 'Name']) ?>

            <?= $form->field($investigationForm, 'description')->textarea([
                'placeholder' => 'Provide Description',
                'style' => 'height: 99px;'
            ]) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($investigationForm, 'contact_person')->textInput(['placeholder' => 'Contact Person']) ?>

            <?= $form->field($investigationForm, 'phone')->input('tel', ['placeholder' => 'Phone Number']) ?>

            <?= $form->field($investigationForm, 'email')->textInput(['placeholder' => 'Contact Email Address']) ?>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($investigationTypes)): ?>
        <div class="col-sm-6 investigation-types">
            <?= $form->field($investigationForm, 'investigationTypeIds')-> checkboxList($investigationTypes) ?>
        </div>
        <?php endif ?>
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