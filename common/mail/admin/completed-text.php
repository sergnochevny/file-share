<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
use yii\helpers\Html;

/** @var $identity \backend\models\User */
?>

<?php if ($model instanceof \common\models\Investigation): ?>
    <?php
    $byUser = $identity->fullName . ' (' . $identity->username . ')';
    ?>

    Applicant <?= Html::encode($model->fullName) ?> has been complited on:
    Date: <?= Yii::$app->formatter->asDate($model->updated_at) ?>
    Complited by: <?= $byUser; ?>

<?php endif ?>