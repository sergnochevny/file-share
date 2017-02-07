<?php
/** @var $this \yii\web\View */
/** @var $companyForm \backend\models\Company */
/** @var $isUpdate bool */
///** @var $companyId int|bool If user is not client then false */

use backend\models\Company;
use backend\models\User;
use yii\helpers\Url;

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

    <?php if (User::isAdmin()): ?>
    <div class="col-lg-6 col-lg-offset-3">
        <?php if(Company::find()->count() > 0): ?>
            <h2 align="center">
                <span class="d-ib">Select Company</span>
            </h2>
        <?php endif; ?>
        <div class="form-group">
            <?= $this->render('_select-company', ['selected' => $selected]) ?>
        </div>
    </div>
    <?php endif ?>

    <div class="clearfix"></div>
    <?php if(Company::find()->count() > 0): ?><hr/><?php endif; ?>
    <div class="row">
        <div class="col-sm-6">

            <?= $form->field($companyForm, 'name')->textInput(['placeholder' => 'Company name']) ?>

            <?= $form->field($companyForm, 'city')->textInput(['placeholder' => 'Location city']) ?>

            <?= $form->field($companyForm, 'zip')->textInput(['placeholder' => 'Zip code', 'maxlength' => '10']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($companyForm, 'address')->textInput(['placeholder' => 'Location address']) ?>

            <?= $form->field($companyForm, 'state')->textInput(['placeholder' => 'Location state']) ?>

            <?= $form->field($companyForm, 'description')->textarea(['placeholder' => 'Describe your company', 'rows' => 4]) ?>
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
            <a href="<?= \yii\helpers\Url::to(['user'], true) ?>" class="hidden btn btn-sm btn-labeled  arrow-success" type="button">
                <span class="btn-label">
                    <span class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                </span>
                Next
            </a>
        </div>
    </div>
    <?php \backend\widgets\ActiveForm::end() ?>
</div>