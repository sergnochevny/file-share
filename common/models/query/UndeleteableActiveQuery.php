<?php


namespace common\models\query;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class UndeleteableActiveQuery
 * @package common\query
 *
 * This class implements query for hiding records with a status which in the list of $hiddenStatuses
 * In subclasses you may add hidden statuses and implement activeQuery methods e.g.
 * exceptDeleted() where you can populate $excludedHiddenStatuses
 *
 * ```php
 *  class UndeletableActiveQuery extends UndeletableActiveQuery
 *  {
 *      protected $hiddenStatuses = [
 *          UndeletableActiveRecord::STATUS_DELETED
 *      ];
 *
 *      public function andDeleted()
 *      {
 *          $this->excludedHiddenStatuses[] = UndeletableActiveRecord::STATUS_DELETED;
 *          return $this;
 *      }
 *  }
 * ```
 *
 * Then your finders will return only records without deleted, but if you call
 * Record::find()->andDeleted()->all();
 * You get all records including with status deleted
 */
class UndeleteableActiveQuery extends ActiveQuery
{

    protected $hiddenStatuses = [];

    protected $excludedHiddenStatuses = [];

    public $modelClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //find out value of STATUS DELETED const for called class
        $modelClass = $this->modelClass;
        $this->hiddenStatuses = [$modelClass::STATUS_DELETED, $modelClass::STATUS_IN_HISTORY];
    }

    /**
     * Exclude deleted status from hidden when search entity
     * @return $this
     */
    public function andDeleted()
    {
        $modelClass = $this->modelClass;
        $this->excludedHiddenStatuses[] = $modelClass::STATUS_DELETED;
        return $this;
    }

    /**
     * Exclude deleted & history statuses from hidden when search entity
     * @return $this
     */
    public function andArchived()
    {
        $modelClass = $this->modelClass;
        $this->excludedHiddenStatuses[] = $modelClass::STATUS_IN_HISTORY;
        return $this;
    }

    /**
     * Ignore hidden statuses. Useful when need to check uniqueness of AR with hidden statuses
     *
     * ```php
     *  [
     *       ['email'],
     *       'unique',
     *       'targetClass' => User::class,
     *       'filter' => function (UndeletableActiveQuery $query) {
     *          $query->ignoreHiddenStatuses();
     *       },
     *       'message' => 'Sorry, this email has already been taken',
     *
     *  ],
     * ```
     * @return $this
     */
    public function ignoreHiddenStatuses()
    {
        $modelClass = $this->modelClass;
        $this->excludedHiddenStatuses[] = $modelClass::STATUS_IN_HISTORY;
        $this->excludedHiddenStatuses[] = $modelClass::STATUS_DELETED;
        return $this;
    }

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