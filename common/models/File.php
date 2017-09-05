<?php

namespace common\models;

use common\behaviors\ArchiveCascadeBehavior;
use common\models\query\UndeleteableActiveQuery;
use common\models\traits\PermissionsModelTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

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
 * @property string $created_by
 * @property string $updated_at
 * @property string $status
 * @property Investigation $investigation
 * @property Investigation $investigationWh
 * @property History $history
 */
class File extends HistoryActiveRecord
{

    use PermissionsModelTrait;

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
     * @return Query
     */
    public function getHistory()
    {
        return $this->hasOne(History::className(), ['parent' => 'id'])->andWhere(['type' => self::$history_type]);
    }

    /**
     * @return Query
     */
    public function getInvestigation()
    {
        return $this->hasOne(Investigation::className(), ['citrix_id' => 'parent'])->inverseOf('files');
    }

    /**
     * @return UndeleteableActiveQuery
     */
    public function getInvestigationWh()
    {
        $query = $this->hasOne(Investigation::className(), ['citrix_id' => 'parent']);
        /**
         * @var $query UndeleteableActiveQuery
         */
        return $query->andArchived();
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
            Investigation::STATUS_IN_HISTORY,
            Investigation::STATUS_DELETED,
        ];

        $res = in_array($this->status, $f_statuses);
        if (!empty($this->investigationWh)) {
            $res = $res && !in_array($this->investigationWh->status, $i_statuses);
        }
        return $res;
    }

    public function isDeleted()
    {
        return !empty($this->history) || parent::isDeleted();
    }


}
