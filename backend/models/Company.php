<?php


namespace backend\models;


use backend\behaviors\CitrixFolderBehavior;

final class Company extends \common\models\Company
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
        $rules[] = ['name', 'match', 'pattern' => '/^\w*$/'];
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
        $behaviors[] = [
            'class' => CitrixFolderBehavior::className(),
            'attribute' => 'citrix_id',
            'folder' => 'name',
            'subdomain' => \Yii::$app->keyStorage->get('citrix.subdomain'),
            'user' => \Yii::$app->keyStorage->get('citrix.user'),
            'pass' => \Yii::$app->keyStorage->get('citrix.pass'),
            'id' => \Yii::$app->keyStorage->get('citrix.id'),
            'secret' => \Yii::$app->keyStorage->get('citrix.secret'),
        ];

        return $behaviors;
    }
}