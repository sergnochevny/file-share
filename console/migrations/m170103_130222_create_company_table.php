<?php


use common\models\Company;
/**
 * Handles the creation of table `company`.
 */
class m170103_130222_create_company_table extends \console\migrations\AbstractBaseMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'city' => $this->string(),
            'state' => $this->string(),
            'zip' => $this->string(10),

            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(Company::STATUS_ACTIVE),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $this->tblOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%company}}');
    }
}
