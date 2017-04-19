<?php

use yii\db\Migration;

class m170419_172742_file_fix extends Migration
{
    public function up()
    {

        $this->alterColumn('{{%file}}', 'size', $this->integer()->unsigned()->defaultValue(null));

    }

    public function down()
    {
        $this->alterColumn('{{%file}}', 'size', $this->integer()->unsigned()->notNull());

        return false;
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
