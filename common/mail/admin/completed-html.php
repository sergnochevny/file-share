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

        <table style="width: 50%; padding: 10px 0 40px;">

            <tr>
                <td colspan="2" style="padding: 20px 0; font-style: italic;">Applicant
                    <b><?= Html::encode($model->fullName) ?></b> has been complited on:
                </td>
            </tr>

            <tr>
                <td style="width: 26%;padding: 10px ; font-weight: bold; border: #e9e9e9 1px solid;">Date:</td>
                <td style="padding: 10px ; text-align: center; border: #e9e9e9 1px solid;"><?= Yii::$app->formatter->asDate($model->updated_at) ?></td>
            </tr>
            <tr>
                <td style="width: 26%;padding: 10px ; font-weight: bold; border: #e9e9e9 1px solid;">Complited by:</td>
                <td style="padding: 10px ; text-align: center; border: #e9e9e9 1px solid;"><?= $byUser; ?></td>
            </tr>

        </table>

    </tr>
<?php endif ?>