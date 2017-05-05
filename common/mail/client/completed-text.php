<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */
?>

<?php if ($model instanceof \common\models\Investigation): ?>

    The applicant <?= $model->name ?> for <?= $model->company->name ?> company was completed at <?= Yii::$app->formatter->asDatetime($model->updated_at) ?> by <?= $identity->username ?>

<?php endif ?>