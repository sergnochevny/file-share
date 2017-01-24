<?php


/**
 * Handles the creation of table `user_company`.
 */
class m170103_130522_create_user_company_table extends \console\migrations\AbstractBaseMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user_company}}', [
            'user_id' => $this->integer()->unsigned(),
            'company_id' => $this->integer()->unsigned(),
        ], $this->tblOptions);

        $this->addPrimaryKey('pk-user_company', '{{%user_company}}', ['user_id', 'company_id']);

        //to user
        $this->addForeignKey(
            'fk-user_company-user_id',
            '{{%user_company}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        //to company
        $this->addForeignKey(
            'fk-user_company-company_id',
            '{{%user_company}}',
            'company_id',
            '{{%company}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user_company-user_id',
            '{{%user_company}}');
        $this->dropForeignKey('fk-user_company-company_id',
            '{{%user_company}}');

        $this->dropTable('{{%user_company}}');
    }
}
