<?php


namespace backend\models;

use common\behaviors\ArchiveCascadeBehavior;
use backend\behaviors\CitrixFolderBehavior;
use backend\behaviors\HistoryBehavior;
use backend\behaviors\NotifyBehavior;
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
 * @property [Users] $users
 */
class Investigation extends \common\models\Investigation
{
    use FactoryTrait;

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return array_slice(parent::getStatusesList(), -6, 5, true); //remove 'deleted' status
    }

    /**
     * @inheritdoc
     */
    protected static function extendFindConditionByPermissions(&$query)
    {
        $permissions = ['investigation.find.all'];
        $can = false;
        foreach ($permissions as $permission) {
            $can = $can || \Yii::$app->user->can($permission);
        }
        if (!$can) {
            $permissions = ['investigation.find.group'];
            $can = false;
            foreach ($permissions as $permission) {
                $can = $can || \Yii::$app->user->can($permission);
            }
            if (!$can) {
                $query->andWhere(['investigation.created_by' => \Yii::$app->user->id]);
            } else {

            }
        } else {
            if (!\Yii::$app->user->can('company.find.all')) {
                $query->joinWith('users');
                $query->andWhere(['user.id' => \Yii::$app->user->id]);
            }
        }
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
     * @return UndeletableActiveQuery
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
     * @return UndeletableActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['parent' => 'citrix_id'])->inverseOf('investigation');
    }

}