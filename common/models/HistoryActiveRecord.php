<?php

namespace common\models;

use common\models\query\UndeleteableActiveQuery;
use yii\base\InvalidConfigException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class HistoryActiveRecord
 * @package common\models
 *
 */
class HistoryActiveRecord extends RecoverableActiveRecord
{

    static public $history_type = 'default';

    public function getHistoryType(){
        return static::$history_type;
    }

    /**
     * @param $condition
     * @return RecoverableActiveRecord
     */
    public static function findOneIncludeHistory($condition)
    {
        return parent::findByCondition($condition)->andArchived()->one();
    }
}
