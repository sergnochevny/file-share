<?php

use yii\db\Migration;

class m170419_155218_add_fields_to_investigation extends Migration
{
    public function up()
    {
        $this->addColumn('investigation', 'case_number', $this->string()->after('name'));
        //created_by (user_id)
        $this->addColumn('investigation', 'created_by', $this->integer()->unsigned()->after('email'));

        $this->createIndex('idx-investigation-case_number', 'investigation', 'case_number');
        $this->addForeignKey(
            'fk-investigation-user_id',
            'investigation',
            'created_by',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-investigation-user_id', 'investigation');
        $this->dropColumn('investigation', 'created_by');
        $this->dropColumn('investigation', 'case_number');
    }
}
