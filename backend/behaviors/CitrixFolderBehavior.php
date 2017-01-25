<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 25.01.2017
 * Time: 12:48
 */

namespace backend\behaviors;


use Citrix\CitrixApi;
use Citrix\ShareFile\Api\Models\Folder;
use yii\base\InvalidParamException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class CitrixFolderBehavior extends AttributeBehavior
{

    public $attribute;

    public $folder;

    public $id;

    public $secret;

     public $user;

    public $pass;

    public $subdomain;

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->owner->getIsNewRecord()) {

            $Citrix = new CitrixApi();
            $Citrix->setSubdomain($this->subdomain)
                ->setUsername($this->user)
                ->setPassword($this->pass)
                ->setClientId($this->id)
                ->setClientSecret($this->secret)
                ->Initialize();

            $items = $Citrix->Items;
            $folder = new Folder(
                [
                    'Name' => $this->owner->name,
                    'Description' => 'Company ' . $this->owner->name
                ]
            );
            $create_folder = $items
                ->setOverwrite(CitrixApi::TRUE)
                ->CreateFolder($folder);
            /* @var Folder $create_folder
             **/
            $value = $create_folder->Id;

        } else $value = parent::getValue($event);

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->attribute)) throw new InvalidParamException("Identity attribute parameter");
        if (!is_string($this->attribute)) throw new InvalidParamException("Attribute parameter is a table field name");
        if (empty($this->folder)) throw new InvalidParamException("Identity folder parameter");
        if (!is_string($this->attribute)) throw new InvalidParamException("Folder parameter is a table field name associated folder name");
        if (empty($this->user)) throw new InvalidParamException("Identity user parameter");
        if (empty($this->pass)) throw new InvalidParamException("Identity pass parameter");
        if (empty($this->id)) throw new InvalidParamException("Identity id parameter");
        if (empty($this->secret)) throw new InvalidParamException("Identity secret parameter");
        if (empty($this->subdomain)) throw new InvalidParamException("Identity subdomain parameter");

        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->attribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->attribute],
            ];
        }
    }

}