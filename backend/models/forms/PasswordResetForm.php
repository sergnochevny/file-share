<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetForm extends Model
{
    public $recoveryToken;
    public $password;
    public $passwordRepeat;

    private $user = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                'password',
                'required',
                'message' => 'Please, create your new password',
            ],

            [
                'password',
                'string',
                'min' => 6, 'max' => 32,
                'message' => 'Password must to be from 6 to 32 chars',
            ],

            [
                'passwordRepeat',
                'required',
                'message' => 'Please, confirm your new password by repeating it here',
            ],

            [
                'passwordRepeat',
                'compare', 'compareAttribute' => 'password',
                'message' => 'Passwords don\'t match',
            ],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean|string whether the password recovery token was not generated, or generated recovery token
     */
    final private function validateRecoveryToken()
    {
        return $this->getUserByRecoveryToken();
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    final public function getUserByRecoveryToken()
    {
        if ($this->user === null) {
            $this->user = User::findByPasswordResetToken($this->recoveryToken);
        }

        return $this->user;
    }

}
