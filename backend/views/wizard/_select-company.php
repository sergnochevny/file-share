<?php

use yii\helpers\Html;
use backend\models\Company;

/** @var $this \yii\web\View */

$user = Yii::$app->getUser();
$model = isset($model) ? $model : null;
$dropDown = function ($model = null, $name, $list, array $options) {
    if ($model) {
        return Html::activeDropDownList($model, $name, $list, $options);
    }
    return Html::dropDownList($name, null, $list, $options);
}
?>
<?php if ($user->can('admin')): ?>
    <?= $dropDown($model, 'company_id', Company::getList(), [
        'id' => 'company-list',
        'class' => 'form-control',
        'prompt' => ' - - -',
    ]) ?>
<span class="help-block">For convenience, use the quick search</span>
<?php elseif ($user->can('client')): ?>
    <?= $user->identity->comany_id ?>
there is company already selected
<?php endif ?>