<?php

namespace common\models;

use common\behaviors\ArchiveCascadeBehavior;
use common\models\query\UndeletableActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\linkmany\LinkManyBehavior;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $case_number
 * @property string $address
 * @property string $description
 * @property string $city
 * @property string $state
 * @property string $zip
 *
 * @property array $investigationTypeIds
 *
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Investigation[] $investigations
 * @property User[] $users
 * @property InvestigationType[] $investigationTypes
 */
class Company extends HistoryActiveRecord
{

    static public $history_type = 'company';
    public $recoverStatus = self::STATUS_ACTIVE;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    final public static function getStatusesList()
    {
        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_ACTIVE => 'Active'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ArchiveCascadeBehavior::class,
            [
                'class' => LinkManyBehavior::class,
                'relation' => 'investigationTypes',
                'relationReferenceAttribute' => 'investigationTypeIds',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'address', 'city', 'state'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
            [['case_number'], 'string', 'max' => 7],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_IN_HISTORY, self::STATUS_DELETED]],
            ['investigationTypeIds', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'investigationTypeIds' => 'Investigation Types'
        ];
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getInvestigations()
    {
        return $this->hasMany(Investigation::class, ['company_id' => 'id'])->inverseOf('company');
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_company', ['company_id' => 'id']);
    }

    public function getInvestigationTypes()
    {
        return $this->hasMany(InvestigationType::class, ['id' => 'investigation_type_id'])
            ->viaTable('company_investigation_type', ['company_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function hasActiveInvestigations()
    {
        $activeStatuses = [
            Investigation::STATUS_IN_PROGRESS,
            Investigation::STATUS_PENDING
        ];

        return static::find()
            ->joinWith('investigations')
            ->andWhere(['investigation.status' => $activeStatuses])
            ->exists();
    }

    public function archive()
    {
        $this->detachBehavior('citrixFolderBehavior');
        $res = parent::archive(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Company: "' . $this->name . '" doesn`t archiving!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

    public function recover()
    {
        $this->detachBehavior('citrixFolderBehavior');
        $res = parent::recover(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Investigation: "' . $this->name . '" doesn`t to recover!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }


}
