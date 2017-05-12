<?php

use yii\db\Migration;

class m170512_081441_birthday_signed extends Migration
{
    public function up()
    {
        $this->db->createCommand('update investigation set birth_date = birth_date - 2000000000 where birth_date > 2000000000')->execute();
        $this->alterColumn('{{%investigation}}', 'birth_date', $this->integer()->defaultValue(null));
    }

    public function down()
    {
        $this->alterColumn('{{%investigation}}', 'birth_date', $this->integer()->unsigned()->defaultValue(null));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
