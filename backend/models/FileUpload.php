<?php

namespace backend\models;

use backend\behaviors\UploadBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class FileUpload extends Model
{
    static private $fileThumbnailMap = [
        'doc' => 'doc',
        'docx' => 'doc',
        'xls' => 'xls',
        'pdf' => 'pdf',
        'zip' => 'zip',
        'rar' => 'zip',
        'att' => 'att',
        'png' => 'pic',
        'jpg' => 'pic',
        'jpeg' => 'pic',
    ];

    public $update = false;
    public $model;
    public $file;
    public $description;
    public $parent;

    public static function fileExt($ext)
    {
        return isset(self::$fileThumbnailMap[$ext]) ? self::$fileThumbnailMap[$ext] : 'att';
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->file = UploadedFile::getInstance($this, 'file');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['description'], 'string']
        ];
    }

    public function save()
    {

        if (empty($this->parent)) {
            $parent = File::findOne(['parent' => 'root']);
            if (!empty($parent)) {
                $this->parent = $parent->citrix_id;
            } else return false;
        }

        $this->model = File::findOne(['name' => $this->file->name, 'parent' => $this->parent]);
        if (empty($this->model)){
            $this->model = new File();
            $this->update = true;
        }
        $this->model->name = $this->file->name;
        $this->model->size = $this->file->size;
        $this->model->tmp = $this->file->tempName;
        $this->model->type = $this->file->extension;
        $this->model->parent = $this->parent;
        $this->model->description = $this->description;
        $this->model->updated_at = 0;

        return $this->model->save();
    }

    public function getModelErrors()
    {
        $errors = [];
        foreach ($this->getFirstErrors() as $error) {
            $errors[] = $error;
        }

        return $errors;
    }

}
