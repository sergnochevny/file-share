<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property string $type
 * @property integer $created_at
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'created_at'], 'integer'],
            [['type'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', false],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    public function formName()
    {
        return '';
    }


}
