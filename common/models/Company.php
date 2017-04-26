<?php

namespace common\models;

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
class Company extends UndeletableActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
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
            [['name'], 'required'],
            [['name', 'address', 'city', 'state'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
            [['case_number'] , 'string', 'max' => 7],
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

    final public static function getStatusesList(){
        return [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_ACTIVE => 'Active'
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
}
