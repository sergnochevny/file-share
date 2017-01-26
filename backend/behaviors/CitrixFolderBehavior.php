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
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;

class CitrixFolderBehavior extends Behavior
{

    private $attribute;
    private $folder;
    private $id;
    private $secret;
    private $user;
    private $pass;
    private $subdomain;

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
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * @param mixed $subdomain
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        if (empty($this->attribute)) throw new InvalidParamException("Identity attribute parameter");
        if (!is_string($this->attribute)) throw new InvalidParamException("Attribute parameter is a table field name");
        if (empty($this->folder)) throw new InvalidParamException("Identity folder parameter");
        if (!is_string($this->folder)) throw new InvalidParamException("Folder parameter is a table field name associated folder name");
        if (empty($this->user)) throw new InvalidParamException("Identity user parameter");
        if (empty($this->pass)) throw new InvalidParamException("Identity pass parameter");
        if (empty($this->id)) throw new InvalidParamException("Identity id parameter");
        if (empty($this->secret)) throw new InvalidParamException("Identity secret parameter");
        if (empty($this->subdomain)) throw new InvalidParamException("Identity subdomain parameter");
    }


}