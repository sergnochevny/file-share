<?php
/** @var $model \backend\models\Company|\backend\models\services\UserService|\backend\models\Investigation */
/** @var $identity \backend\models\User */

use yii\helpers\Html;

?>

<?php if ($model instanceof \common\models\Investigation): ?>
    <?php
    $byUser = $identity->fullName . ' (' . $identity->username . ')';
    ?>
    <tr>

        <table style="width: 100%; padding: 10px 0 40px;">

            <tr>
                <td colspan="2" style="width: 100% padding: 20px 0; font-style: italic;">Applicant
                    <b><?= Html::encode($model->fullName) ?></b> has been completed :
                </td>
            </tr>

            <tr>
                <td style="width: 35%;padding: 10px ; font-weight: bold; border: #e9e9e9 1px solid;">Date:</td>
                <td style="width: 65%padding: 10px ; text-align: center; border: #e9e9e9 1px solid;"><?= Yii::$app->formatter->asDate($model->updated_at) ?></td>
            </tr>
            <tr>
                <td style="width: 35%;padding: 10px ; font-weight: bold; border: #e9e9e9 1px solid;">Completed by:</td>
                <td style="width: 65%;padding: 10px ; text-align: center; border: #e9e9e9 1px solid;"><?= $byUser; ?></td>
            </tr>

        </table>

    </tr>
<?php endif ?>