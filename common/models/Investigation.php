<?php

namespace common\models;


use common\models\query\UndeletableActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%investigation}}".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $start_date
 * @property string $end_date
 * @property string $title
 * @property string $description
 * @property string $contact_person
 * @property string $phone
 * @property string $email
 *
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property array $statusLabels
 *
 * @property Company $company
 * @property User[] $users
 */
class Investigation extends AbstractUndeletableActiveRecord
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

    public static function getStatusesList()
    {
        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_HISTORY => 'In history',
            self::STATUS_IN_PROGRESS => 'In progress',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['title', 'contact_person', 'phone', 'email'], 'string'],
            [['description'], 'string', 'max' => 2000],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => [
                self::STATUS_COMPLETED, self::STATUS_IN_PROGRESS, self::STATUS_PENDING,
                self::STATUS_IN_HISTORY, self::STATUS_CANCELLED, self::STATUS_DELETED
            ]],
            [
                ['company_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Company::className(),
                'targetAttribute' => ['company_id' => 'id']
            ],
        ];
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets labels of statuses
     *
     * @return array
     */
    public function getStatusLabels()
    {
        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_IN_HISTORY => 'In history',
            self::STATUS_IN_PROGRESS => 'In progress',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('investigations');
    }
}
