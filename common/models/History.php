<?php

namespace common\models;

use yii\base\InvalidCallException;
use yii\base\ModelEvent;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

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
class History extends ActiveRecord
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
            'blameableBehavior'=>[
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

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return bool
     */
    public function recover()
    {
        $res = false;
        if ($this->beforeRecover()) {
            if ($this->type == Company::$history_type) {
                $model = Company::findOneIncludeHistory($this->parent);
            } elseif ($this->type == Investigation::$history_type) {
                $model = Investigation::findOneIncludeHistory($this->parent);
            } elseif ($this->type == File::$history_type) {
                $model = File::findOneIncludeHistory($this->parent);
            }
            if (!empty($model)) {
                if ($model->recover()) {
                    $res = $this->afterRecover();
                }
            } else {
                throw new InvalidCallException('Model must be instance of the HistoryActiveRecord class!');
            }
        }
        return $res;
    }

    /**
     * @return Query
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_company', ['company_id' => 'company_id']);
    }

    public function afterRecover()
    {
        $event = new ModelEvent;
        $this->trigger(RecoverableActiveRecord::EVENT_AFTER_RECOVER, $event);
        return $event->isValid;
    }

    public function beforeRecover()
    {
        $event = new ModelEvent;
        $this->trigger(RecoverableActiveRecord::EVENT_BEFORE_RECOVER, $event);
        return $event->isValid;
    }
}
