-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               5.5.50-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица fiantaco_ts.ts_looks_categories
CREATE TABLE IF NOT EXISTS `ts_looks_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `updated` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы fiantaco_ts.ts_looks_categories: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `ts_looks_categories` DISABLE KEYS */;
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(1, 'Категория 1', 0, 1, 1468409550, 1);
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(2, 'Категория 2', 0, 1, 1468409623, 1);
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(3, 'Категория 3', 0, 1, 1468409667, 1);
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(4, 'Подкатегория 1', 1, 1, 1468409681, 1);
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(5, 'Подкатегория 2', 1, 1, 1468409696, 1);
INSERT INTO `ts_looks_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(6, 'Подкатегория 3', 3, 1, 1468409733, 1);
/*!40000 ALTER TABLE `ts_looks_categories` ENABLE KEYS */;


-- Дамп структуры для таблица fiantaco_ts.ts_products_categories
CREATE TABLE IF NOT EXISTS `ts_products_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `updated` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Дамп данных таблицы fiantaco_ts.ts_products_categories: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `ts_products_categories` DISABLE KEYS */;
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(1, 'Категория товаров 1', 0, 1, 1468409550, 1);
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(2, 'Категория товаров 2', 0, 1, 1468409623, 1);
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(3, 'Категория товаров 3', 0, 1, 1468409667, 1);
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(4, 'Подкатегория товаров 1', 1, 1, 1468425516, 1);
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(5, 'Подкатегория товаров 2', 2, 1, 1468425534, 1);
INSERT INTO `ts_products_categories` (`id`, `name`, `parent_id`, `enabled`, `updated`, `user_id`) VALUES
	(6, 'Подкатегория товаров 3', 3, 1, 1468409733, 1);
/*!40000 ALTER TABLE `ts_products_categories` ENABLE KEYS */;


-- Дамп структуры для таблица fiantaco_ts.ts_users
CREATE TABLE IF NOT EXISTS `ts_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `photo` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `about` varchar(500) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `birthdate` int(10) unsigned NOT NULL,
  `regdate` int(10) unsigned NOT NULL,
  `logindate` int(10) unsigned NOT NULL,
  `confirmed` varchar(100) NOT NULL,
  `role_id` tinyint(10) unsigned NOT NULL,
  `fb_id` tinyint(10) unsigned NOT NULL,
  `vk_id` tinyint(10) unsigned NOT NULL,
  `blocked` tinyint(10) unsigned NOT NULL DEFAULT '0',
  `salt` varchar(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `updated` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Дамп данных таблицы fiantaco_ts.ts_users: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `ts_users` DISABLE KEYS */;
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(1, 'adm@fianta.com', '1baebc12194e5096d4ee39455075ad93ee47c1f21343060085623e991332c6e8', 'Федор!!', 'Ястребов', '', '', 0, '', 'Киев', '', 'rtrt11', 0, 1392172072, 1468851562, '1', 1, 0, 0, 0, '875118', '127.0.0.1', 'a91eb8f809c4156e71738cf9b93a8ab6ed33890eca05788514baa14349a98d5e', 1468491260, 1);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(2, 's@fianta.com', '6d23baf2d101985643408be64dc3d64b3735e09eade672096d367825e0419341', 'Стилист', 'Стильный', '', '', 0, '', 'Киев', '', '', 0, 1392172072, 0, '1', 4, 0, 0, 0, '194429', '', '', 0, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(3, 'u@fianta.com', '6d23baf2d101985643408be64dc3d64b3735e09eade672096d367825e0419341', 'Юзер', 'Обыкновенный', '', '', 0, '', 'Киев', '', '', 0, 1392172072, 0, '1', 3, 0, 0, 0, '194429', '', '', 0, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(4, 'u2@fianta.com', '6d23baf2d101985643408be64dc3d64b3735e09eade672096d367825e0419341', 'Юзер 21', 'Обыкновенный 2', '', '', 0, '', 'Черновцы', '', 'фывфв', 0, 1392172072, 0, '1', 3, 0, 0, 0, '194429', '', '', 1467978649, 5);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(5, 'a@fianta.com', '6d23baf2d101985643408be64dc3d64b3735e09eade672096d367825e0419341', 'Админ', 'Админский', '', '', 0, '', 'Чернигов', '', '', 0, 1392172072, 1468529984, '1', 1, 0, 0, 0, '194429', '127.0.0.1', 'dcb21d3881741d973c11a60839bc18684b3f8f6962dd7ab71c5d380dbbd3b6d5', 0, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(7, 'zas987@mailinator.com', 'cc08f5240cc821b708e138ed38ff4bda74fb437b31e707db59e1e0f7b46968e7', 'Test', 'Test', '', '', 0, '', '', '', '', 0, 1468502190, 0, '1', 0, 0, 0, 0, '906634', '127.0.0.1', '', 1468502190, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(8, 'xv923@mailinator.com', '8819746e17e2915465eda8cfa48890cc4e84f07c19da2caacb412519e56f6763', 'Петр', 'Иванов Иванович', '', '', 0, '', '', '', '', 0, 1468510630, 0, '1', 0, 0, 0, 0, '882096', '127.0.0.1', '', 1468510630, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(9, 'xs723@mailinator.com', '53ce855cb4157a0d632b06a8f7f3838424e436fb4e28316c0b21fb5171f89ca4', 'Петров', 'Иван Иванович', '', '', 0, '', '', '', '', 0, 1468510911, 0, '1', 3, 0, 0, 0, '322608', '127.0.0.1', '', 1468510911, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(10, 'vr4560@mailinator.com', '1e1c2355ff773f054649138eb4b80baaf359ce9780a4721cbc28861a2bf46f1a', 'Притула', 'Сергей Бендонович', '', '', 0, '', '', '', '', 0, 1468524272, 0, '0', 3, 0, 0, 0, '290360', '127.0.0.1', '', 1468524272, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(11, 'vr4561@mailinator.com', '6d121cbe644d1f5f544d3ad884f5c8bac583d6fd6b063c928564af627fda3717', '', 'ndrey', '', '', 0, '', '', '', '', 0, 1468524733, 1468529794, '1', 3, 0, 0, 0, '598724', '', '', 1468524733, 0);
INSERT INTO `ts_users` (`id`, `login`, `pass`, `name`, `sname`, `mname`, `phone`, `gender`, `photo`, `city`, `about`, `comment`, `birthdate`, `regdate`, `logindate`, `confirmed`, `role_id`, `fb_id`, `vk_id`, `blocked`, `salt`, `ip`, `uid`, `updated`, `user_id`) VALUES
	(12, 'zase214@mailinator.com', '4957980ce988c5c91ee68a50956b5eec6773e8aaeecf0a3fe9b2c9ac2ff90523', 'Алексей', 'Сорокин', '', '', 0, '', '', '', '', 0, 1468841524, 0, '1', 3, 0, 0, 0, '762975', '127.0.0.1', '', 1468841524, 0);
/*!40000 ALTER TABLE `ts_users` ENABLE KEYS */;


-- Дамп структуры для таблица fiantaco_ts.ts_users_acl
CREATE TABLE IF NOT EXISTS `ts_users_acl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `mod_alias` varchar(255) NOT NULL,
  `access` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id_mod_alias` (`role_id`,`mod_alias`),
  CONSTRAINT `ts_users_acl_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ts_users_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Дамп данных таблицы fiantaco_ts.ts_users_acl: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ts_users_acl` DISABLE KEYS */;
/*!40000 ALTER TABLE `ts_users_acl` ENABLE KEYS */;


-- Дамп структуры для таблица fiantaco_ts.ts_users_roles
CREATE TABLE IF NOT EXISTS `ts_users_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `updated` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Дамп данных таблицы fiantaco_ts.ts_users_roles: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `ts_users_roles` DISABLE KEYS */;
INSERT INTO `ts_users_roles` (`id`, `name`, `updated`, `user_id`) VALUES
	(1, 'Администратор', 1420924286, 1);
INSERT INTO `ts_users_roles` (`id`, `name`, `updated`, `user_id`) VALUES
	(2, 'Менеджер', 1466699251, 1);
INSERT INTO `ts_users_roles` (`id`, `name`, `updated`, `user_id`) VALUES
	(3, 'Пользователь', 1435821825, 1);
INSERT INTO `ts_users_roles` (`id`, `name`, `updated`, `user_id`) VALUES
	(4, 'Стилист', 1435821825, 1);
/*!40000 ALTER TABLE `ts_users_roles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
