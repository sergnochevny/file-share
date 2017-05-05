<?php

use yii\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '@' . Yii::$app->user->identity->username;

?>

<div class="col-sm-12">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about_me')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout_src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar_src')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>