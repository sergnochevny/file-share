<?php

use yii\db\Migration;

/**
 * Class m170831_111325_user_add_created_at
 */
class m170831_111325_user_add_created_at extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'confirmation_token', $this->string(255)->null()->defaultValue(null));
        $this->addColumn('{{%user}}', 'confirmed_at', $this->integer(11)->null()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'confirmation_token');
        $this->dropColumn('{{%user}}', 'confirmed_at');
    }

}
