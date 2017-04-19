<?php

use yii\db\Migration;

class m170419_155218_add_fields_to_investigation extends Migration
{
    public function up()
    {
        $this->addColumn('investigation', 'case_number', $this->string()->after('name'));
        $this->addColumn('investigation', 'user_id', $this->integer()->unsigned()->after('email'));

        $this->createIndex('idx-investigation-case_number', 'investigation', 'case_number');
        $this->addForeignKey(
            'fk-investigation-user_id',
            'investigation',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-investigation-user_id', 'investigation');
        $this->dropColumn('investigation', 'user_id');
        $this->dropColumn('investigation', 'case_number');
    }
}
