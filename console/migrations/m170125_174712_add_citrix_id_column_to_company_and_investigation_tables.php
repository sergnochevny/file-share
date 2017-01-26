<?php


class m170125_174712_add_citrix_id_column_to_company_and_investigation_tables extends \console\migrations\AbstractBaseMigration
{
    public function up()
    {
        $this->addColumn('{{%company}}', 'citrix_id', $this->string());
        $this->addColumn('{{%investigation}}', 'citrix_id', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%investigation}}', 'citrix_id');
        $this->dropColumn('{{%company}}', 'citrix_id');
    }
}
