<?php

use yii\helpers\Html;
use backend\models\Company;

/** @var $this \yii\web\View */
/** @var $form \backend\widgets\ActiveForm */

$model = isset($model) ? $model : null;
$form = isset($form) ? $form : null;
$dropDown = function ($model = null, $name, $list, array $options) use ($form) {
    if ($model) {
        if ($form) {
            return $form->field($model, $name, ['template' => "{input}\n{hint}\n{error}"])
                ->dropDownList($list, $options);
        }
        return Html::activeDropDownList($model, $name, $list, $options);
    }
    return Html::dropDownList($name, null, $list, $options);
}
?>
<?php if (Yii::$app->getUser()->can('admin')): ?>
    <?php
    $options = [
        'id' => 'company-list',
        'data-info-url' => \yii\helpers\Url::to(['company-info'], true),
        'class' => 'form-control',
        'prompt' => $model ? ' - - -' : 'Create a new company',
    ];
    if (!empty($selected)){
      $options['options'] = [$selected => ['selected'=>'selected']];
    }
    ?>
    <?= $dropDown($model, 'company_id', Company::getList(), $options ) ?>
<!--<span class="help-block">For convenience, use the quick search</span>-->
<?php elseif (Yii::$app->getUser()->can('client')): ?>
    <?= Yii::$app->user->identity->company->name?>
<?php endif ?>