<?php


namespace backend\models;

use common\models\Company;

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
        $rules[] = [['title'], 'unique'];
        return $rules;
    }

    /**
     * @return array
     */
    public function getStatusesList()
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