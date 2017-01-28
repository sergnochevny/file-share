<?php


namespace backend\models;

use backend\behaviors\CitrixFolderBehavior;
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

        }, 'filter' => $this->filterName()];

        return $rules;
    }

    public function filterName()
    {
        $company_id = $this->company_id;

        return function ($query) use ($company_id) {
            /** @var Query $query */
            $query->where(['company_id' => $company_id]);
        };
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => CitrixFolderBehavior::className(),
            'attribute' => 'citrix_id',
            'folder' => 'name',
            'subdomain' => \Yii::$app->keyStorage->get('citrix.subdomain'),
            'user' => \Yii::$app->keyStorage->get('citrix.user'),
            'pass' => \Yii::$app->keyStorage->get('citrix.pass'),
            'id' => \Yii::$app->keyStorage->get('citrix.id'),
            'secret' => \Yii::$app->keyStorage->get('citrix.secret'),
            'parent' => function(Investigation $model){
                /**
                 * @var Investigation $model
                 */
                return $model->company->citrix_id;
            }
        ];

        return $behaviors;
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