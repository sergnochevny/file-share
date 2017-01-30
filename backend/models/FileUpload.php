<?php

namespace backend\models;

use backend\behaviors\UploadBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class FileUpload extends Model
{
    public $file;
    public $description;
    public $parent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['description'], 'safe']
        ];
    }

    public function save()
    {

        if (empty($this->parent)) {
            $this->parent = File::findOne(['parent' => 'root']);
            if (!empty($parent)) {
                $this->parent = $parent->citrix_id;
            } else return false;
        }

        $this->file = UploadedFile::getInstance($this, 'file');
        $model = File::findOne(['name' => $this->file->name, 'parent' => $this->parent]);
        if (empty($model)) $model = new File();
        $model->name = $this->file->name;
        $model->size = $this->file->size;
        $model->tmp = $this->file->tempName;
        $model->type = $this->file->extension;
        $model->parent = $this->parent;

        return $model->save();
    }
}
