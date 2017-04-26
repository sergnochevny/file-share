<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "investigation_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CompanyInvestigationType[] $companyInvestigationTypes
 * @property Company[] $companies
 * @property InvestigationInvestigationType[] $investigationInvestigationTypes
 * @property Investigation[] $investigations
 */
class InvestigationType extends UndeletableActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'investigation_type';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name of service',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param int $companyId
     * @return array
     */
    public static function getDefaultIdsForCompanyId($companyId)
    {
        return InvestigationType::find()
            ->joinWith('companies')
            ->andWhere(['company_id' => $companyId])
            ->select(self::tableName() . '.id')
            ->column();
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getCompanyInvestigationTypes()
//    {
//        return $this->hasMany(CompanyInvestigationType::className(), ['investigation_type_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('company_investigation_type', ['investigation_type_id' => 'id']);
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getInvestigationInvestigationTypes()
//    {
//        return $this->hasMany(InvestigationInvestigationType::className(), ['investigation_type_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvestigations()
    {
        return $this->hasMany(Investigation::className(), ['id' => 'investigation_id'])->viaTable('investigation_investigation_type', ['investigation_type_id' => 'id']);
    }
}
