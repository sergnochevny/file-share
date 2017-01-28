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
                    'id' => 'citrix_id',
                    'tempPath' => 'tmp',
                    'parent' => function (File $model) {
                        if (empty($model->parent)) {
                            $allfiles = File::findOne(['parent' => 'root']);
                            if ($allfiles) $model->parent = $allfiles->citrix_id;
                            else {
                                $allfiles = new File(
                                    [
                                        'name' => 'AllFiles',
                                        'description' => 'Shared files root directory',
                                        'type' => 'folder',
                                        'parent' => 'root',
                                    ]
                                );
                                if ($allfiles->save()) $model->parent = $allfiles->citrix_id;
                            }
                        }
                        return $model->parent;
                    }
                ],
            ],
        ];
        return $behaviors;
    }
}
