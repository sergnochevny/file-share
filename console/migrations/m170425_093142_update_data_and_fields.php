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
    }

    public function down()
    {
        echo "m170425_093142_update_data_and_fields cannot be reverted.\n";

        return false;
    }
}
