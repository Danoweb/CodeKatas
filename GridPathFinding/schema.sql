-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.47-cll - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table danowebs_gridpathing.grids
CREATE TABLE IF NOT EXISTS `grids` (
  `grids_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grids_name` varchar(255) NOT NULL DEFAULT '0',
  `create_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`grids_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table danowebs_gridpathing.grids: 0 rows
/*!40000 ALTER TABLE `grids` DISABLE KEYS */;
INSERT INTO `grids` (`grids_id`, `grids_name`, `create_datetime`, `edit_datetime`, `active`) VALUES
	(1, 'Dano Test 1', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(2, 'Random Numbers', '2017-07-18 08:39:21', '2017-07-18 08:39:21', 'Y'),
	(3, 'Has To Fail', '2017-07-18 09:03:37', '2017-07-18 09:03:37', 'Y');
/*!40000 ALTER TABLE `grids` ENABLE KEYS */;

-- Dumping structure for table danowebs_gridpathing.grids_rows
CREATE TABLE IF NOT EXISTS `grids_rows` (
  `grids_rows_id` int(11) NOT NULL AUTO_INCREMENT,
  `grids_id` int(11) NOT NULL,
  `row_data` varchar(50) DEFAULT NULL,
  `create_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`grids_rows_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table danowebs_gridpathing.grids_rows: 0 rows
/*!40000 ALTER TABLE `grids_rows` DISABLE KEYS */;
INSERT INTO `grids_rows` (`grids_rows_id`, `grids_id`, `row_data`, `create_datetime`, `edit_datetime`, `active`) VALUES
	(19, 3, '23,18,14,19,22', '2017-07-18 09:03:37', '2017-07-18 09:03:37', 'Y'),
	(18, 2, '7,5,8,9,2,1,5,3,3', '2017-07-18 08:39:21', '2017-07-18 08:39:21', 'Y'),
	(17, 2, '1,2,3,4,8,6,3,4,7', '2017-07-18 08:39:21', '2017-07-18 08:39:21', 'Y'),
	(16, 2, '9,2,5,7,6,2,3,4,8', '2017-07-18 08:39:21', '2017-07-18 08:39:21', 'Y'),
	(11, 1, '3,4,1,2,8,6', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(12, 1, '6,1,8,2,7,4', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(13, 1, '5,9,3,9,9,5', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(14, 1, '8,4,1,3,2,6', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(15, 1, '3,7,2,8,6,4', '2017-07-17 16:13:07', '2017-07-17 16:13:07', 'Y'),
	(20, 3, '21,20,19,18,17', '2017-07-18 09:03:37', '2017-07-18 09:03:37', 'Y'),
	(21, 3, '14,13,12,29,31', '2017-07-18 09:03:37', '2017-07-18 09:03:37', 'Y'),
	(22, 3, '68,97,65,47,88', '2017-07-18 09:03:37', '2017-07-18 09:03:37', 'Y');
/*!40000 ALTER TABLE `grids_rows` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
