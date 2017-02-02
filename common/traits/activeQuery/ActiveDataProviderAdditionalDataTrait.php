<?php

namespace common\traits\activeQuery;

use yii\db\ActiveQuery;

trait ActiveDataProviderAdditionalDataTrait
{
    /**
     * Performs ajax validation.
     *
     * @param ActiveQuery $query
     * @param array $relations
     * @param array $where
     * @param null $order
     * @internal param Model $model
     * @return ActiveQuery
     */
    protected function assignOptions(ActiveQuery $query, array $relations = null, array $where = null, $order = null)
    {
        if (isset($relations) && is_array($relations)) $query->join('LEFT', $relations['rel'], isset($relations['cond']) ? $relations['cond'] : null);
        if (isset($where) && is_array($where)) $query->where($where);
        if (isset($order) && is_array($order)) $query->orderBy($order);
        return $query;
    }
}