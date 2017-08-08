<?php

namespace common\models;

use Yii;
use yii\base\InvalidCallException;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property integer $company_id
 * @property string $type
 * @property integer $created_at
 * @property integer $created_by
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
            [['parent', 'created_at', 'company_id'], 'integer'],
            [['type'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
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
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
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

    public function recover()
    {
        if ($this->type == Company::$history_type){
            $model = Company::findOneIncludeHistory($this->parent);
        } elseif ($this->type == Investigation::$history_type){
            $model = Investigation::findOneIncludeHistory($this->parent);
        }elseif ($this->type == File::$history_type){
            $model = File::findOneIncludeHistory($this->parent);
        }
        if (!empty($model)){
            $model->recover();
        } else {
            throw new InvalidCallException('Model must be instance of the HistoryActiveRecord class!');
        }
    }

}
