<?php


namespace common\models\query;


class UndeletableActiveQuery extends AbstractUndeletableActiveQuery
{
    public $modelClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //find out value of STATUS DELETED const for called class
        $modelClass = $this->modelClass;
        $this->hiddenStatuses = [$modelClass::STATUS_DELETED];
    }

    /**
     * Exclude deleted statuses from hidden when search entity
     * @return $this
     */
    public function andDeleted()
    {
        $modelClass = $this->modelClass;
        $this->excludedHiddenStatuses[] = $modelClass::STATUS_DELETED;
        return $this;
    }
}