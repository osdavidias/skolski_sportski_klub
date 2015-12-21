-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for sportski_klub
CREATE DATABASE IF NOT EXISTS `sportski_klub` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `sportski_klub`;


-- Dumping structure for table sportski_klub.razredi
CREATE TABLE IF NOT EXISTS `razredi` (
  `br_razreda` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_razreda` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`br_razreda`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sportski_klub.razredi: ~7 rows (approximately)
/*!40000 ALTER TABLE `razredi` DISABLE KEYS */;
INSERT INTO `razredi` (`br_razreda`, `naziv_razreda`) VALUES
	(1, 'prvi'),
	(2, 'drugi'),
	(3, 'treći'),
	(4, 'četvrti'),
	(5, 'peti'),
	(6, 'šesti'),
	(7, 'sedmi'),
	(8, 'osmi');
/*!40000 ALTER TABLE `razredi` ENABLE KEYS */;


-- Dumping structure for table sportski_klub.sportovi
CREATE TABLE IF NOT EXISTS `sportovi` (
  `br_sporta` int(11) NOT NULL,
  `naziv_sporta` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`br_sporta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sportski_klub.sportovi: ~6 rows (approximately)
/*!40000 ALTER TABLE `sportovi` DISABLE KEYS */;
INSERT INTO `sportovi` (`br_sporta`, `naziv_sporta`) VALUES
	(1, 'nogomet'),
	(2, 'košarka'),
	(3, 'rukomet'),
	(4, 'karate'),
	(5, 'streljaštvo'),
	(6, 'plivanje');
/*!40000 ALTER TABLE `sportovi` ENABLE KEYS */;


-- Dumping structure for table sportski_klub.treneri
CREATE TABLE IF NOT EXISTS `treneri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime_trenera` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prezime_trenera` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sport` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_treneri_sportovi` (`sport`),
  CONSTRAINT `FK_treneri_sportovi` FOREIGN KEY (`sport`) REFERENCES `sportovi` (`br_sporta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sportski_klub.treneri: ~2 rows (approximately)
/*!40000 ALTER TABLE `treneri` DISABLE KEYS */;
INSERT INTO `treneri` (`id`, `ime_trenera`, `prezime_trenera`, `sport`) VALUES
	(1, 'Pero', 'Perić', 1),
	(2, 'Jozo', 'Bozo', 4),
	(3, 'Matko', 'Matakovski', 5),
	(4, 'Pliki', 'Vodenović', 6);
/*!40000 ALTER TABLE `treneri` ENABLE KEYS */;


-- Dumping structure for table sportski_klub.treneri_ucenici
CREATE TABLE IF NOT EXISTS `treneri_ucenici` (
  `br_trenera` int(11) NOT NULL,
  `br_ucenika` int(11) NOT NULL,
  PRIMARY KEY (`br_trenera`,`br_ucenika`),
  KEY `FK_treneri_ucenici_ucenici` (`br_ucenika`),
  CONSTRAINT `FK_treneri_ucenici_treneri` FOREIGN KEY (`br_trenera`) REFERENCES `treneri` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_treneri_ucenici_ucenici` FOREIGN KEY (`br_ucenika`) REFERENCES `ucenici` (`br_ucenika`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sportski_klub.treneri_ucenici: ~17 rows (approximately)
/*!40000 ALTER TABLE `treneri_ucenici` DISABLE KEYS */;
INSERT INTO `treneri_ucenici` (`br_trenera`, `br_ucenika`) VALUES
	(1, 1),
	(3, 1),
	(1, 2),
	(4, 2),
	(1, 9),
	(2, 12),
	(1, 13),
	(3, 13),
	(2, 14),
	(1, 15),
	(3, 15),
	(1, 17),
	(1, 18),
	(2, 18),
	(3, 18),
	(4, 18);
/*!40000 ALTER TABLE `treneri_ucenici` ENABLE KEYS */;


-- Dumping structure for table sportski_klub.ucenici
CREATE TABLE IF NOT EXISTS `ucenici` (
  `br_ucenika` int(11) NOT NULL AUTO_INCREMENT,
  `razred` int(11) NOT NULL DEFAULT '0',
  `ime_ucenika` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prezime_ucenika` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `adresa` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mjesto` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  PRIMARY KEY (`br_ucenika`),
  KEY `razred` (`razred`),
  CONSTRAINT `FK_ucenici_razredi` FOREIGN KEY (`razred`) REFERENCES `razredi` (`br_razreda`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sportski_klub.ucenici: ~12 rows (approximately)
/*!40000 ALTER TABLE `ucenici` DISABLE KEYS */;
INSERT INTO `ucenici` (`br_ucenika`, `razred`, `ime_ucenika`, `prezime_ucenika`, `adresa`, `mjesto`, `telefon`) VALUES
	(1, 4, 'Marko', 'Marković', 'Neka 44', 'Osijek', 3156789),
	(2, 8, 'Josip', 'Perić', 'Županijska 23', 'Osijek', 345678),
	(9, 6, 'Hrvoje', 'Horvat', 'Duga 24', 'Đakovo', 91567854),
	(12, 5, 'Ante', 'Antić', 'Jablanova 67', 'Darda', 667754576),
	(13, 7, 'Barbara', 'Barić', 'Trg Branitelja bb', 'Osijek', 6745574),
	(14, 2, 'Jure', 'Jurić', 'Lj. Posavskog 4b', 'Osijek', 454333),
	(15, 6, 'Maja', 'Majić', 'Mlinska 7', 'Osijek', 556675),
	(16, 5, 'Mato', 'Matić', 'Visoka 17', 'Osijek', 5565656),
	(17, 7, 'Lauka', 'Lukić', 'Naselje 45', 'Osijek', 45454545),
	(18, 7, 'Zeko', 'Zekić', 'Dravska 12', 'Osijek', 23242525);
/*!40000 ALTER TABLE `ucenici` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
