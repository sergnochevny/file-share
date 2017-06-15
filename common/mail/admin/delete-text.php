<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */
?>


<?php if ($model instanceof \backend\models\Company): ?>
    The <?= $model->name ?> company was deleted on <?= Yii::$app->formatter->asDate($model->updated_at) ?> by <?= $identity->username ?>

<?php elseif ($model instanceof \backend\models\services\UserService): ?>
    The user <?= $model->getUser()->username ?> was deleted on <?= Yii::$app->formatter->asDate($model->getUser()->updated_at) ?> by <?= $identity->username ?>

<?php elseif ($model instanceof \backend\models\Investigation): ?>
    The applicant <?= $model->name ?> for <?= $model->company->name ?> company was deleted on <?= Yii::$app->formatter->asDate($model->updated_at) ?> by <?= $identity->username ?>

<?php endif ?>