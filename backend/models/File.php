<?php

namespace backend\models;

use backend\behaviors\HistoryBehavior;
use backend\behaviors\UploadBehavior;
use common\models\UserCompany;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property Investigation $investigation
 * @property User[] $user
 * @property ActiveRecord $parents
 */
class File extends \common\models\File
{

    public $tmp;

    /**
     * @return mixed
     */
    public function getCompany_Id()
    {
        return \Yii::$app->user->identity->company->id;
    }

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
                                if ($allfiles->save(false)) $model->parent = $allfiles->citrix_id;
                            }
                        }
                        return $model->parent;
                    }
                ],
            ],
        ];
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function (File $model) {
                return $model->id;
            },
            'company' => function (File $model) {
                $company_id = null;
                $investigation = $model->investigation;
                if (!empty($investigation)) $company_id = $investigation->company_id;
                return $company_id;
            },
            'attribute' => 'name',
            'type' => 'file',
        ];
        $behaviors['TimestampBehavior'] = [
            'class' => TimestampBehavior::className()
        ];
        return $behaviors;
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->via('userCompanies');
    }

    /**
     * @return UserCompany
     */
    public function getUserCompanies()
    {
        return $this->hasOne(UserCompany::className(), ['company_id' => 'company_id'])
            ->via('investigation');
    }


    /**
     * @return Investigation
     */
    public function getInvestigation()
    {
        return $this->hasOne(Investigation::className(), ['citrix_id' => 'parent'])->inverseOf('files');
    }

    /**
     * @return File
     */
    public function getParents()
    {
        return $this->hasOne(File::className(), ['citrix_id' => 'parent']);
    }


}
