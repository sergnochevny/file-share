<?php

use yii\db\Migration;

/**
 * Class m170817_082951_add_column_to_rbac
 */
class m170817_082951_add_column_to_rbac extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%auth_item_child}}', 'allow', $this->boolean()->notNull()->defaultValue(true)->after('child'));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%auth_item_child}}', 'allow');
    }
}
