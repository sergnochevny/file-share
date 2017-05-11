<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<?php if ($model instanceof \common\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        The applicant <b><?= Html::encode($model->name) ?></b>
        for <b><?= Html::encode($model->company->name) ?></b> company was
        completed on <b><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </td>
</tr>
<?php endif ?>