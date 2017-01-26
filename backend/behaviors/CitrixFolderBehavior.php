<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 25.01.2017
 * Time: 12:48
 */

namespace backend\behaviors;


use Citrix\CitrixApi;
use Citrix\Endpoints\Items;
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
    private $parent;

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        if ( $parent instanceof \Closure){
            $parent = call_user_func($parent);
        }
        $this->parent = $parent;
    }

    /**
     * @var CitrixApi $Citrix
     */
    private $Citrix;

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
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
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

        $this->Citrix = CitrixApi::getInstance();
        $this->Citrix->setSubdomain($this->subdomain)
            ->setUsername($this->user)
            ->setPassword($this->pass)
            ->setClientId($this->id)
            ->setClientSecret($this->secret)
            ->Initialize();
    }

    public function beforeInsert($event)
    {
        try {
            $items = $this->Citrix->Items;
            $folder = new Folder(
                [
                    'Name' => $this->owner->{$this->folder},
                    'Description' => 'Company ' . $this->owner->{$this->folder}
                ]
            );
            if(!empty($this->parent)) $items->setId($this->parent);
            $create_folder = $items
                ->setOverwrite(CitrixApi::FALSE)
                ->CreateFolder($folder);
            /* @var Folder $create_folder
             **/
            $this->owner->{$this->attribute} = $create_folder->Id;
        } catch (\Exception $e) {
            $event->isValid = false;
        }
    }

    public function beforeUpdate($event)
    {
        /**
         * @var Folder $folder
         * @var Items $items
         */

        try {
            $items = $this->Citrix->Items;
            $item = $items
                ->setExpandChildren(CitrixApi::FALSE)
                ->setId($this->owner->{$this->id})
                ->Items;
            $item->Name = $this->owner->{$this->folder};
            $item->Description = 'Company ' . $this->owner->{$this->folder};
            $folder = $items->UpdateItem($item);
            $this->owner->{$this->attribute} = $folder->Id;
        } catch (\Exception $e) {
            $event->isValid = false;
        }
    }

}