<?php

use yii\db\Migration;

class m170726_145901_add_new_fields extends Migration
{
    public function safeUp()
    {
        $this->addColumn('investigation', 'annual_salary_75k', $this->smallInteger()->notNull()->defaultValue(0)->after('created_by'));
    }

    public function safeDown()
    {
        $this->dropColumn('investigation', 'annual_salary_75k');
    }
}