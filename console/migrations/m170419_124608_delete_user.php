<?php

use yii\db\Migration;

class m170419_124608_delete_user extends Migration
{
    public function up()
    {
        $this->delete('{{%user}}', ['id' => 4]);

    }

    public function down()
    {
        $this->insert('{{%user}}', ['id' => '4', 'first_name' => 'User', 'last_name' => 'Test', 'phone_number' => '34543545', 'email' => 'user@usr.us', 'username' => 'user', 'auth_key' => 'AfUiJsf4AfsUHXMNSYfMpD2ddB-CGlZu', 'password_hash' => '$2y$13$jg9vW509INme6S60DbuUIOOTcX5weJneEJJbAAbz4DcIbElJrAxAy', 'password_reset_token' => null, 'status' => '100', 'created_at' => '1485784036', 'updated_at' => '1485973113', 'action_at' => '1490032399']);
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
