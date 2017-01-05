<?php


use \common\models\Investigation;
/**
 * Handles the creation of table `investigation`.
 */
class m170103_134918_create_investigation_table extends \console\migrations\AbstractBaseMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%investigation}}', [
            'id' => $this->primaryKey()->unsigned(),
            'company_id' => $this->integer()->unsigned()->notNull(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'description' => $this->string(2000),

            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(Investigation::STATUS_IN_PROGRESS),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $this->tblOptions);

        $this->addForeignKey(
            'fk-investigation-company_id',
            '{{%investigation}}',
            'company_id',
            '{{%company}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx-investigation-company_id', '{{%investigation}}', 'company_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-investigation-company_id', '{{%investigation}}');
        $this->dropIndex('idx-investigation-company_id', '{{%investigation}}');
        $this->dropTable('{{%investigation}}');
    }
}
