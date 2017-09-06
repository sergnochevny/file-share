<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace backend\models;

use backend\behaviors\VerifyPermissionBehavior;
use backend\models\traits\ExtendHistoryFindConditionTrait;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property integer $company_id
 * @property string $type
 * @property integer $created_at
 * @property integer $created_by
 */
class History extends \common\models\History
{
    use ExtendHistoryFindConditionTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['VerifyPermissionBehavior'] = [
            'class' => VerifyPermissionBehavior::className()
        ];

        return $behaviors;
    }

}
