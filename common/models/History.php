<?php

namespace common\models;

use Yii;

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
            [['type', 'created_at'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
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
}
