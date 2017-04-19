<?php

use yii\db\Migration;

class m170419_143759_add_applicants_types extends Migration
{
    public function up()
    {
        $this->execute('DELETE FROM `company`');
        $this->execute("ALTER TABLE `company` AUTO_INCREMENT = 1");

        $this->execute('DELETE FROM `file`');
        $this->execute("ALTER TABLE `file` AUTO_INCREMENT = 1");

        $types = [
            'SSN verification and address history',
            'Limited address history',
            'Criminal records search* Indicates additional information or form may be required',
            'Federal records search',
            'National sex offender search',
            'Education verification - include a copy of the applicant’s application * Indicates additional information or form may be required',
            'Employment verification - include a copy of the applicant’s application * Indicates additional information or form may be required',
            'Reference interviews - include a copy of the applicant’s reference list * Indicates additional information or form may be required',
            'Driving records* Indicates additional information or form may be required',
            'Credit report',
            'Civil records check* Indicates additional information or form may be required',
            'Internet / social media search - include a copy of the applicant’s resume * Indicates additional information or form may be required',
            'Applicant interview* Indicates additional information or form may be required'
        ];

        foreach ($types as $type) {
            $ar = new \common\models\InvestigationType();
            $ar->name = $type;
            $ar->save();
        }
    }

    public function down()
    {
        echo "m170419_143759_add_applicants_types cannot be reverted.\n";

        return false;
    }
}
