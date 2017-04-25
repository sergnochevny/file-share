<?php

use common\models\InvestigationType;
use yii\db\Migration;

class m170425_093142_update_data_and_fields extends Migration
{
    public function up()
    {
        //updating investigative services (remove all after asterisk)
        /** @var InvestigationType[] $services */
        $services = InvestigationType::find()->all();
        foreach ($services as $service) {
            $parts = explode('*', $service->name);
            if (count($parts) > 1) {
                $service->name = trim($parts[0]) . '*';
                $service->save(true, ['name']);
            }
        }

        //file description not required
        $this->alterColumn('file', 'description', $this->text());
        $this->alterColumn('company', 'description', $this->string());

        //new fields to company
        $this->addColumn('company', 'case_number', $this->string(20)->after('name'));
        $this->createIndex('idx-company-case_number', 'company', 'case_number');
    }

    public function down()
    {
        echo "m170425_093142_update_data_and_fields cannot be reverted.\n";

        return false;
    }
}
