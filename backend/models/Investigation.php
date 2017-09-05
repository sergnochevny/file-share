<?php


namespace backend\models;

use backend\behaviors\CitrixFolderBehavior;
use backend\behaviors\HistoryBehavior;
use backend\behaviors\NotifyBehavior;
use backend\models\traits\ExtendFindConditionTrait;
use backend\models\traits\FactoryTrait;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Class Investigation
 * @package backend\models
 *
 * @property-read string $citrixFolderName
 * @property-read string $formattedSsn
 * @property array $statusesList
 * @property array $allCompaniesList
 *
 * @property User $createdBy
 * @property User[] $users
 */
class Investigation extends \common\models\Investigation
{
    use FactoryTrait;
    use ExtendFindConditionTrait;

    const EVENT_BEFORE_COMPLETE = 'beforeComplete';
    const EVENT_AFTER_COMPLETE = 'afterComplete';

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return array_slice(parent::getStatusesList(), -6, 5, true); //remove 'deleted' status
    }

    /**
     * Changes status of record to STATUS_COMPLETED
     *
     * @return bool
     */
    protected function internalComplete()
    {
        $res = false;
        if ($this->beforeComplete()) {
            $this->off(ActiveRecord::EVENT_BEFORE_UPDATE);
            $this->off(ActiveRecord::EVENT_AFTER_UPDATE);
            $this->status = static::STATUS_COMPLETED;
            if ($this->save(false)) {
                $res = $this->afterComplete();
            }
        }

        return $res;
    }

    /**
     * @return bool
     */
    protected function afterComplete()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_AFTER_COMPLETE, $event);
        return $event->isValid;
    }

    /**
     * @return bool
     */
    protected function beforeComplete()
    {
        $event = new ModelEvent;
        $this->trigger(self::EVENT_BEFORE_COMPLETE, $event);
        return $event->isValid;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'match', 'pattern' => '/^[\w\s]*$/'];
        $rules[] = [
            ['name'],
            'unique',
            'when' => function ($model, $attribute) {
                /** @var $model Investigation */
                return $model->isAttributeChanged($attribute, false);
            },
            'filter' => function (Query $query) {
                if ($this->company_id) {
                    $query->andWhere(['company_id' => $this->company_id]);
                }
            }
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['citrixFolderBehavior'] = [
            'class' => CitrixFolderBehavior::className(),
            'attribute' => 'citrix_id',
            'folder' => 'citrixFolderName',
            'subdomain' => \Yii::$app->keyStorage->get('citrix.subdomain'),
            'user' => \Yii::$app->keyStorage->get('citrix.user'),
            'pass' => \Yii::$app->keyStorage->get('citrix.pass'),
            'id' => \Yii::$app->keyStorage->get('citrix.id'),
            'secret' => \Yii::$app->keyStorage->get('citrix.secret'),
            'parent' => function (Investigation $model) {
                /**
                 * @var Investigation $model
                 */
                return $model->company->citrix_id;
            }
        ];
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function (Investigation $model) {
                return $model->id;
            },
            'company' => function (Investigation $model) {
                return $model->company_id;
            },
            'attribute' => function ($model) {
                return $this->fullName;
            },
        ];
        $behaviors['notify'] = [
            'class' => NotifyBehavior::class,
            'sendFrom' => function () {
                return \Yii::$app->keyStorage->get('system.sendfrom');
            },
            'companyId' => function (Investigation $model) {
                return $model->company_id;
            },
            'createTemplate' => 'create',
            'updateTemplate' => 'update',
            'completeTemplate' => 'completed',
            'deleteTemplate' => 'delete',
        ];

        return $behaviors;
    }

    /**
     * @return string
     */
    public function getCitrixFolderName()
    {
        $lastName = '';
        if (!empty($this->last_name)) {
            $lastName = '-' . $this->last_name;
        }

        return $this->first_name . $lastName . '-' . $this->ssn;
    }

    /**
     * @return string
     */
    public function getOldCitrixFolderName()
    {
        $lastName = '';
        if (!empty($this->getOldAttribute('last_name'))) {
            $lastName = '-' . $this->getOldAttribute('last_name');
        }

        return $this->getOldAttribute('first_name') . $lastName . '-' . $this->getOldAttribute('ssn');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllCompaniesList()
    {
        $companies = Company::find()->select(['id', 'name'])->asArray();
        return array_column($companies->all(), 'name', 'id');
    }

    /**
     * @return Query
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return string
     */
    public function getFormattedSsn()
    {
        return preg_replace("#^(\d{3})-?(\d{2})-?(\d{4})$#", "$1-$2-$3", $this->ssn);
    }

    /**
     * @return Query
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['parent' => 'citrix_id'])->inverseOf('investigation');
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function complete()
    {
        $this->detachBehavior('citrixFolderBehavior');
        $res = $this->internalComplete(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Investigation: "' . $this->fullName . '" doesn`t to complete!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

}