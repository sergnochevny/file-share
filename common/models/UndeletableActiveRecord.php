<?php

namespace common\models;

use common\models\query\UndeletableActiveQuery;
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

    const EVENT_AFTER_ARCHIVE = 'afterArchive';
    const EVENT_BEFORE_ARCHIVE = 'beforeArchive';

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 100;
    const STATUS_IN_HISTORY = 200;

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

    /**
     * Changes status of record to STATUS_IN_HISTORY
     *
     * @return void
     */
    public function archive()
    {
        $this->status = static::STATUS_IN_HISTORY;
        if ($this->beforeArhive() && $this->save(false)) $this->afterArhive();
    }

    /**
     * Changes status of record to STATUS_DELETED
     *
     * @return void
     */
    public function delete()
    {
        $this->status = static::STATUS_DELETED;
        if ($this->beforeDelete() && $this->save(false)) $this->afterDelete();
    }

    public function afterArhive()
    {
        $this->trigger(self::EVENT_AFTER_ARCHIVE);
    }

    public function beforeArhive()
    {
        $this->trigger(self::EVENT_BEFORE_ARCHIVE);
    }
}
