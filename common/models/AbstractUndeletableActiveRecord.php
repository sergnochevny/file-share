<?php


namespace common\models;


use common\models\query\UndeletableActiveQuery;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class AbstractUndeletableActiveRecord
 * @package common\models
 *
 * @property int $status
 */
abstract class AbstractUndeletableActiveRecord extends ActiveRecord
{
    /**
     * If you are want override this method
     * you MUST extends yours Query class from UndeletableActiveQuery AND
     * NOT from AbstractUndeletableAcitveQuery
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
    public function archive(){
        $this->status = static::STATUS_IN_HISTORY;
        $this->save(false);
    }

    /**
     * Changes status of record to STATUS_DELETED
     *
     * @return void
     */
    public function delete()
    {
        $this->status = static::STATUS_DELETED;
        $this->save(false);
    }
}
