<?php

use yii\db\Migration;

class m170427_075850_add_new_fields_to_investigation extends Migration
{
    public function up()
    {
        $this->addColumn('investigation', 'first_name', $this->string(100)->after('email'));
        $this->addColumn('investigation', 'middle_name', $this->string(100)->after('first_name'));
        $this->addColumn('investigation', 'last_name', $this->string(100)->after('middle_name'));
        $this->addColumn('investigation', 'previous_names', $this->string()->after('last_name'));
        $this->addColumn('investigation', 'ssn', $this->string(20)->after('previous_names'));
        $this->addColumn('investigation', 'birth_date', $this->integer(11)->unsigned()->after('ssn'));
    }

    public function down()
    {
        $columns = [
            'first_name', 'middle_name', 'last_name',
            'previous_names', 'ssn', 'birth_date'
        ];

        foreach ($columns as $column) {
            $this->dropColumn('investigation', $column);
        }
    }
}
