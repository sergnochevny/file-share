<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tr>
    <td colspan="2" style="padding: 20px 0;">
        Hello <?= Html::encode($user->username) ?>, <br>
        <br>
        Please follow this link to reset your password:
        <?= Html::a(Html::encode($resetLink), $resetLink) ?> <br>
        If you need additional assistance, please contact Protus3.
    </td>
</tr>
