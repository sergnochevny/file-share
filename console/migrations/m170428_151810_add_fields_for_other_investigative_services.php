<?php

use yii\db\Migration;

class m170428_151810_add_fields_for_other_investigative_services extends Migration
{
    public function up()
    {
        $this->addColumn('investigation', 'other_type', $this->string());
        $this->addColumn('company', 'other_type', $this->string());
    }

    public function down()
    {
        $this->dropColumn('investigation', 'other_type');
        $this->dropColumn('company', 'other_type');
    }
}
