<?php


namespace common\models\query;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AbstractUndeletableActiveQuery
 * @package common\query
 *
 * This class implements query for hiding records with a status which in the list of $hiddenStatuses
 * In subclasses you may add hidden statuses and implement activeQuery methods e.g.
 * exceptDeleted() where you can populate $excludedHiddenStatuses
 *
 * ```php
 *  class UndeletableActiveQuery extends AbstractUndeletableActiveQuery
 *  {
 *      protected $hiddenStatuses = [
 *          AbstractUndeletableActiveRecord::STATUS_DELETED
 *      ];
 *
 *      public function andDeleted()
 *      {
 *          $this->excludedHiddenStatuses[] = AbstractUndeletableActiveRecord::STATUS_DELETED;
 *          return $this;
 *      }
 *  }
 * ```
 *
 * Then your finders will return only records without deleted, but if you call
 * Record::find()->andDeleted()->all();
 * You get all records including with status deleted
 */
abstract class AbstractUndeletableActiveQuery extends ActiveQuery
{
    protected $hiddenStatuses = [];

    protected $excludedHiddenStatuses = [];

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        /** @var ActiveRecord $calledClass */
        $calledClass = $this->modelClass;
        $tableName = $calledClass::tableName();

        $hiddenStatuses = array_diff($this->hiddenStatuses, $this->excludedHiddenStatuses);
        if ($hiddenStatuses) {
            $this->andWhere(['not in', "$tableName.status", $hiddenStatuses]);
        }

        return parent::prepare($builder);
    }
}