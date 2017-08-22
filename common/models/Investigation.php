<?php

namespace common\models;


use backend\models\PermissionsModelTrait;
use common\behaviors\ArchiveCascadeBehavior;
use common\validators\SsnValidator;
use DateTime;
use Exception;
use yii\behaviors\BlameableBehavior;
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
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $previous_names
 * @property string $ssn
 *
 * @property integer $birth_date
 * @property integer $created_by
 * @property bool $annual_salary_75k
 *
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $citrix_id
 *
 * @property string $other_type
 *
 * @property-read string $fullName
 *
 *
 * @property array $investigationTypeIds
 *
 * @property Company $company
 * @property File[] $files
 * @property File[] $filesWh
 * @property InvestigationType[] $investigationTypes
 * @property User $createdBy
 * @property History $history
 */
class Investigation extends HistoryActiveRecord
{

    use PermissionsModelTrait;

    const STATUS_DELETED = 0;
    const STATUS_CANCELLED = 100;
    const STATUS_IN_HISTORY = 200;
    const STATUS_PENDING = 250;
    const STATUS_IN_PROGRESS = 300;
    const STATUS_COMPLETED = 400;

    static public $history_type = 'investigation';

    /** @var string */
    public $birthDate;

    public $recoverStatus = self::STATUS_COMPLETED;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%investigation}}';
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
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
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
            [['annual_salary_75k'], 'required', 'message' => 'Please select Yes or No'],
            [['first_name', 'last_name', 'ssn', 'birthDate'], 'required'],
            [['birthDate'], 'validateBirthDate'],

            [['company_id', 'birth_date'], 'integer'],
            ['start_date', 'default', 'value' => new Expression('NOW()')],
            [['other_type'], 'string', 'max' => 60],
            [['name', 'contact_person', 'case_number', 'email', 'previous_names'], 'string', 'max' => 255],
            ['phone', 'string', 'max' => 15],
            ['phone', 'number'],
            ['email', 'email'],

            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 100],
            [['ssn'], SsnValidator::className(), 'length' => 9],

            //client validation input mask widget
            [['ssn'], 'number', 'enableClientValidation' => false],

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

            [['annual_salary_75k'], 'boolean'],

            ['investigationTypeIds', 'safe'],
        ];
    }

    public function validateBirthDate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $dateTime = DateTime::createFromFormat('m/d/Y/H/i/s', $this->birthDate . '/00/00/00');
            if ($dateTime === false) {
                $this->addError($attribute, 'Birth Date is invalid');
                return;
            }

            $this->birth_date = $dateTime->getTimestamp();
        }

    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        //fill birthDate for wizard editing
        if (!empty($this->birth_date)) {
            $date = new DateTime('@' . $this->birth_date);
            $this->birthDate = $date->format('m/d/Y');
        }
        if ($this->other_type) {
            $this->investigationTypeIds = array_merge($this->investigationTypeIds, [-1]);
        }
        parent::afterFind();
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
            'ssn' => 'SSN',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'investigationTypeIds' => 'Investigation Services',
            'other_type' => 'Other Service'
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

    /**
     * @return UndeletableActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['parent' => 'citrix_id'])->inverseOf('investigation');
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getFilesWh()
    {
        return $this->hasMany(File::className(), ['parent' => 'citrix_id'])->andArchived();
    }


    /**
     * @return string
     */
    public function getFullName()
    {
        $midName = '';
        if (!empty($this->middle_name)) {
            $midName = ' ' . $this->middle_name;
        }

        return $this->first_name . $midName . ' ' . $this->last_name;
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getHistory()
    {
        return $this->hasOne(History::className(), ['parent' => 'id'])->andWhere(['type'=>self::$history_type]);
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_company', ['company_id' => 'company_id']);
    }

    /**
     * @return bool
     */
    public function isArchivable()
    {
        $activeStatuses = [
            Investigation::STATUS_COMPLETED,
        ];

        return in_array($this->status, $activeStatuses);
    }

    /**
     * @return bool
     */
    public function isRecoverable()
    {
        $i_statuses = [
            Investigation::STATUS_IN_HISTORY,
        ];
        $c_statuses = [
            Company::STATUS_ACTIVE
        ];

        return (in_array($this->status, $i_statuses) && in_array($this->company->status, $c_statuses));
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
                $errors = ['Investigation: "' . $this->fullName . '" doesn`t archiving!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

    public function recover()
    {
        $this->detachBehavior('citrixFolderBehavior');
        $this->detachBehavior('historyBehavior');
        $res = parent::recover(); // TODO: Change the autogenerated stub

        if (!$res) {
            if ($this->hasErrors()) {
                $m_errors = $this->errors;
                foreach ($m_errors as $field => $f_errors) {
                    $errors[] = $field . ': ' . implode('<br>', $f_errors);
                }
            } else {
                $errors = ['Investigation: "' . $this->fullName . '" doesn`t to recover!'];
            }
            throw new \Exception(implode('<br>', $errors));
        }

        return $res;
    }

    public function isDeleted()
    {
        return !empty($this->history) || parent::isDeleted();
    }


}
