CREATE DATABASE  IF NOT EXISTS `eis_production` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `eis_production`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: eis_production
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
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`patient_id`),
  UNIQUE KEY `ux_code` (`code`),
  KEY `ix_full_name` (`full_name`),
  KEY `ix_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eis_production`.`insert_on_patient`
AFTER INSERT ON `eis_production`.`patient`
FOR EACH ROW
BEGIN

    -- Determine action.
    IF NEW.is_deleted = 0 THEN
        SET @action = 'CREATE';
    ELSEIF NEW.is_deleted = 1 THEN
        SET @action = 'DELETE';
    END IF;
    
    -- Populate audit table.
    INSERT INTO eis_audit.audit_patient
    (patient_id
    ,code
    ,first_name
    ,last_name
    ,full_name
    ,gender
    ,birthdate
    ,oib
    ,address
    ,postal_code
    ,location
    ,phone_number
    ,email
    ,is_deleted
    ,audit_user
    ,audit_action
    ,audit_timestamp)
    VALUES
    (NEW.patient_id
    ,NEW.code
    ,NEW.first_name
    ,NEW.last_name
    ,NEW.full_name
    ,NEW.gender
    ,NEW.birthdate
    ,NEW.oib
    ,NEW.address
    ,NEW.postal_code
    ,NEW.location
    ,NEW.phone_number
    ,NEW.email
    ,NEW.is_deleted
    ,USER()
    ,@action
    ,CURRENT_TIMESTAMP());

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eis_production`.`update_on_patient`
AFTER UPDATE ON `eis_production`.`patient`
FOR EACH ROW
BEGIN

    -- Determine action.
    IF OLD.is_deleted = 0 THEN
        IF NEW.is_deleted = 0 THEN
            SET @action = 'UPDATE';
        ELSEIF NEW.is_deleted = 1 THEN
            SET @action = 'DELETE';
        END IF;
    ELSEIF OLD.is_deleted = 1 THEN
        IF NEW.is_deleted = 0 THEN
            SET @action = 'RESTORE';
        ELSEIF NEW.is_deleted = 1 THEN
            SET @action = 'UPDATE';
        END IF;
    END IF;
    
    -- Populate audit table.
    INSERT INTO eis_audit.audit_patient
    (patient_id
    ,code
    ,first_name
    ,last_name
    ,full_name
    ,gender
    ,birthdate
    ,oib
    ,address
    ,postal_code
    ,location
    ,phone_number
    ,email
    ,is_deleted
    ,audit_user
    ,audit_action
    ,audit_timestamp)
    VALUES
    (NEW.patient_id
    ,NEW.code
    ,NEW.first_name
    ,NEW.last_name
    ,NEW.full_name
    ,NEW.gender
    ,NEW.birthdate
    ,NEW.oib
    ,NEW.address
    ,NEW.postal_code
    ,NEW.location
    ,NEW.phone_number
    ,NEW.email
    ,NEW.is_deleted
    ,USER()
    ,@action
    ,CURRENT_TIMESTAMP());
    
    -- Lock/unlock patient's medical records when action is DELETE/RESTORE.
    IF @action = 'DELETE' THEN
        UPDATE medical_record
        SET is_locked = 'Da'
        WHERE patient_id = NEW.patient_id;
    ELSEIF @action = 'RESTORE' THEN
        UPDATE medical_record
        SET is_locked = 'Ne'
        WHERE patient_id = NEW.patient_id
        AND is_printed = 'Ne';
    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-01-21  1:50:19
