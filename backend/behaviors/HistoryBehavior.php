<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 31.01.2017
 * Time: 15:55
 */

namespace backend\behaviors;


use common\models\History;
use common\models\UndeletableActiveRecord;
use yii\base\Behavior;
use yii\base\InvalidParamException;

class HistoryBehavior extends Behavior
{

    private $attribute;

    private $type = null;

    private $parent = null;

    private $company = null;

    /**
     * @return null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
     * @return null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param null $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function events()
    {
        return [
            UndeletableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive',
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);

        if (empty($this->attribute)) throw new InvalidParamException("Identity attribute parameter");
        if (empty($this->type)) throw new InvalidParamException("Identity type parameter");
        if (empty($this->parent)) throw new InvalidParamException("Identity parent parameter");
    }

    public function beforeArchive($event)
    {
        if ($this->type instanceof \Closure) {
            $this->type = call_user_func($this->type, $this->owner);
        }

        if ($this->parent instanceof \Closure) {
            $this->parent = call_user_func($this->parent, $this->owner);
        }

        if ($this->company instanceof \Closure) {
            $this->company = call_user_func($this->company, $this->owner);
        }

        $model = $this->owner;
        $history = new History();
        if(!($history->load(
            [
                'name' => $model->{$this->attribute},
                'type' => $this->type,
                'parent' => $this->parent,
                'company_id' => $this->company
            ]
        ) && $history->save())){
            if ($history->hasErrors()){
                $error = implode('|',$history->errors);
            } else {
                $error = 'Do`nt history save!';
            }
            throw new InvalidParamException($error);
        }
    }
}