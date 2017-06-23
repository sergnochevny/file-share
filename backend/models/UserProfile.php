<?php

namespace backend\models;

use backend\models\query\UserProfileQuery;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $about_me
 * @property string $layout_src
 * @property string $avatar_src
 *
 * @property User $user

 * @property string $fullName
 */
class UserProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     * @return \backend\models\query\UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['about_me'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 55],
            [['layout_src', 'avatar_src'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'about_me' => 'About Me',
            'layout_src' => 'Layout Src',
            'avatar_src' => 'Avatar Src',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
