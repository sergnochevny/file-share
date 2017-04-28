<?php

namespace common\models;

use common\models\query\UndeletableActiveQuery;
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
}
