<?php

use yii\db\Migration;

class m170808_113838_add_created_by_column extends Migration
{
    private $tables;

    public function init()
    {
        parent::init();
        $this->tables = [
            'company',
            'file',
            'user',
            'history'
        ];

    }

    public function safeUp()
    {
        foreach ($this->tables as $table) {
            $this->addColumn($table, 'created_by', $this->integer()->unsigned()->notNull()->defaultValue(0)->after('created_at'));
        }
    }

    public function safeDown()
    {

        foreach ($this->tables as $table) {
            $this->dropColumn($table, 'created_by');
        }
    }
}
