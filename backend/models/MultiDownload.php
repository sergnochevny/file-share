<?php


namespace backend\models;


use Citrix\CitrixApi;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
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

    /** @var CitrixApi */
    private $citrix;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initCitrix();
    }

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

    /**
     * Initialize citrix from keyStorage component
     *
     * @return void
     * @throws InvalidConfigException
     */
    private function initCitrix()
    {
        $ks = Yii::$app->get('keyStorage');
        if (null === $ks) {
            throw new InvalidConfigException('Component keyStorage does not set');
        }

        $get = function ($field) use ($ks) {
            return $ks->get('citrix.' . $field);
        };

        $citrix = CitrixApi::getInstance();
        $citrix->setSubdomain($get('subdomain'))
            ->setUsername($get('user'))
            ->setPassword($get('pass'))
            ->setClientId($get('id'))
            ->setClientSecret($get('secret'))
            ->Initialize();

        $this->citrix = $citrix;
    }

}