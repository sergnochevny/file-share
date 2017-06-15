<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<?php if ($model instanceof \common\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0;">
        The applicant <?= Html::encode($model->name) ?>
        for <?= Html::encode($model->company->name) ?> was
        completed on <?= Yii::$app->formatter->asDate($model->updated_at) ?>
        by <?= Html::encode($identity->username) ?>
    </td>
</tr>
<?php endif ?>