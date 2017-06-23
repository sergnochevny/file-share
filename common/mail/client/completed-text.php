<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
use yii\helpers\Html;

/** @var $identity \backend\models\User */
?>

<?php if ($model instanceof \common\models\Investigation): ?>

    The report for <?= Html::encode($model->fullName) ?> has been completed
    and is ready for download as of <?= Yii::$app->formatter->asDate($model->updated_at) ?>.
    If you have any questions or need additional information, please contact Protus3.

<?php endif ?>