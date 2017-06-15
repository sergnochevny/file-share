<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>


<?php if ($model instanceof \backend\models\services\UserService): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        The user <b><?= Html::encode($model->getUser()->username) ?></b> was
        created on <b><?= Yii::$app->formatter->asDate($model->getUser()->created_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>

<?php elseif ($model instanceof \backend\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        The applicant <b><?= Html::encode($model->name) ?></b>
        for <b><?= Html::encode($model->company->name) ?></b> company was
        created on <b><?= Yii::$app->formatter->asDate($model->created_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>

<?php endif ?>