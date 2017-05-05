<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/password-regenerate', 'token' => $user->password_reset_token]);
?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        Hello <?= Html::encode($user->username) ?>, <br>
        <br>
        Follow the link below to reset your password: <br>
        <?= Html::a(Html::encode($resetLink), $resetLink) ?>
    </td>
</tr>
