<?php


/**
 * Handles the creation of table `investigation_user`.
 */
class m170103_142451_create_investigation_user_table extends \console\migrations\AbstractBaseMigration
{
    public $tblName = '{{%investigation_user}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tblName, [
            'investigation_id' => $this->integer()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
        ], $this->tblOptions);

        $this->addPrimaryKey('pk-investigation_user', $this->tblName, ['investigation_id', 'user_id']);

        $this->addForeignKey(
            'fk-investigation_user-investigation_id',
            $this->tblName,
            'investigation_id',
            '{{%investigation}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-investigation_user-user_id',
            $this->tblName,
            'user_id',
            '{{%user}}',
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
        $this->dropForeignKey('fk-investigation_user-user_id', $this->tblName);
        $this->dropForeignKey('fk-investigation_user-investigation_id', $this->tblName);
        $this->dropTable($this->tblName);
    }
}
