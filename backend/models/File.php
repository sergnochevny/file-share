<?php

namespace backend\models;

use backend\behaviors\UploadBehavior;

class File extends \common\models\File
{

    public $tmp;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['description'], 'string'],
            [['size', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent', 'citrix_id'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadBehavior'] = [
            'class' => UploadBehavior::className(),
            'subdomain' => \Yii::$app->keyStorage->get('citrix.subdomain'),
            'user' => \Yii::$app->keyStorage->get('citrix.user'),
            'pass' => \Yii::$app->keyStorage->get('citrix.pass'),
            'id' => \Yii::$app->keyStorage->get('citrix.id'),
            'secret' => \Yii::$app->keyStorage->get('citrix.secret'),
            'attributes' => [
                'name' => [
                    'attribute' => 'name',
                    'citrix_id_field' => 'citrix_id',
                    'tempPath' => 'tmp'

                ],
            ],
        ];
        return $behaviors;
    }
}
