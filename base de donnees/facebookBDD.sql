-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour facebook
CREATE DATABASE IF NOT EXISTS `facebook` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `facebook`;

-- Listage de la structure de la table facebook. identifiant
CREATE TABLE IF NOT EXISTS `identifiant` (
  `id_identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_mail` varchar(100) NOT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`id_identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table facebook.identifiant : ~1 rows (environ)
/*!40000 ALTER TABLE `identifiant` DISABLE KEYS */;
INSERT INTO `identifiant` (`id_identifiant`, `adresse_mail`, `telephone`, `mdp`) VALUES
	(1, 'test@test.fr', '0000', '$2y$10$J3pq2M4G07RbzavbsQBvjuvfbh4jCjpU4/q4HpA3B2J3e1givVgFu');
/*!40000 ALTER TABLE `identifiant` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
