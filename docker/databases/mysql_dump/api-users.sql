-- Adminer 5.3.0 MySQL 8.1.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250727130630',	'2025-07-27 13:08:59',	36),
('DoctrineMigrations\\Version20250727131846',	'2025-07-27 13:19:12',	39),
('DoctrineMigrations\\Version20250727142922',	'2025-07-27 14:30:28',	57),
('DoctrineMigrations\\Version20250727152028',	'2025-07-27 15:20:34',	59),
('DoctrineMigrations\\Version20250727173739',	'2025-07-27 17:37:46',	65);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_id` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9B5B48B91` (`public_id`),
  UNIQUE KEY `unique_login_pass` (`login`,`pass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `login`, `phone`, `pass`, `public_id`) VALUES
(1,	'user1',	'00001',	'pass1',	'1'),
(2,	'user2',	'00002',	'pass2',	'2'),
(3,	'user3',	'00003',	'pass3',	'3'),
(4,	'user4',	'00004',	'pass4',	'4'),
(5,	'user5',	'00005',	'pass5',	'5'),
(6,	'user6',	'00006',	'pass6',	'6'),
(7,	'user7',	'00007',	'pass7',	'7'),
(8,	'user8',	'00008',	'pass8',	'8'),
(9,	'user9',	'00009',	'pass9',	'9'),
(10,	'user10',	'000010',	'pass10',	'10');

-- 2025-07-27 19:10:52 UTC
