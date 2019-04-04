-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.12 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица yii.sd_shedule_assign
CREATE TABLE IF NOT EXISTS `sd_shedule_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `shedule_hash` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii.sd_shedule_assign: ~21 rows (приблизительно)
/*!40000 ALTER TABLE `sd_shedule_assign` DISABLE KEYS */;
INSERT IGNORE INTO `sd_shedule_assign` (`id`, `personId`, `shedule_hash`) VALUES
	(1, 5, '8304747f13a24e988c4def60a882d828'),
	(2, 7, '600b7de898b44baa9da75f3f3571a95c'),
	(3, 9, '2eed78695e0b456b8526af478d4c6277'),
	(4, 10, '88fa0c3258ce44839ac2966cc48a0451'),
	(5, 10, '6e47b1734f7b4e63a8252ec539b4342d'),
	(6, 11, '737a56f99c304e4b9ea739ceaf2d13b6'),
	(7, 12, '6aba8354e556483e975e14b2adcbdaf3'),
	(8, 13, '7271d473d48f489dbce13952d9c07b5a'),
	(9, 14, '9ffc57b83be94e01995e624ab39796cf'),
	(10, 15, '8c3e894edab749889ddd3ff3fa8a4940'),
	(11, 15, 'f2d14cd891d9499c96849ebfaf53af00'),
	(12, 16, 'fe789aeccc7e46e4ad4048d5ebcb4e16'),
	(13, 17, '8d7e73613fe043deaf995ee5037aed0d'),
	(14, 25, '8ff62746dcf94cf2b986c650dab12684'),
	(15, 22, '2d9b9478bf9244bfb3bb1e2dec720bec'),
	(16, 18, '9024a5a884ef4876a975f198cfb5677b'),
	(17, 19, '5cd5f1645f3d489984434b6215e07d47'),
	(18, 24, 'd8689b5d582549f884dadfc0a00d0564'),
	(19, 26, 'be8324561bb64da1a0d29b2ef1baaf0e'),
	(20, 23, '2646d1c2d8c6418fb413f12aee9ef79a'),
	(21, 25, 'e3d56b1abf05410c82e9c0c359320287'),
	(22, 23, 'b7c9393a70024b088e6972bb2ccc8b25'),
	(23, 9, 'a42fe2f000a145e9ad728f49f5e65b00'),
	(24, 19, 'cb7a62ac613b4616acc45a0663c92f5e'),
	(25, 24, '242b0e47a89e400ca63aa3b403f74b55'),
	(26, 25, '949ec9dcaff947d2b746aa39263bc88c'),
	(27, 22, '02320fa89bc14402a5a89b895d613a2d'),
	(28, 15, '1ba2361a3152493d93419bb775fc4170'),
	(29, 17, '479000a2154542649cd861ceb57ae745');
/*!40000 ALTER TABLE `sd_shedule_assign` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
