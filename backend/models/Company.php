<?php


namespace backend\models;


use backend\behaviors\CitrixFolderBehavior;

final class Company extends \common\models\Company
{
    /**
     * Find model by id or creates one
     *
     * @param $id
     * @return Company|static
     */
    public static function create($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            return self::findOne($id);
        }

        return new self();
    }

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