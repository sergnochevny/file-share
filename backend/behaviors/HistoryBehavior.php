<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 31.01.2017
 * Time: 15:55
 */

namespace backend\behaviors;


use common\models\History;
use common\models\HistoryActiveRecord;
use common\models\UndeleteableActiveRecord;
use yii\base\Behavior;
use yii\base\InvalidCallException;
use yii\base\InvalidParamException;

class HistoryBehavior extends Behavior
{

    private $attribute;

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
            UndeleteableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive',
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);

        if (empty($this->attribute)) throw new InvalidParamException("Identity attribute parameter");
        if (empty($this->parent)) throw new InvalidParamException("Identity parent parameter");
    }

    public function beforeArchive($event)
    {

        if ($this->parent instanceof \Closure) {
            $this->parent = call_user_func($this->parent, $this->owner);
        }

        if ($this->company instanceof \Closure) {
            $this->company = call_user_func($this->company, $this->owner);
        }

        $attributeAsValue = false;
        if ($this->attribute instanceof \Closure) {
            $this->attribute = call_user_func($this->attribute, $this->owner);
            $attributeAsValue = true;
        }

        $model = $this->owner;
        if (!$model instanceof HistoryActiveRecord) {
            throw new InvalidCallException('Model must be instance of the HistoryActiveRecord class!');
        }
        $history = new History();
        if (!($history->load(
                [
                    'name' => ($attributeAsValue ? $this->attribute : $model->getAttribute($this->attribute)),
                    'type' => $model->getHistoryType(),
                    'parent' => $this->parent,
                    'company_id' => $this->company
                ]
            ) && $history->save())
        ) {
            if ($history->hasErrors()) {
                $m_errors = $history->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Don`t history save!'];
            }
            throw new InvalidParamException(implode('<br>', $errors));
        }
    }
}