<?php

use yii\helpers\Html;
use backend\models\Company;

/** @var $this \yii\web\View */

$user = Yii::$app->getUser();
?>
<?php if ($user->can('admin')): ?>
    <?= Html::dropDownList(null, null, Company::getList(), [
        'id' => 'demo-select2-1-3',
        'class' => 'form-control',
        'prompt' => ' - - -',
    ]) ?>
<span class="help-block">For convenience, use the quick search</span>
<?php elseif ($user->can('client')): ?>
    <?= $user->identity->comany_id ?>
there is company already selected
<?php endif ?>