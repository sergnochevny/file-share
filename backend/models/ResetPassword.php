<?php

namespace backend\models;

use Yii;
use yii\base\ErrorException;

class ResetPassword
{
    /**
     * ResetPassword constructor.
     * @param $resetToken
     * @throws ErrorException
     */
    public function __construct($resetToken)
    {
        if ($this->isTokenExpire($resetToken)) {
            throw new ErrorException('Token is invalid');
        }

        $this->user = User::findOne(['password_reset_token' => $resetToken]);
        if ($this->user === null) {
            throw new ErrorException('User with this token not found');
        }
    }

    /**
     * @return bool
     */
    public function sendNewOne()
    {
        $newPassword = $this->generatePassword(10);
        $this->updatePassword($newPassword);

        $template = 'newPassword';
        return Yii::$app->mailer->compose([
            'html' => "$template-html",
            'text' => "$template-text",
        ], ['user' => $this->user, 'newPassword' => $newPassword])
            ->setTo([$this->user->email => $this->user->username])
            ->setFrom(['noreply@protus3.com' => 'protus3 mail'])
            ->setSubject('New Password')
            ->send();
    }

    /**
     * @return void
     */
    private function updatePassword($password)
    {
        $user = $this->user;
        $user->setPassword($password);
        $user->save(false);
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isTokenExpire($token)
    {
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        return ($timestamp + 3600) < time();
    }

    /**
     * @param int $length
     * @return bool|string
     */
    private function generatePassword($length)
    {
        $chars = "!@#$%^&*()_-=+;:,.?abcdefghijklmnopqrstuvwxyzABCDEFGHI!@#$%^&*()_-=+;:,.?JKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        return substr( str_shuffle(sha1(mt_rand() . time()) . $chars ), 0, $length );
    }
}