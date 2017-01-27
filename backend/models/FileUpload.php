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
            [['description','parent'], 'safe']
        ];
    }

    public function save(){
        $model = new File();
        $this->file = UploadedFile::getInstance($this, 'file');
        $model->name = $this->file->name;
        $model->size = $this->file->size;
        $model->tmp = $this->file->tempName;
        $model->type = $this->file->extension;

        return $model->save();
    }
}
