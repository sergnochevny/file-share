<?php


use common\models\User;

/**
 * Handles the creation of table `user`.
 */
class m170103_120713_create_user_table extends console\migrations\AbstractBaseMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'phone_number' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $this->tblOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
