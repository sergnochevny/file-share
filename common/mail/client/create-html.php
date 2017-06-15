<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>


<?php if ($model instanceof \backend\models\services\UserService): ?>
<tr>
    <td colspan="2" style="padding: 20px 0;">
        The user <?= Html::encode($model->getUser()->username) ?> was
        created on <?= Yii::$app->formatter->asDate($model->getUser()->created_at) ?>
        by <?= Html::encode($identity->username) ?>
    </td>
</tr>

<?php elseif ($model instanceof \backend\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0;">
        The applicant <?= Html::encode($model->name) ?>
        for <?= Html::encode($model->company->name) ?> was
        created on <?= Yii::$app->formatter->asDate($model->created_at) ?>
        by <?= Html::encode($identity->username) ?>
    </td>
</tr>

<?php endif ?>