CREATE DATABASE  IF NOT EXISTS `eis_audit` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `eis_audit`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: eis_audit
-- ------------------------------------------------------
-- Server version	5.5.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_patient`
--

DROP TABLE IF EXISTS `audit_patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_patient` (
  `audit_patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `gender` enum('Muški','Ženski') NOT NULL,
  `birthdate` date NOT NULL,
  `oib` char(11) DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL,
  `postal_code` int(5) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `phone_number` varchar(16) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `audit_user` varchar(32) NOT NULL,
  `audit_action` enum('CREATE','UPDATE','DELETE','RESTORE') NOT NULL,
  `audit_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`audit_patient_id`),
  KEY `fx_patient_id` (`patient_id`),
  KEY `ix_audit_user` (`audit_user`),
  KEY `ix_audit_action` (`audit_action`),
  KEY `ix_audit_timestamp` (`audit_timestamp`),
  CONSTRAINT `fk_patient_audit_patient` FOREIGN KEY (`patient_id`) REFERENCES `eis_production`.`patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_patient`
--

LOCK TABLES `audit_patient` WRITE;
/*!40000 ALTER TABLE `audit_patient` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_patient` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-01-21  1:50:19
