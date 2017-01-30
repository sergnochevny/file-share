<?php

use yii\db\Migration;

class m170130_172207_user_profile extends Migration
{
    private $tableOptions = null;

    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'user_id'     => $this->integer(11)->unsigned()->notNull(),
            'first_name'  => $this->string(55)->defaultValue(NULL),
            'last_name'   => $this->string(55)->defaultValue(NULL),
            'about_me'    => $this->text(),
            'layout_src'  => $this->string(255)->defaultValue(NULL),
            'avatar_src'  => $this->string(255)->defaultValue(NULL),
        ], $this->tableOptions);

        $this->addPrimaryKey(
            'pk-user_profile-user_id',
            '{{%user_profile}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_profile-user_id-user-id',
            '{{%user_profile}}', 'user_id',
            '{{%user}}', 'id'
        );

        $this->createIndex('idx-first_name', '{{%user_profile}}', 'first_name');
        $this->createIndex('idx-last_name', '{{%user_profile}}', 'last_name');
        $this->createIndex('idx-full_name', '{{%user_profile}}', ['first_name', 'last_name']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }
}
