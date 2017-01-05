<?php

use yii\db\Migration;

/**
 * Handles the creation of table `logs`.
 */
class m170105_124849_create_logs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('logs', [
            'id' => $this->primaryKey()->unsigned(),
            'action' => $this->string()->notNull(),

            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('logs');
    }
}
