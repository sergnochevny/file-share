<?php

namespace common\models;

use common\models\query\UndeletableActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 *
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Investigation[] $investigations
 * @property User[] $users
 */
class Company extends AbstractUndeletableActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 100;

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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
}
