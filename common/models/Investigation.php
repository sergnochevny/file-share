<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii2tech\ar\linkmany\LinkManyBehavior;

/**
 * This is the model class for table "{{%investigation}}".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $start_date
 * @property string $end_date
 * @property string $name
 * @property string $case_number
 * @property string $description
 * @property string $contact_person
 * @property string $phone
 * @property string $email
 *
 * @property integer $created_by
 *
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $citrix_id
 *
 * @property array $investigationTypeIds
 *
 * @property array $statusLabels
 *
 * @property Company $company
 * @property InvestigationType[] $investigationTypes
 * @property User $createdBy
 */
class Investigation extends UndeletableActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_CANCELLED = 100;
    const STATUS_IN_HISTORY = 200;
    const STATUS_PENDING = 250;
    const STATUS_IN_PROGRESS = 300;
    const STATUS_COMPLETED = 400;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%investigation}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
            [['company_id'], 'required', 'message' => 'Please select company'],
            [['company_id'], 'integer'],
            ['start_date', 'default', 'value' => new Expression('NOW()')],
            ['name', 'required'],
            [['name', 'contact_person', 'case_number'], 'string'],
            ['phone', 'number'],
            ['email', 'email'],
            [['description'], 'string', 'max' => 2000],
            ['status', 'default', 'value' => self::STATUS_IN_PROGRESS],
            ['status', 'in', 'range' => [
                self::STATUS_COMPLETED, self::STATUS_IN_PROGRESS, self::STATUS_PENDING,
                self::STATUS_IN_HISTORY, self::STATUS_CANCELLED, self::STATUS_DELETED
            ]],
            [
                ['company_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Company::className(),
                'targetAttribute' => ['company_id' => 'id']
            ],
            [
                ['created_by'], 'exist', 'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['created_by' => 'id']
            ],

            ['investigationTypeIds', 'safe'],
        ];
    }

    /**
     * Validates and converts date from jUI to Y-m-d mysql date
     * @todo remove. Not needed any more
     * @param $attribute
     * @param $params
     */
    public function parseDates($attribute, $params)
    {
        if (!$this->hasErrors() && !empty($this->$attribute)) {
            $date = \DateTime::createFromFormat('m.d.Y', $this->$attribute);
            if ($date) {
                $this->$attribute = $date->format('Y-m-d');
            }
        }
    }

    /**
     * @return array
     */
    public static function getStatusesList()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_IN_HISTORY => 'In history',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusesCSSList()
    {
        return [
            self::STATUS_PENDING => 'info',
            self::STATUS_IN_PROGRESS => 'warning',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_IN_HISTORY => 'default',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_DELETED => 'danger',
        ];
    }
    /**
     * @param $code
     * @return string|null
     */
    public static function getStatusByCode($code)
    {
        $statuses = static::getStatusesList();
        return isset($statuses[$code]) ? $statuses[$code] : null;
    }

    public static function getStatusCSSClass($code)
    {
        $statuses = static::getStatusesCSSList();
        return isset($statuses[$code]) ? $statuses[$code] : null;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'name' => 'Applicant Name',
            'description' => 'Description',
            'contact_person' => 'Contact Person',
            'phone' => 'Phone',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'investigationTypeIds' => 'Type'
        ];
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('investigations');
    }

    public function getInvestigationTypes()
    {
        return $this->hasMany(InvestigationType::class, ['id' => 'investigation_type_id'])
            ->viaTable('investigation_investigation_type', ['investigation_id' => 'id']);
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
