<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/password-regenerate', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Please follow this link to reset your password: <?= $resetLink ?>

If you need additional assistance, please contact Protus3.
