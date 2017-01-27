<?php

namespace backend\models;

use backend\behaviors\UploadBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FileUpload extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'file', 'skipOnEmpty' => false],
            [['description','parent'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'uploadBehavior' => [
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
                    ],
                ],
            ],
        ];
    }
}
