<?php


namespace backend\models;


use common\behaviors\ArchiveCascadeBehavior;
use backend\behaviors\CitrixFolderBehavior;
use backend\behaviors\HistoryBehavior;
use backend\behaviors\NotifyBehavior;
use common\models\UndeletableActiveRecord;
use yii\helpers\Inflector;

/**
 * Class Company
 * @package backend\models
 *
 * @property-read $citrixFolderName
 * @property-read Investigation[] $investigations
 */
class Company extends \common\models\Company
{
    use FactoryTrait;

    /**
     * Gets list [id => name] of companies
     *
     * @return array
     */
    public static function getList()
    {
        $companies = self::find()->select(['id', 'name'])->asArray()->all();
        return array_column($companies, 'name', 'id');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
      //  $rules[] = ['name', 'match', 'pattern' => '/^[\w\s]*$/']; //todo unique what if user will create Company and then Company', what will be with folder in citrix
        $rules[] = [['name'], 'unique', 'when' => function ($model, $attribute) {
            /** @var $model Company */
            return $model->isAttributeChanged($attribute, false);
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
        ];
        $behaviors['notify'] = [
            'class' => NotifyBehavior::class,
            'companyId' => function(Company $model) {
                return $model->id;
            },
            'createTemplate' => 'create',
            'updateTemplate' => 'update',
            'deleteTemplate' => 'delete',
        ];
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function(Company $model){
                return $model->id;
            },
            'company' => function(Company $model){
                return $model->id;
            },
            'attribute' => 'name',
            'type' => 'company',
        ];

        return $behaviors;
    }

    /**
     * @return UndeletableActiveRecord
     */
    public function getInvestigations()
    {
        return $this->hasMany(Investigation::class, ['company_id' => 'id'])->inverseOf('company');
    }

    /**
     * @dev
     * @return string
     */
    public function getCitrixFolderName()
    {
        return Inflector::slug($this->name);
    }


}