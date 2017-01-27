<?php

namespace backend\behaviors;

use Citrix\CitrixApi;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use Yii;

/**
 * Class UploadBehavior
 * Uploading file Citrix behavior.
 *
 * Usage:
 * ```
 * ...
 * 'uploadBehavior' => [
 *     'class' => UploadBehavior::className(),
 *     ''
 *     'attributes' => [
 *         'name' => [
 *             'tempPath' => '@app/tmp/path',
 *             'url' => '/path/to/file'
 *             'parent' => 'dsfjhsdkfjhsdkfj'
 *         ],
 *     ]
 * ]
 * ...
 * ```
 */
class UploadBehavior extends Behavior
{
    /**
     * @event Event that will be call after successful file upload
     */
    const EVENT_AFTER_UPLOAD = 'afterUpload';
    /**
     * @var array Publish path cache array
     */
    protected static $_cachePublishPath = [];
    private $id;
    private $secret;
    private $user;
    private $pass;
    private $subdomain;

    /**
     * @var CitrixApi $Citrix
     */
    private $Citrix;

    /**
     * Are available 3 indexes:
     * - `path` Path where the file will be moved.
     * - `tempPath` Temporary path from where file will be moved.
     * - `url` Path URL where file will be saved.
     *
     * @var array Attributes array
     */
    public $attributes = [];
    /**
     * @var boolean If `true` current attribute file will be deleted
     */
    public $unlinkOnSave = true;
    /**
     * @var boolean If `true` current attribute file will be deleted after model deletion
     */
    public $unlinkOnDelete = true;

    /**
     * Save model attribute file.
     *
     * @param string $attribute Attribute name
     * @param bool $insert `true` on insert record
     */
    protected function saveFile($attribute, $insert = true)
    {
        if (empty($this->owner->$attribute)) {
            if ($insert !== true) {
                $this->deleteFile($this->oldFile($attribute));
            }
        } else {
            $tempFile = $this->tempFile($attribute);

            if (is_file($tempFile)) {

//                if (rename($tempFile, $file)) {
//                    if ($insert === false && $this->unlinkOnSave === true && $this->owner->getOldAttribute(
//                            $attribute
//                        )
//                    ) {
//                        $this->deleteFile($this->oldFile($attribute));
//                    }
//                    $this->triggerEventAfterUpload();
//                } else {
//                    unset($this->owner->$attribute);
//                }
            } elseif ($insert === true) {
                unset($this->owner->$attribute);
            } else {
                $this->owner->setAttribute($attribute, $this->owner->getOldAttribute($attribute));
            }
        }
    }

    /**
     * Delete specified file.
     *
     * @param string $file File path
     *
     * @return bool `true` if file was successfully deleted
     */
    protected function deleteFile($file)
    {
        if (is_file($file)) {
            return unlink($file);
        }

        return false;
    }

    /**
     * Trigger [[EVENT_AFTER_UPLOAD]] event.
     */
    protected function triggerEventAfterUpload()
    {
        $this->owner->trigger(self::EVENT_AFTER_UPLOAD);
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

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (empty($this->user)) throw new InvalidParamException("Identity user parameter");
        if (empty($this->pass)) throw new InvalidParamException("Identity pass parameter");
        if (empty($this->id)) throw new InvalidParamException("Identity id parameter");
        if (empty($this->secret)) throw new InvalidParamException("Identity secret parameter");
        if (empty($this->subdomain)) throw new InvalidParamException("Identity subdomain parameter");

        if (!is_array($this->attributes) || empty($this->attributes)) {
            throw new InvalidParamException('Invalid or empty attributes array.');
        } else {
            foreach ($this->attributes as $attribute => $config) {
//                if (!isset($config['tempPath']) || empty($config['tempPath'])) {
//                    throw new InvalidParamException('Temporary path must be set for all attributes.');
//                }
                if (!isset($config['citrix_id_field']) || empty($config['citrix_id_field'])) {
                    throw new InvalidParamException('citrix_id_field field name must be set for all attributes.');
                }
                $this->attributes[$attribute]['tempPath'] = FileHelper::normalizePath(Yii::getAlias($config['tempPath'])) . DIRECTORY_SEPARATOR;

                $validator = Validator::createValidator('string', $this->owner, $attribute);
                $this->owner->validators[] = $validator;
                unset($validator);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }

    public function beforeValidate($event)
    {
        $this->Citrix = CitrixApi::getInstance();
        $this->Citrix->setSubdomain($this->subdomain)
            ->setUsername($this->user)
            ->setPassword($this->pass)
            ->setClientId($this->id)
            ->setClientSecret($this->secret)
            ->Initialize();
    }

    /**
     * Function will be called before inserting the new record.
     */
    public function beforeInsert()
    {
        foreach ($this->attributes as $attribute => $config) {
            if ($this->owner->$attribute) {
                $id = $this->saveFile($attribute);
                $this->owner->setAttribute($config['id'], $id);
            }
        }
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Old file path
     */
    public function oldFile($attribute)
    {
        return $this->owner->getOldAttribute($attribute);
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Temporary file path
     */
    public function tempFile($attribute)
    {
        return $this->tempPath($attribute) . $this->owner->$attribute;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Path to temporary file
     */
    public function tempPath($attribute)
    {
        return $this->attributes[$attribute]['tempPath'];
    }

    /**
     * Publish given path.
     *
     * @param string $path Path
     *
     * @return string Published url (/assets/images/image1.png)
     */
    public function publish($path)
    {
        if (!isset(static::$_cachePublishPath[$path])) {
            static::$_cachePublishPath[$path] = Yii::$app->assetManager->publish($path)[1];
        }
        return static::$_cachePublishPath[$path];
    }

    /**
     * Function will be called before updating the record.
     */
    public function beforeUpdate()
    {
        foreach ($this->attributes as $attribute => $config) {
            if ($this->owner->isAttributeChanged($attribute)) {
                $id = $this->saveFile($attribute, false);
                $this->owner->setAttribute($config['id'], $id);
            }
        }
    }

    /**
     * Function will be called before deleting the record.
     */
    public function beforeDelete()
    {
        if ($this->unlinkOnDelete) {
            foreach ($this->attributes as $attribute => $config) {
                if ($this->owner->$attribute) {
                    $this->deleteFile($this->file($attribute));
                }
            }
        }
    }

    /**
     * Remove attribute and its file.
     *
     * @param string $attribute Attribute name
     *
     * @return bool Whenever the attribute and its file was removed
     */
    public function removeAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            if ($this->deleteFile($this->file($attribute))) {
                return $this->owner->updateAttributes([$attribute => null]);
            }
        }

        return false;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return null|string Full attribute URL
     */
    public function urlAttribute($attribute)
    {
        if (isset($this->attributes[$attribute]) && $this->owner->$attribute) {
            return $this->attributes[$attribute]['url'] . $this->owner->$attribute;
        }

        return null;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Attribute mime-type
     */
    public function getMimeType($attribute)
    {
        return FileHelper::getMimeType($this->file($attribute));
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return boolean Whether file exist or not
     */
    public function fileExists($attribute)
    {
        return file_exists($this->file($attribute));
    }
}
