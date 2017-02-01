# noinspection SqlNoDataSourceInspectionForFile

-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.34 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица protus.auth_assignment
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.auth_assignment: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('admin', '2', 1485692238),
	('client', '4', 1485784036);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;

-- Дамп структуры для таблица protus.auth_item
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.auth_item: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('admin', 1, NULL, NULL, NULL, 1485692237, 1485692237),
	('client', 1, NULL, NULL, NULL, 1485692237, 1485692237),
	('employee', 2, 'Employee', 'isEmployee', NULL, 1485692237, 1485692237);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;

-- Дамп структуры для таблица protus.auth_item_child
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.auth_item_child: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('admin', 'client'),
	('client', 'employee');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

-- Дамп структуры для таблица protus.auth_rule
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.auth_rule: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
	('isEmployee', 'O:42:"backend\\components\\rbac\\rules\\EmployeeRule":3:{s:4:"name";s:10:"isEmployee";s:9:"createdAt";i:1485692237;s:9:"updatedAt";i:1485692237;}', 1485692237, 1485692237);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;

-- Дамп структуры для таблица protus.company
DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '100',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `citrix_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.company: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`id`, `name`, `description`, `address`, `city`, `state`, `zip`, `status`, `created_at`, `updated_at`, `citrix_id`) VALUES
	(19, 'Test_Upd', '', '', '', '', '', 100, 1485609638, 1485610710, 'fo2da890-e919-4f98-94dd-b1d2e65defe3');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- Дамп структуры для таблица protus.file
DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `size` int(11) unsigned NOT NULL,
  `parent` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `citrix_id` varchar(50) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.file: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` (`id`, `name`, `description`, `size`, `parent`, `type`, `citrix_id`, `created_at`, `updated_at`, `status`) VALUES
	(7, 'AllFiles', 'Shared files root directory', 0, 'root', 'folder', 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 1485600094, 1485600094, 100),
	(8, 'drag_img1.jpg', '', 7178, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fif44d98-d427-f689-0d3c-2ba2245767a1', 1485609057, 1485613263, 100),
	(9, 'drag_img2.jpg', '', 13681, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fi47e9a7-a84a-a3ed-75d8-200d41353e84', 1485613024, 1485613118, 100),
	(10, '126_1455808234.jpg', '', 16107, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fi99851b-71db-49d6-6922-73e0379bed75', 1485693241, 1485693241, 100),
	(11, 'drag_img1.jpg', '', 7178, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7', 'jpg', 'fid8fe30-1ce7-478f-e058-248802b662ff', 1485800345, 1485800388, 100);
/*!40000 ALTER TABLE `file` ENABLE KEYS */;

-- Дамп структуры для таблица protus.history
DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '0',
  `parent` int(11) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.history: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;

-- Дамп структуры для таблица protus.investigation
DROP TABLE IF EXISTS `investigation`;
CREATE TABLE IF NOT EXISTS `investigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '300',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `citrix_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-investigation-company_id` (`company_id`),
  CONSTRAINT `fk-investigation-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.investigation: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `investigation` DISABLE KEYS */;
INSERT INTO `investigation` (`id`, `company_id`, `start_date`, `end_date`, `name`, `description`, `contact_person`, `phone`, `email`, `status`, `created_at`, `updated_at`, `citrix_id`) VALUES
	(2, 19, '0000-00-00', '0000-00-00', 'Test_App', 'Test Applicant', 'rdskflgh sdl;gfk', '4657687', 'kdsjfh@dfjdhf.hj', 250, 1485796515, 1485796515, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7');
/*!40000 ALTER TABLE `investigation` ENABLE KEYS */;

-- Дамп структуры для таблица protus.key_storage
DROP TABLE IF EXISTS `key_storage`;
CREATE TABLE IF NOT EXISTS `key_storage` (
  `name` varchar(128) NOT NULL,
  `value` text,
  `comment` text,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.key_storage: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `key_storage` DISABLE KEYS */;
INSERT INTO `key_storage` (`name`, `value`, `comment`, `updated_at`, `created_at`) VALUES
	('citrix.id', 'BeSwplmwMiosNPiZP3oEKVN9Eb2chfSk', NULL, NULL, NULL),
	('citrix.pass', '1qWerty@-', NULL, NULL, NULL),
	('citrix.secret', 'S3pKYPoZ6hKS0TkU5h3LBP6wKO9oFxeGqljNIfKyTt7PYxX3', NULL, NULL, NULL),
	('citrix.subdomain', 'aitsergnochevny40', NULL, NULL, NULL),
	('citrix.user', 'sergnochevny@gmail.com', NULL, NULL, NULL);
/*!40000 ALTER TABLE `key_storage` ENABLE KEYS */;

-- Дамп структуры для таблица protus.logs
DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.logs: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Дамп структуры для таблица protus.migration
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.migration: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1485278008),
	('m140506_102106_rbac_init', 1485278057),
	('m140602_111327_create_key_storage_item_table', 1485352796),
	('m140602_111327_create_key_storage_table', 1485357099),
	('m170103_120713_create_user_table', 1485278021),
	('m170103_130222_create_company_table', 1485278021),
	('m170103_130522_create_user_company_table', 1485278023),
	('m170103_134918_create_investigation_table', 1485278024),
	('m170105_124849_create_logs_table', 1485278024),
	('m170125_174712_add_citrix_id_column_to_company_and_investigation_tables', 1485419792),
	('m170130_172207_user_profile', 1485855928);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица protus.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '100',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.user: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`) VALUES
	(2, NULL, NULL, NULL, 'email@email.com', 'admin', 's8fG050TnphotWkYFWB5VA_vr-6DJDEg', '$2y$13$9WhOdxpxqma7h/j1G/ZxJuS4mDe/OiFcokSaK8wx7kRCGDTI61wr.', NULL, 100, 1485692238, 1485692238),
	(4, 'User', 'Test', '34543545', 'user@usr.us', 'user', 'AfUiJsf4AfsUHXMNSYfMpD2ddB-CGlZu', '$2y$13$jg9vW509INme6S60DbuUIOOTcX5weJneEJJbAAbz4DcIbElJrAxAy', NULL, 100, 1485784036, 1485784036);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Дамп структуры для таблица protus.user_company
DROP TABLE IF EXISTS `user_company`;
CREATE TABLE IF NOT EXISTS `user_company` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`company_id`),
  KEY `fk-user_company-company_id` (`company_id`),
  CONSTRAINT `fk-user_company-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `fk-user_company-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы protus.user_company: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `user_company` DISABLE KEYS */;
INSERT INTO `user_company` (`user_id`, `company_id`) VALUES
	(4, 19);
/*!40000 ALTER TABLE `user_company` ENABLE KEYS */;

-- Дамп структуры для таблица protus.user_profile
DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `user_id` int(11) unsigned NOT NULL,
  `first_name` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8_unicode_ci,
  `layout_src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx-first_name` (`first_name`),
  KEY `idx-last_name` (`last_name`),
  KEY `idx-full_name` (`first_name`,`last_name`),
  CONSTRAINT `fk-user_profile-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы protus.user_profile: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
