<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class AbstractBaseMigration
 *
 * For check if db is MySQL for adjust settings
 */
abstract class AbstractBaseMigration extends Migration
{
    /**
     * @var null|string
     */
    protected $tblOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tblOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }
}