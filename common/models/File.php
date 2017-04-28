<?php

namespace common\models;

use common\behaviors\ArchiveCascadeBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $size
 * @property string $parent
 * @property string $type
 * @property string $citrix_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property Investigation $investigation
 */
class File extends HistoryActiveRecord
{

    static public $history_type = 'file';

    public $recoverStatus = self::STATUS_ACTIVE;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    public function behaviors()
    {
        return [
            'timestamp' => ['class' => TimestampBehavior::class],
            ArchiveCascadeBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'size', 'parent', 'type', 'citrix_id'], 'required'],
            [['description'], 'string'],
            [['size', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent', 'citrix_id'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_IN_HISTORY, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'File',
            'description' => 'Description',
            'size' => 'Size',
            'parent' => 'Parent',
            'type' => 'Type',
            'citrix_id' => 'Citrix ID',
            'created_at' => 'Date',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function archive()
    {
        $this->detachBehavior('uploadBehavior');
        $res = parent::archive(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Files: "' . $this->name . '" doesn`t archiving!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

    public function recover()
    {
        $this->detachBehavior('uploadBehavior');
        $this->detachBehavior('historyBehavior');
        $res = parent::recover(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Investigation: "' . $this->name . '" doesn`t to recover!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

    /**
     * @return Investigation
     */
    public function getInvestigation()
    {
        return $this->hasOne(Investigation::className(), ['citrix_id' => 'parent'])->inverseOf('files');
    }

    /**
     * @return bool
     */
    public function isRecoverable()
    {
        $f_statuses = [
            File::STATUS_IN_HISTORY,
        ];
        $i_statuses = [
            Investigation::STATUS_IN_HISTORY
        ];

        return (in_array($this->status, $f_statuses) && !in_array($this->investigation->status, $i_statuses));
    }

}
