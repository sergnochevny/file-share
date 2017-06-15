<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<?php if ($model instanceof \common\models\Investigation): ?>
<tr>
    <td colspan="2" style="padding: 20px 0;">
        The report for <?= Html::encode($model->name) ?> has been completed
        and is ready for download as of <?= Yii::$app->formatter->asDate($model->updated_at) ?>.
        <br>If you have any questions or need additional information, please contact Protus3.
    </td>
</tr>
<?php endif ?>