<?php


namespace backend\models;

use backend\behaviors\CitrixFolderBehavior;
use backend\behaviors\HistoryBehavior;
use backend\behaviors\NotifyBehavior;
use yii\db\Query;

/**
 * Class Investigation
 * @package backend\models
 *
 * @property array $statusesList
 * @property array $allCompaniesList
 */
class Investigation extends \common\models\Investigation
{
    use FactoryTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'match', 'pattern' => '/^[\w\s]*$/'];
        $rules[] = [['name'], 'unique', 'when' => function ($model, $attribute) {
            /** @var $model Investigation */
            return $model->isAttributeChanged($attribute, false);

        }, 'filter' => function(Query $query) {
            if ($this->company_id) {
                $query->andWhere(['company_id' => $this->company_id]);
            }
        }];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['citrixFolderBehavior'] = [
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
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function(Investigation $model){
                return $model->id;
            },
            'company' => function(Investigation $model){
                return $model->company_id;
            },
            'attribute' => 'name',
            'type' => 'investigation',
        ];
        $behaviors['notify'] = [
            'class' => NotifyBehavior::class,
            'companyId' => function(Investigation $model) {
                return $model->company_id;
            },
            'createTemplate' => 'create',
            'updateTemplate' => 'update',
            'deleteTemplate' => 'delete',
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return array_slice(parent::getStatusesList(), -6, 5, true); //remove 'deleted' status
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