<?php


namespace backend\models;

use common\models\Company;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * Class Investigation
 * @package backend\models
 *
 * @property array $statusesList
 * @property array $allCompaniesList
 */
final class Investigation extends \common\models\Investigation
{
    use FactoryTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'match', 'pattern' => '/^\w*$/'];
        $rules[] = [['name'], 'unique', 'when' => function ($model, $attribute) {
            /** @var $model Investigation */
            return $model->isAttributeChanged($attribute, false);

        }, 'filter' => function(Query $query) {
            if ($this->company_id) {
                $query->where(['company_id' => $this->company_id]);
            }
        }];

        return $rules;
    }

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return array_slice(parent::getStatusLabels(), 1, null, true);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllCompaniesList()
    {
        $companies = Company::find()->select(['id', 'name'])->asArray();
        return array_column($companies->all(), 'name', 'id');
    }
}