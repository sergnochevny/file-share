<?php


namespace backend\models;


use Citrix\CitrixApi;
use GuzzleHttp\Psr7\Stream;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\grid\CheckboxColumn;
use ZipArchive;

/**
 * Class MultiDownload
 * @package backend\models
 *
 * @property-read string $archiveFilename
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

    /** @var string|null */
    private $archiveFilename;

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
     * @throws ErrorException
     */
    public function packIntoArchive()
    {
        if (!$this->validate()) {
            throw new ErrorException('Input data is not valid');
        }

        $files = File::findAll(['id' => $this->selection]);
        if (empty($files)) {
            throw new ErrorException('These files not found');
        }

        $items = $this->citrix->getItemsService();
        $zip = $this->createZip();
        foreach ($files as $file) {
            $item = $items
                ->setId($file->citrix_id)
                ->setRedirect(CitrixApi::FALSE)
                ->setIncludeAllVersions(CitrixApi::FALSE)
                ->ItemContent;

            $downloadUrl = $item->DownloadUrl;
            $content = file_get_contents($downloadUrl);

            $zip->addFromString($file->name, $content);
        }
        $zip->close();
    }

    /**
     * @return string
     */
    public function getArchiveFilename()
    {
        return $this->archiveFilename;
    }

    /**
     * @return \ZipArchive
     * @throws ErrorException
     */
    private function createZip()
    {
        $zip = new ZipArchive;
        $this->archiveFilename = 'all-' . uniqid() . '.zip';
        $zipFile = Yii::getAlias('@webroot/temp/' . $this->archiveFilename);
        $res = $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($res !== true) {
            throw new ErrorException('Cannot create zip archive');
        }

        return $zip;
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