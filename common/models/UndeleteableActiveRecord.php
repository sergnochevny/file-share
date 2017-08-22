<?php

namespace common\models;

use common\models\query\UndeleteableActiveQuery;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class UndeletableActiveRecord
 * @package common\models
 *
 * @property int $status
 */
class UndeleteableActiveRecord extends ActiveRecord
{

    /**
     *
     */
    const STATUS_DELETED = 0;
    /**
     *
     */
    const STATUS_ACTIVE = 100;
    /**
     *
     */
    const STATUS_IN_HISTORY = 200;

    /**
     *
     */
    const EVENT_AFTER_ARCHIVE = 'afterArchive';
    /**
     *
     */
    const EVENT_BEFORE_ARCHIVE = 'beforeArchive';

    /**
     * If you are want override this method
     * you MUST extends yours Query class from UndeletableActiveQuery AND
     * NOT from UndeletableAcitveQuery
     *
     * @inheritdoc
     * @return UndeleteableActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(UndeleteableActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return [
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_IN_HISTORY => 'Archived',
            static::STATUS_DELETED => 'Deleted',
        ];
    }

    /**
     * Changes status of records to STATUS_DELETED
     *
     * @param string $condition
     * @param array $params
     * @return int
     */
    public static function deleteAll($condition = '', $params = [])
    {
        return parent::updateAll(['status' => static::STATUS_DELETED], $condition, $params);
    }

    /**
     * Changes status of record to STATUS_IN_HISTORY
     *
     * @return bool
     */
    public function archive()
    {
        $res = false;
        if ($this->beforeArchive()) {
            $this->off(ActiveRecord::EVENT_BEFORE_UPDATE);
            $this->off(ActiveRecord::EVENT_AFTER_UPDATE);
            $this->status = static::STATUS_IN_HISTORY;
            if ($this->save(false)) {
                $res = $this->afterArchive();
            }
        }

        return $res;
    }

    /**
     * @return bool
     */
    public function afterDelete()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_AFTER_DELETE, $event);
        return $event->isValid;
    }

    /**
     * Changes status of record to STATUS_DELETED
     * @return bool
     */
    public function delete()
    {
        $res = false;
        $this->status = static::STATUS_DELETED;
        if ($this->beforeDelete()) {
            $this->off(ActiveRecord::EVENT_BEFORE_UPDATE);
            $this->off(ActiveRecord::EVENT_AFTER_UPDATE);
            if ($this->save(false)) {
                $res = $this->afterDelete();
            }
        }
        return $res;
    }

    /**
     * @return false|int
     */
    public function just_delete()
    {
        return parent::delete();
    }

    /**
     * @return bool
     */
    public function afterArchive()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_AFTER_ARCHIVE, $event);
        return $event->isValid;
    }

    /**
     * @return bool
     */
    public function beforeArchive()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_BEFORE_ARCHIVE, $event);
        return $event->isValid;
    }

    /**
     * @return bool
     */
    public function isArchivable()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        $statuses = [
            self::STATUS_DELETED,
        ];

        return isset($statuses[$this->status]);
    }

}
