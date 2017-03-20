<?php

use yii\db\Migration;

class m170320_182542_base extends Migration
{
    public function safeUp()
    {

        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('auth_assignment', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%auth_assignment}}', [
                    'item_name' => 'VARCHAR(64) NOT NULL',
                    'user_id' => 'VARCHAR(64) NOT NULL',
                    'created_at' => 'INT(11) NULL',
                    3 => 'PRIMARY KEY (`item_name`, `user_id`)',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('auth_item', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%auth_item}}', [
                    'name' => 'VARCHAR(64) NOT NULL',
                    0 => 'PRIMARY KEY (`name`)',
                    'type' => 'INT(11) NOT NULL',
                    'description' => 'TEXT NULL',
                    'rule_name' => 'VARCHAR(64) NULL',
                    'data' => 'TEXT NULL',
                    'created_at' => 'INT(11) NULL',
                    'updated_at' => 'INT(11) NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('auth_item_child', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%auth_item_child}}', [
                    'parent' => 'VARCHAR(64) NOT NULL',
                    'child' => 'VARCHAR(64) NOT NULL',
                    2 => 'PRIMARY KEY (`parent`, `child`)',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('auth_rule', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%auth_rule}}', [
                    'name' => 'VARCHAR(64) NOT NULL',
                    0 => 'PRIMARY KEY (`name`)',
                    'data' => 'TEXT NULL',
                    'created_at' => 'INT(11) NULL',
                    'updated_at' => 'INT(11) NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('company', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%company}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(255) NOT NULL',
                    'description' => 'VARCHAR(255) NOT NULL',
                    'address' => 'VARCHAR(255) NULL',
                    'city' => 'VARCHAR(255) NULL',
                    'state' => 'VARCHAR(255) NULL',
                    'zip' => 'VARCHAR(10) NULL',
                    'status' => 'SMALLINT(6) UNSIGNED NOT NULL DEFAULT \'100\'',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                    'citrix_id' => 'VARCHAR(50) NOT NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('company_investigation_type', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%company_investigation_type}}', [
                    'company_id' => 'INT(11) UNSIGNED NOT NULL',
                    'investigation_type_id' => 'INT(11) UNSIGNED NOT NULL',
                    2 => 'PRIMARY KEY (`company_id`, `investigation_type_id`)',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('file', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%file}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(255) NOT NULL',
                    'description' => 'TEXT NOT NULL',
                    'size' => 'INT(11) UNSIGNED NOT NULL',
                    'parent' => 'VARCHAR(50) NOT NULL',
                    'type' => 'VARCHAR(10) NOT NULL',
                    'citrix_id' => 'VARCHAR(50) NOT NULL',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                    'status' => 'INT(11) UNSIGNED NOT NULL DEFAULT \'100\'',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('history', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%history}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(255) NULL',
                    'parent' => 'INT(11) NULL',
                    'type' => 'VARCHAR(50) NOT NULL',
                    'created_at' => 'INT(11) NOT NULL',
                    'company_id' => 'INT(11) NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('investigation', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%investigation}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'company_id' => 'INT(11) UNSIGNED NOT NULL',
                    'start_date' => 'DATE NULL',
                    'end_date' => 'DATE NULL',
                    'name' => 'VARCHAR(255) NULL',
                    'description' => 'VARCHAR(2000) NULL',
                    'contact_person' => 'VARCHAR(255) NULL',
                    'phone' => 'VARCHAR(255) NULL',
                    'email' => 'VARCHAR(255) NULL',
                    'status' => 'SMALLINT(6) UNSIGNED NOT NULL DEFAULT \'300\'',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                    'citrix_id' => 'VARCHAR(255) NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('investigation_investigation_type', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%investigation_investigation_type}}', [
                    'investigation_id' => 'INT(11) UNSIGNED NOT NULL',
                    'investigation_type_id' => 'INT(11) UNSIGNED NOT NULL',
                    2 => 'PRIMARY KEY (`investigation_id`, `investigation_type_id`)',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('investigation_type', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%investigation_type}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(255) NOT NULL',
                    'status' => 'SMALLINT(6) UNSIGNED NOT NULL',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('key_storage', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%key_storage}}', [
                    'name' => 'VARCHAR(128) NOT NULL',
                    0 => 'PRIMARY KEY (`name`)',
                    'value' => 'TEXT NULL',
                    'comment' => 'TEXT NULL',
                    'updated_at' => 'INT(11) NULL',
                    'created_at' => 'INT(11) NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('logs', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%logs}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'action' => 'VARCHAR(255) NOT NULL',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('user', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%user}}', [
                    'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'first_name' => 'VARCHAR(255) NULL',
                    'last_name' => 'VARCHAR(255) NULL',
                    'phone_number' => 'VARCHAR(255) NULL',
                    'email' => 'VARCHAR(255) NOT NULL',
                    'username' => 'VARCHAR(255) NOT NULL',
                    'auth_key' => 'VARCHAR(32) NOT NULL',
                    'password_hash' => 'VARCHAR(255) NOT NULL',
                    'password_reset_token' => 'VARCHAR(255) NULL',
                    'status' => 'SMALLINT(6) UNSIGNED NOT NULL DEFAULT \'100\'',
                    'created_at' => 'INT(11) UNSIGNED NOT NULL',
                    'updated_at' => 'INT(11) UNSIGNED NOT NULL',
                    'action_at' => 'INT(11) UNSIGNED NOT NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('user_company', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%user_company}}', [
                    'user_id' => 'INT(11) UNSIGNED NOT NULL',
                    'company_id' => 'INT(11) UNSIGNED NOT NULL',
                    2 => 'PRIMARY KEY (`user_id`, `company_id`)',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('user_profile', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%user_profile}}', [
                    'user_id' => 'INT(11) UNSIGNED NOT NULL',
                    0 => 'PRIMARY KEY (`user_id`)',
                    'first_name' => 'VARCHAR(55) NULL',
                    'last_name' => 'VARCHAR(55) NULL',
                    'about_me' => 'TEXT NULL',
                    'layout_src' => 'VARCHAR(255) NULL',
                    'avatar_src' => 'VARCHAR(255) NULL',
                ], $tableOptions_mysql);
            }
        }


        $this->createIndex('idx_rule_name_1604_00','auth_item','rule_name',0);
        $this->createIndex('idx_type_1604_01','auth_item','type',0);
        $this->createIndex('idx_child_1743_02','auth_item_child','child',0);
        $this->createIndex('idx_investigation_type_id_2318_03','company_investigation_type','investigation_type_id',0);
        $this->createIndex('idx_type_2556_04','file','type',0);
        $this->createIndex('idx_parent_2557_05','file','parent',0);
        $this->createIndex('idx_parent_2757_06','history','parent',0);
        $this->createIndex('idx_type_2758_07','history','type',0);
        $this->createIndex('idx_company_id_2759_08','history','company_id',0);
        $this->createIndex('idx_company_id_3024_09','investigation','company_id',0);
        $this->createIndex('idx_investigation_type_id_3169_10','investigation_investigation_type','investigation_type_id',0);
        $this->createIndex('idx_UNIQUE_name_3513_11','key_storage','name',1);
        $this->createIndex('idx_UNIQUE_email_3867_12','user','email',1);
        $this->createIndex('idx_UNIQUE_username_3868_13','user','username',1);
        $this->createIndex('idx_UNIQUE_password_reset_token_3868_14','user','password_reset_token',1);
        $this->createIndex('idx_company_id_4064_15','user_company','company_id',0);
        $this->createIndex('idx_first_name_4492_16','user_profile','first_name',0);
        $this->createIndex('idx_last_name_4492_17','user_profile','last_name',0);
        $this->createIndex('idx_first_name_4492_18','user_profile','first_name',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_auth_item_1386_00','{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_auth_rule_1589_01','{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_auth_item_173_02','{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_auth_item_173_03','{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_company_2298_04','{{%company_investigation_type}}', 'company_id', '{{%company}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_investigation_type_2299_05','{{%company_investigation_type}}', 'investigation_type_id', '{{%investigation_type}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_company_3009_06','{{%investigation}}', 'company_id', '{{%company}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_investigation_3154_07','{{%investigation_investigation_type}}', 'investigation_id', '{{%investigation}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_investigation_type_3154_08','{{%investigation_investigation_type}}', 'investigation_type_id', '{{%investigation_type}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_company_4049_09','{{%user_company}}', 'company_id', '{{%company}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_user_4049_010','{{%user_company}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->addForeignKey('fk_user_4475_011','{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->execute('SET foreign_key_checks = 1;');

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%auth_item}}',['name'=>'admin','type'=>'1','description'=>null,'rule_name'=>null,'data'=>null,'created_at'=>'1489567620','updated_at'=>'1489567620']);
        $this->insert('{{%auth_item}}',['name'=>'client','type'=>'1','description'=>null,'rule_name'=>null,'data'=>null,'created_at'=>'1489567620','updated_at'=>'1489567620']);
        $this->insert('{{%auth_item}}',['name'=>'employee','type'=>'2','description'=>'Employee','rule_name'=>'isEmployee','data'=>null,'created_at'=>'1490015996','updated_at'=>'1490015996']);
        $this->insert('{{%auth_item}}',['name'=>'superAdmin','type'=>'1','description'=>null,'rule_name'=>null,'data'=>null,'created_at'=>'1489567620','updated_at'=>'1489567620']);
        $this->insert('{{%auth_item_child}}',['parent'=>'superAdmin','child'=>'admin']);
        $this->insert('{{%auth_item_child}}',['parent'=>'superAdmin','child'=>'client']);
        $this->insert('{{%auth_item_child}}',['parent'=>'client','child'=>'employee']);
        $this->insert('{{%auth_rule}}',['name'=>'isEmployee','data'=>'O:42:"backend\\components\\rbac\\rules\\EmployeeRule":3:{s:4:"name";s:10:"isEmployee";s:9:"createdAt";i:1490015407;s:9:"updatedAt";i:1490015407;}','created_at'=>'1490015407','updated_at'=>'1490015407']);
        $this->insert('{{%key_storage}}',['name'=>'citrix.id','value'=>'BeSwplmwMiosNPiZP3oEKVN9Eb2chfSk','comment'=>null,'updated_at'=>null,'created_at'=>null]);
        $this->insert('{{%key_storage}}',['name'=>'citrix.pass','value'=>'1qWerty@-','comment'=>null,'updated_at'=>null,'created_at'=>null]);
        $this->insert('{{%key_storage}}',['name'=>'citrix.secret','value'=>'S3pKYPoZ6hKS0TkU5h3LBP6wKO9oFxeGqljNIfKyTt7PYxX3','comment'=>null,'updated_at'=>null,'created_at'=>null]);
        $this->insert('{{%key_storage}}',['name'=>'citrix.subdomain','value'=>'aitsergnochevny40','comment'=>null,'updated_at'=>null,'created_at'=>null]);
        $this->insert('{{%key_storage}}',['name'=>'citrix.user','value'=>'sergnochevny@gmail.com','comment'=>null,'updated_at'=>null,'created_at'=>null]);
        $this->insert('{{%user}}',['id'=>'4','first_name'=>'User','last_name'=>'Test','phone_number'=>'34543545','email'=>'user@usr.us','username'=>'user','auth_key'=>'AfUiJsf4AfsUHXMNSYfMpD2ddB-CGlZu','password_hash'=>'$2y$13$jg9vW509INme6S60DbuUIOOTcX5weJneEJJbAAbz4DcIbElJrAxAy','password_reset_token'=>null,'status'=>'100','created_at'=>'1485784036','updated_at'=>'1485973113','action_at'=>'1490032399']);
        $this->insert('{{%user}}',['id'=>'6','first_name'=>null,'last_name'=>null,'phone_number'=>null,'email'=>'sadmin@example.net','username'=>'sadmin','auth_key'=>'tN6pNw1XFL5BYDAEHu3kyCcYlgauZvqB','password_hash'=>'$2y$13$B4LxSAsSpoA49m/DSDA4e.8dZb148i5XVx/l37C0HNYXBLNd7b/eK','password_reset_token'=>null,'status'=>'100','created_at'=>'1489567621','updated_at'=>'1489567621','action_at'=>'1490002726']);
        $this->insert('{{%user}}',['id'=>'7','first_name'=>null,'last_name'=>null,'phone_number'=>null,'email'=>'admin@example.com','username'=>'admin','auth_key'=>'T-466Rg4ILo72NbgDcvm6n86BsaORZh2','password_hash'=>'$2y$13$Y/ZNL5LrD4cLrga4uyUYQexkXTFyAL0jIoXCo17ElXQeo0PF1dZQK','password_reset_token'=>null,'status'=>'100','created_at'=>'1489567674','updated_at'=>'1489567674','action_at'=>'1490035586']);
        $this->insert('{{%auth_assignment}}',['item_name'=>'admin','user_id'=>'7','created_at'=>'1489567674']);
        $this->insert('{{%auth_assignment}}',['item_name'=>'client','user_id'=>'4','created_at'=>'1489567621']);
        $this->insert('{{%auth_assignment}}',['item_name'=>'superAdmin','user_id'=>'6','created_at'=>'1489567621']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `auth_assignment`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `auth_item`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `auth_item_child`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `auth_rule`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `company`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `company_investigation_type`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `file`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `history`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `investigation`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `investigation_investigation_type`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `investigation_type`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `key_storage`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `logs`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `user`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `user_company`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `user_profile`');
        $this->execute('SET foreign_key_checks = 1;');
    }

}
