<?php

namespace common\models;

use common\models\query\UndeletableActiveQuery;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class UndeletableActiveRecord
 * @package common\models
 *
 * @property int $status
 */
class UndeletableActiveRecord extends ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 100;
    const STATUS_IN_HISTORY = 200;

    const EVENT_AFTER_ARCHIVE = 'afterArchive';
    const EVENT_BEFORE_ARCHIVE = 'beforeArchive';

    /**
     * If you are want override this method
     * you MUST extends yours Query class from UndeletableActiveQuery AND
     * NOT from UndeletableAcitveQuery
     *
     * @inheritdoc
     * @return UndeletableActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(UndeletableActiveQuery::className(), [get_called_class()]);
    }

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
        $this->status = static::STATUS_IN_HISTORY;
        if ($this->beforeArchive() && $this->save(false)) return $this->afterArchive();
        return false;
    }

    public function afterDelete()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_AFTER_DELETE, $event);
        return $event->isValid;
    }

    /**
     * Changes status of record to STATUS_DELETED
     *
     * @return void
     */
    public function delete()
    {
        $this->status = static::STATUS_DELETED;
        if ($this->beforeDelete() && $this->save(false)) return $this->afterDelete();
        return false;
    }

    public function afterArchive()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_AFTER_ARCHIVE, $event);
        return $event->isValid;
    }

    public function beforeArchive()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_BEFORE_ARCHIVE, $event);
        return $event->isValid;
    }
}
