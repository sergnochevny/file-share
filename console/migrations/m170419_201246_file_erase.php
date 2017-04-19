<?php

use yii\db\Migration;

class m170419_201246_file_erase extends Migration
{
    public function up()
    {
        $this->execute('DELETE FROM `file`');
        $this->execute("ALTER TABLE `file` AUTO_INCREMENT = 1");
    }

    public function down()
    {
        echo "m170419_201246_file_erase cannot be reverted.\n";

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
