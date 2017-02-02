<?php
/** @var $model \backend\models\Company|\backend\models\User|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>


<?php if ($model instanceof \backend\models\Company): ?>
    <p>The <b><?= Html::encode($model->name) ?></b> company was
        archived at <b><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </p>


<?php elseif ($model instanceof \backend\models\User): ?>
    <p>
        The user <b><?= Html::encode($model->username) ?></b> was
        archived at <b><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </p>

<?php elseif ($model instanceof \backend\models\Investigation): ?>
    <p>
        The applicant <b><?= Html::encode($model->name) ?></b>
        for <b><?= Html::encode($model->company->name) ?></b> company was
        archived at <b><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></b>
        by <b><?= Html::encode($identity->username) ?></b>
    </p>

<?php endif ?>