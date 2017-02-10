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

    public $file;
    public $description;
    public $parent;

    public static function fileExt($ext)
    {
        return isset(self::$fileThumbnailMap[$ext]) ? self::$fileThumbnailMap[$ext] : 'att';
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

        $this->file = UploadedFile::getInstance($this, 'file');
        $model = File::findOne(['name' => $this->file->name, 'parent' => $this->parent]);
        if (empty($model)) $model = new File();
        $model->name = $this->file->name;
        $model->size = $this->file->size;
        $model->tmp = $this->file->tempName;
        $model->type = $this->file->extension;
        $model->parent = $this->parent;
        $model->description = $this->description;

        return $model->save();
    }
}
