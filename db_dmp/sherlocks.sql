-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 20 2017 г., 12:12
-- Версия сервера: 5.5.54-0ubuntu0.14.04.1
-- Версия PHP: 5.6.30-7+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sherlocks`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '7', 1489567674),
('client', '4', 1489567621),
('superAdmin', '6', 1489567621);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

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
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1489567620, 1489567620),
('client', 1, NULL, NULL, NULL, 1489567620, 1489567620),
('superAdmin', 1, NULL, NULL, NULL, 1489567620, 1489567620);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superAdmin', 'admin'),
('superAdmin', 'client');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `description`, `address`, `city`, `state`, `zip`, `status`, `created_at`, `updated_at`, `citrix_id`) VALUES
(19, 'Test_Upd', '', '', '', '', '', 100, 1485609638, 1486054598, 'fo2da890-e919-4f98-94dd-b1d2e65defe3'),
(20, 'asdfsakj', '', 'sadfggasdf', 'dsafkjh', 'asdfads', '656454615', 100, 1486059372, 1486059372, 'foc136db-1bcd-4a62-8cd4-86dcf58d2dd1'),
(21, 'jhgfyhf', '', '', 'gyfytf', '', '', 100, 1486060327, 1486060327, 'fo53f8ed-ba4e-4ad0-9e2d-3cb09575aa3c');

-- --------------------------------------------------------

--
-- Структура таблицы `company_investigation_type`
--

CREATE TABLE IF NOT EXISTS `company_investigation_type` (
  `company_id` int(11) unsigned NOT NULL,
  `investigation_type_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`company_id`,`investigation_type_id`),
  KEY `fk-company_investigation_type-investigation_type_id` (`investigation_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company_investigation_type`
--

INSERT INTO `company_investigation_type` (`company_id`, `investigation_type_id`) VALUES
(19, 3),
(19, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `name`, `description`, `size`, `parent`, `type`, `citrix_id`, `created_at`, `updated_at`, `status`) VALUES
(7, 'AllFiles', 'Shared files root directory', 0, 'root', 'folder', 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 1485600094, 1485600094, 100),
(8, 'drag_img1.jpg', '', 7178, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fif44d98-d427-f689-0d3c-2ba2245767a1', 1485609057, 1486054648, 200),
(9, 'drag_img2.jpg', '', 13681, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fi47e9a7-a84a-a3ed-75d8-200d41353e84', 1485613024, 1485613118, 100),
(10, '126_1455808234.jpg', '', 16107, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fi99851b-71db-49d6-6922-73e0379bed75', 1485693241, 1485693241, 100),
(11, 'drag_img1.jpg', '', 7178, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7', 'jpg', 'fi99851b-71db-49d6-6922-73e0379bed75', 1485800345, 1486051980, 100),
(12, 'drag_img4.jpg', '', 12488, 'fob4f466-3fd1-4d95-b567-8ac02bdd1eef', 'jpg', 'fi054e77-180b-3734-560f-813097f3d51e', 1485950740, 1485950740, 100),
(13, 'drag_img7.jpg', '', 13791, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7', 'jpg', 'fi8269b1-a8ff-328e-ade9-dc8abfb24bc2', 1485965309, 1486052099, 100),
(14, 'drag_img3.jpg', '', 10906, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7', 'jpg', 'fi2fa773-d695-2970-df69-da0db6a742d1', 1485965364, 1486048972, 100),
(15, '126_1455808234.jpg', '', 16107, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7', 'jpg', 'fi68ffeb-c9e5-fd74-dd1e-e5e25b6e4ced', 1485965377, 1486048029, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `created_at` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `type` (`type`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Дамп данных таблицы `history`
--

INSERT INTO `history` (`id`, `name`, `parent`, `type`, `created_at`, `company_id`) VALUES
(27, 'drag_img1.jpg', 11, 'file', 1486047633, 1),
(28, 'drag_img13.jpg', 13, 'file', 1486047753, NULL),
(29, 'Test_App', 2, 'investigation', 1486047789, 1),
(30, 'Test_Upd', 19, 'company', 1486047805, 1),
(31, '126_1455808234.jpg', 15, 'file', 1486048029, 1),
(32, 'drag_img1.jpg', 11, 'file', 1486048102, 1),
(33, 'drag_img7.jpg', 13, 'file', 1486048319, 1),
(34, 'drag_img3.jpg', 14, 'file', 1486048364, 1),
(35, 'drag_img1.jpg', 11, 'file', 1486048422, 1),
(36, 'drag_img7.jpg', 13, 'file', 1486048843, 1),
(37, 'drag_img3.jpg', 14, 'file', 1486048972, 1),
(38, 'drag_img1.jpg', 11, 'file', 1486051980, 1),
(39, 'drag_img7.jpg', 13, 'file', 1486052099, 19),
(40, 'Test_App', 2, 'investigation', 1486054588, 19),
(41, 'Test_Upd', 19, 'company', 1486054598, 19),
(42, 'drag_img1.jpg', 8, 'file', 1486054648, NULL),
(43, 'sdrtgsdfg', 3, 'investigation', 1489513019, 19),
(44, 'sdrtgsdfg', 3, 'investigation', 1489513202, 19),
(45, 'sdrtgsdfg', 3, 'investigation', 1489514163, 19);

-- --------------------------------------------------------

--
-- Структура таблицы `investigation`
--

CREATE TABLE IF NOT EXISTS `investigation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  KEY `idx-investigation-company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `investigation`
--

INSERT INTO `investigation` (`id`, `company_id`, `start_date`, `end_date`, `name`, `description`, `contact_person`, `phone`, `email`, `status`, `created_at`, `updated_at`, `citrix_id`) VALUES
(2, 19, '0000-00-00', '0000-00-00', 'Test_App', 'Test Applicant', 'rdskflgh sdl;gfk', '4657687', 'kdsjfh@dfjdhf.hj', 200, 1485796515, 1486054590, 'fo1ec085-e06f-4680-90ed-ca4da2f41fa7'),
(3, 19, '2017-02-01', '2017-02-21', 'sdrtgsdfg', 'cxfgdcgydxfg', '', '', '', 300, 1486111821, 1489514163, 'fof47f51-4c38-4ef2-aae4-22dab4cd1372');

-- --------------------------------------------------------

--
-- Структура таблицы `investigation_investigation_type`
--

CREATE TABLE IF NOT EXISTS `investigation_investigation_type` (
  `investigation_id` int(11) unsigned NOT NULL,
  `investigation_type_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`investigation_id`,`investigation_type_id`),
  KEY `fk-investigation_investigation_type-investigation_type_id` (`investigation_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `investigation_investigation_type`
--

INSERT INTO `investigation_investigation_type` (`investigation_id`, `investigation_type_id`) VALUES
(3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `investigation_type`
--

CREATE TABLE IF NOT EXISTS `investigation_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` smallint(6) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `investigation_type`
--

INSERT INTO `investigation_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'One', 0, 1489423298, 1489423302),
(2, 'Two', 0, 1489423455, 1489423493),
(3, 'sdtfuyii', 100, 1489487192, 1489487192),
(4, 'fdghj', 100, 1489487218, 1489487218);

-- --------------------------------------------------------

--
-- Структура таблицы `key_storage`
--

CREATE TABLE IF NOT EXISTS `key_storage` (
  `name` varchar(128) NOT NULL,
  `value` text,
  `comment` text,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `key_storage`
--

INSERT INTO `key_storage` (`name`, `value`, `comment`, `updated_at`, `created_at`) VALUES
('citrix.id', 'BeSwplmwMiosNPiZP3oEKVN9Eb2chfSk', NULL, NULL, NULL),
('citrix.pass', '1qWerty@-', NULL, NULL, NULL),
('citrix.secret', 'S3pKYPoZ6hKS0TkU5h3LBP6wKO9oFxeGqljNIfKyTt7PYxX3', NULL, NULL, NULL),
('citrix.subdomain', 'aitsergnochevny40', NULL, NULL, NULL),
('citrix.user', 'sergnochevny@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

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

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `action_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `action_at`) VALUES
(4, 'User', 'Test', '34543545', 'user@usr.us', 'user', 'AfUiJsf4AfsUHXMNSYfMpD2ddB-CGlZu', '$2y$13$jg9vW509INme6S60DbuUIOOTcX5weJneEJJbAAbz4DcIbElJrAxAy', NULL, 100, 1485784036, 1485973113, 1490002758),
(6, NULL, NULL, NULL, 'sadmin@example.net', 'sadmin', 'tN6pNw1XFL5BYDAEHu3kyCcYlgauZvqB', '$2y$13$B4LxSAsSpoA49m/DSDA4e.8dZb148i5XVx/l37C0HNYXBLNd7b/eK', NULL, 100, 1489567621, 1489567621, 1490002726),
(7, NULL, NULL, NULL, 'admin@example.com', 'admin', 'T-466Rg4ILo72NbgDcvm6n86BsaORZh2', '$2y$13$Y/ZNL5LrD4cLrga4uyUYQexkXTFyAL0jIoXCo17ElXQeo0PF1dZQK', NULL, 100, 1489567674, 1489567674, 1489998876);

-- --------------------------------------------------------

--
-- Структура таблицы `user_company`
--

CREATE TABLE IF NOT EXISTS `user_company` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`company_id`),
  KEY `fk-user_company-company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_company`
--

INSERT INTO `user_company` (`user_id`, `company_id`) VALUES
(4, 19);

-- --------------------------------------------------------

--
-- Структура таблицы `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `user_id` int(11) unsigned NOT NULL,
  `first_name` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `about_me` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `layout_src` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_src` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx-first_name` (`first_name`),
  KEY `idx-last_name` (`last_name`),
  KEY `idx-full_name` (`first_name`,`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `company_investigation_type`
--
ALTER TABLE `company_investigation_type`
  ADD CONSTRAINT `fk-company_investigation_type-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-company_investigation_type-investigation_type_id` FOREIGN KEY (`investigation_type_id`) REFERENCES `investigation_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `investigation`
--
ALTER TABLE `investigation`
  ADD CONSTRAINT `fk-investigation-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `investigation_investigation_type`
--
ALTER TABLE `investigation_investigation_type`
  ADD CONSTRAINT `fk-investigation_investigation_type-investigation_id` FOREIGN KEY (`investigation_id`) REFERENCES `investigation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-investigation_investigation_type-investigation_type_id` FOREIGN KEY (`investigation_type_id`) REFERENCES `investigation_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `fk-user_company-company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `fk-user_company-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `fk-user_profile-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
