<?php


namespace backend\models;

use backend\behaviors\CitrixFolderBehavior;
use backend\behaviors\HistoryBehavior;
use backend\behaviors\NotifyBehavior;
use backend\behaviors\VerifyPermissionBehavior;
use backend\models\extend_find_traits\CompanyExtends;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * Class Company
 * @package backend\models
 *
 * @property-read $citrixFolderName
 * @property-read Investigation[] $investigations
 * @property-read Investigation[] $investigationsWh
 */
class Company extends \common\models\Company
{
    use FactoryTrait;
    use CompanyExtends;

    /**
     * Gets list [id => name] of companies
     * @return array
     */
    public static function getList()
    {
        $companies = static::find()->select(['id', 'name'])->asArray()->all();
        return array_column($companies, 'name', 'id');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        //todo unique what if user will create Company and then Company', what will be with folder in citrix
        //  $rules[] = ['name', 'match', 'pattern' => '/^[\w\s]*$/'];
        $rules[] = [
            ['name'],
            'unique',
            'when' => function ($model, $attribute) {
                /** @var $model Company */
                return $model->isAttributeChanged($attribute, false);
            }
        ];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['VerifyPermissionBehavior'] = [
            'class' => VerifyPermissionBehavior::className()
        ];
        $behaviors['citrixFolderBehavior'] = [
            'class' => CitrixFolderBehavior::className(),
            'attribute' => 'citrix_id',
            'folder' => 'citrixFolderName',
            'subdomain' => \Yii::$app->keyStorage->get('citrix.subdomain'),
            'user' => \Yii::$app->keyStorage->get('citrix.user'),
            'pass' => \Yii::$app->keyStorage->get('citrix.pass'),
            'id' => \Yii::$app->keyStorage->get('citrix.id'),
            'secret' => \Yii::$app->keyStorage->get('citrix.secret'),
        ];
        $behaviors['notify'] = [
            'class' => NotifyBehavior::class,
            'sendFrom' => function () {
                return \Yii::$app->keyStorage->get('system.sendfrom');
            },
            'companyId' => function (Company $model) {
                return $model->id;
            },
            'createTemplate' => 'create',
            'updateTemplate' => 'update',
            'deleteTemplate' => 'delete',
        ];
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function (Company $model) {
                return $model->id;
            },
            'company' => function (Company $model) {
                return $model->id;
            },
            'attribute' => 'name',
            'type' => 'company',
        ];

        return $behaviors;
    }

    /**
     * @return Query
     */
    public function getInvestigations()
    {
        return $this->hasMany(Investigation::class, ['company_id' => 'id'])->inverseOf('company');
    }


    /**
     * @return string
     */
    public function getCitrixFolderName()
    {
        return Inflector::slug($this->name);
    }

    /**
     * @return string
     */
    public function getOldCitrixFolderName()
    {
        return Inflector::slug($this->getOldAttribute('name'));
    }

}