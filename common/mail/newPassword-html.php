<?php

use yii\helpers\Html;

/** @var $newPassword string */
/** @var $user \backend\models\User */

?>
<tr>
    <td colspan="2" style="padding: 20px 0; font-style: italic;">
        Hello <?= Html::encode($user->username) ?>, <br>
        <br>
        There is your new password: <?= $newPassword ?> <br>
        Keep it in secure place.
    </td>
</tr>