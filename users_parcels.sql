-- -------------------------------------------------------------
-- MoonLabs PHP assignment SQL dump
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `parcels`;
CREATE TABLE `parcels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parcel_number` varchar(10) NOT NULL,
  `size` enum('S','M','L','XL') NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `parcels_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

INSERT INTO `parcels` (`id`, `parcel_number`, `size`, `user_id`) VALUES
(1, '850f6335d7', 'M', 3),
(2, '1fdeae476a', 'L', 3),
(3, '7c5d82c341', 'S', 1);

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email_address`, `phone_number`) VALUES
(1, 'Zsombor', 'Balogh', '$2y$10$WRIxAVQaZDu1uyN8EVX0JOMsa.BajP3cGKX1358eY.ao4W3MTfz/G', 'zsombor.balogh@moonproject.io', NULL),
(3, 'Jenő', 'Polgár', '$2y$10$2mV8PE20bXCGBw9inLrwIuhutdX0Fv0Duu.Y1IAHZG0MiK21Vdsse', 'jeno.polgar@moonproject.io', '+36203114566'),
(4, 'Mátyás', 'Király', '$2y$10$U7G2yqe.VQY2N4epftK9C.Gy2gZWqH7hoNywk1x8EkHT3ARNQcf.q', 'matyas.kiraly@moonproject.io', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;