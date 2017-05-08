<?php

use common\widgets\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var $model \keystorage\models\KeyStorageFormModel */

?>
<?php Pjax::begin(['enablePushState' => false, 'scrollTo' => 0, 'timeout' => 0]) ?>

<?= Alert::widget() ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]) ?>

<?= $form->field($model, 'systemSendfrom')->textInput() ?>

<?= $form->field($model, 'citrixSubdomain')->textInput() ?>
<?= $form->field($model, 'citrixId')->textInput() ?>
<?= $form->field($model, 'citrixSecret')->textInput() ?>
<?= $form->field($model, 'citrixUser')->textInput() ?>
<?= $form->field($model, 'citrixPass')->textInput() ?>

<div class="form-group text-right">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
<?php Pjax::end() ?>
