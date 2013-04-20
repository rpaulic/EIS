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
-- Table structure for table `medical_record`
--

DROP TABLE IF EXISTS `medical_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_record` (
  `medical_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_uid` int(11) NOT NULL,
  `document_series` varchar(16) NOT NULL,
  `document_number` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_code` varchar(8) NOT NULL,
  `patient_full_name` varchar(64) NOT NULL,
  `patient_gender` enum('Muški','Ženski') NOT NULL,
  `patient_age` int(3) NOT NULL,
  `anamnesis` text,
  `examination` text,
  `diagnosis` text,
  `therapy` text,
  `recommendation` text,
  `is_printed` enum('Da','Ne') NOT NULL DEFAULT 'Ne',
  `is_locked` enum('Da','Ne') NOT NULL DEFAULT 'Ne',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`medical_record_id`),
  UNIQUE KEY `ux_document_uid` (`document_uid`),
  UNIQUE KEY `ux_document_number_document_series` (`document_series`,`document_number`),
  KEY `fx_patient_id` (`patient_id`),
  KEY `ix_document_series` (`document_series`),
  KEY `ix_document_date` (`document_date`),
  KEY `ix_patient_code` (`patient_code`),
  KEY `ix_patient_full_name` (`patient_full_name`),
  KEY `ix_is_deleted` (`is_deleted`),
  CONSTRAINT `fk_patient_medical_record` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_record`
--

LOCK TABLES `medical_record` WRITE;
/*!40000 ALTER TABLE `medical_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `medical_record` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eis_production`.`insert_on_medical_record`
AFTER INSERT ON `eis_production`.`medical_record`
FOR EACH ROW
BEGIN

    -- Determine action.
    IF NEW.is_deleted = 0 THEN
        SET @action = 'CREATE';
    ELSEIF NEW.is_deleted = 1 THEN
        SET @action = 'DELETE';
    END IF;
    
    -- Populate audit table.
    INSERT INTO eis_audit.audit_medical_record
    (medical_record_id
    ,document_uid
    ,document_series
    ,document_number
    ,document_date
    ,patient_id
    ,patient_code
    ,patient_full_name
    ,patient_gender
    ,patient_age
    ,anamnesis
    ,examination
    ,diagnosis
    ,therapy
    ,recommendation
    ,is_printed
    ,is_locked
    ,is_deleted
    ,audit_user
    ,audit_action
    ,audit_timestamp)
    VALUES
    (NEW.medical_record_id
    ,NEW.document_uid
    ,NEW.document_series
    ,NEW.document_number
    ,NEW.document_date
    ,NEW.patient_id
    ,NEW.patient_code
    ,NEW.patient_full_name
    ,NEW.patient_gender
    ,NEW.patient_age
    ,NEW.anamnesis
    ,NEW.examination
    ,NEW.diagnosis
    ,NEW.therapy
    ,NEW.recommendation
    ,NEW.is_printed
    ,NEW.is_locked
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `eis_production`.`update_on_medical_record`
AFTER UPDATE ON `eis_production`.`medical_record`
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
    INSERT INTO eis_audit.audit_medical_record
    (medical_record_id
    ,document_uid
    ,document_series
    ,document_number
    ,document_date
    ,patient_id
    ,patient_code
    ,patient_full_name
    ,patient_gender
    ,patient_age
    ,anamnesis
    ,examination
    ,diagnosis
    ,therapy
    ,recommendation
    ,is_printed
    ,is_locked
    ,is_deleted
    ,audit_user
    ,audit_action
    ,audit_timestamp)
    VALUES
    (NEW.medical_record_id
    ,NEW.document_uid
    ,NEW.document_series
    ,NEW.document_number
    ,NEW.document_date
    ,NEW.patient_id
    ,NEW.patient_code
    ,NEW.patient_full_name
    ,NEW.patient_gender
    ,NEW.patient_age
    ,NEW.anamnesis
    ,NEW.examination
    ,NEW.diagnosis
    ,NEW.therapy
    ,NEW.recommendation
    ,NEW.is_printed
    ,NEW.is_locked
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-01-21  1:50:19
