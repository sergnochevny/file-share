<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>


<?php if ($model instanceof \backend\models\Company): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
    The <b><?= Html::encode($model->name) ?></b> company folder was
        deleted on <b><?= Yii::$app->formatter->asDate($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>


<?php elseif ($model instanceof \backend\models\services\UserService): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        The user <b><?= Html::encode($model->getUser()->username) ?></b> was
        deleted on <b><?= Yii::$app->formatter->asDate($model->getUser()->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>

<?php elseif ($model instanceof \backend\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        The applicant <b><?= Html::encode($model->name) ?></b>
        for <b><?= Html::encode($model->company->name) ?></b> was
        deleted on <b><?= Yii::$app->formatter->asDate($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>

<?php endif ?>