/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.27-MariaDB : Database - agenda
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`agenda` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;

USE `agenda`;

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `id` INT(50) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `ciudad` VARCHAR(50) NOT NULL,
  `pais` VARCHAR(50) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `contactos` */

LOCK TABLES `contactos` WRITE;

INSERT  INTO `contactos`(`id`,`nombre`,`ciudad`,`pais`) VALUES (1,'Paco','Madrid','España'),(2,'León','Barcelona','España'),(3,'Sonia','Málaga','España'),(4,'Carmen','Asturias','España'),(5,'John','Londres','Reino Unido'),(6,'Ann','Liverpool','Reino Unido'),(7,'Marcel','París','Francia'),(8,'Giancarlo','Roma','Italia'),(9,'Louise','Marsella','Francia'),(10,'Francesca','Milán','Italia'),(11,'Rudolf','Berlín','Alemania'),(12,'Mariska','Berlín','Alemania'),(13,'Pierre','Orleans','Francia'),(14,'Johanna','Bonn','Alemania');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
