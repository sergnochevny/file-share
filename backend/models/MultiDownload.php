<?php


namespace backend\models;


use yii\base\ErrorException;
use yii\base\Model;
use yii\grid\CheckboxColumn;

/**
 * Class MultiDownload
 * @package backend\models
 *
 * @property-read string $downloadUrl
 */
class MultiDownload extends Model
{
    /**
     * @see CheckboxColumn::$name
     * @var array|null
     */
    public $selection;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['selection'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * Searches files by ids (@see $this::selection),
     * packs them into archive and returns download link
     *
     * @return string
     * @throws ErrorException
     */
    public function getDownloadUrl()
    {
        if ($this->validate()) {
            throw new ErrorException('Input data is not valid');
        }

        $files = File::findAll(['id' => $this->selection]);
        if (empty($files)) {
            throw new ErrorException('These files not found');
        }

        foreach ($files as $file) {

        }
    }
}