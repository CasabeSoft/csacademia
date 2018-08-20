CREATE DATABASE  IF NOT EXISTS `academia` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `academia`;
-- Estructura con datos basicos
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla csacademia.academic_period
DROP TABLE IF EXISTS `academic_period`;
CREATE TABLE IF NOT EXISTS `academic_period` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_academic_period_client1_idx` (`client_id`),
  CONSTRAINT `fk_academic_period_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.attendance
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`student_id`,`date`),
  KEY `fk_attendance_student1` (`student_id`),
  CONSTRAINT `fk_attendance_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.center
DROP TABLE IF EXISTS `center`;
CREATE TABLE IF NOT EXISTS `center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `notes` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_center_client_idx` (`client_id`),
  CONSTRAINT `fk_center_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.classroom
DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `center_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `capacity` tinyint(4) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classroom_center1` (`center_id`),
  CONSTRAINT `fk_classroom_center1` FOREIGN KEY (`center_id`) REFERENCES `center` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.client
DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `cif` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone1` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `report_logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla csacademia.client: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `name`, `cif`, `address`, `city`, `phone1`, `phone2`, `web`, `report_logo`) VALUES
	(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.contact
DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone_mobile` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `notes` text,
  `address` varchar(45) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `town` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `occupation` varchar(45) DEFAULT NULL,
  `id_card` varchar(15) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contact_client1` (`client_id`),
  CONSTRAINT `fk_contact_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.family
DROP TABLE IF EXISTS `family`;
CREATE TABLE IF NOT EXISTS `family` (
  `student_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `relationship_code` int(11) unsigned NOT NULL,
  PRIMARY KEY (`student_id`,`contact_id`),
  KEY `fk_family_student1` (`student_id`),
  KEY `fk_family_contact1` (`contact_id`),
  KEY `fk_family_family_relationship1` (`relationship_code`),
  CONSTRAINT `family_ibfk_1` FOREIGN KEY (`relationship_code`) REFERENCES `family_relationship` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_family_contact1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_family_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.family_relationship
DROP TABLE IF EXISTS `family_relationship`;
CREATE TABLE IF NOT EXISTS `family_relationship` (
  `code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla csacademia.family_relationship: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `family_relationship` DISABLE KEYS */;
INSERT INTO `family_relationship` (`code`, `name`) VALUES
	(1, 'Padre'),
	(2, 'Madre'),
	(3, 'Hermano'),
	(4, 'Hermana');
/*!40000 ALTER TABLE `family_relationship` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.group
DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `center_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `level_code` int(11) NOT NULL,
  `academic_period` int(11) DEFAULT NULL,
  `monday` char(1) DEFAULT NULL,
  `tuesday` char(1) DEFAULT NULL,
  `wednesday` char(1) DEFAULT NULL,
  `thursday` char(1) DEFAULT NULL,
  `friday` char(1) DEFAULT NULL,
  `saturday` char(1) DEFAULT NULL,
  `start_time` char(5) DEFAULT NULL,
  `end_time` char(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_teacher1_idx` (`teacher_id`),
  KEY `fk_groups_classroom1` (`classroom_id`),
  KEY `fk_groups_center1` (`center_id`),
  KEY `fk_group_level1` (`level_code`),
  KEY `fk_group_academic_period1` (`academic_period`),
  CONSTRAINT `fk_groups_center1` FOREIGN KEY (`center_id`) REFERENCES `center` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_groups_classroom1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_groups_teacher1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`contact_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`level_code`) REFERENCES `level` (`code`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.leave_reason
DROP TABLE IF EXISTS `leave_reason`;
CREATE TABLE IF NOT EXISTS `leave_reason` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_leave_reason_client1_idx` (`client_id`),
  CONSTRAINT `fk_leave_reason_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.level
DROP TABLE IF EXISTS `level`;
CREATE TABLE IF NOT EXISTS `level` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `price_1` decimal(10,2) DEFAULT NULL,
  `price_2` decimal(10,2) DEFAULT NULL,
  `price_3` decimal(10,2) DEFAULT NULL,
  `price_4` decimal(10,2) DEFAULT NULL,
  `price_6` decimal(10,2) DEFAULT NULL,
  `price_12` decimal(10,2) DEFAULT NULL,
  `state` char(1) DEFAULT 'A',
  PRIMARY KEY (`code`,`client_id`),
  KEY `fk_level_client1` (`client_id`),
  CONSTRAINT `fk_level_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.login
DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `role_code` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `verification_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_login_client1` (`client_id`),
  KEY `fk_login_role1` (`role_code`),
  CONSTRAINT `fk_login_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`role_code`) REFERENCES `role` (`code`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.payment
DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `concept` varchar(45) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `notes` text,
  `payment_period_id` int(11) DEFAULT NULL,
  `payment_period_year` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`,`student_id`),
  KEY `fk_payment_student1_idx` (`student_id`),
  KEY `fk_payment_period_id_idx` (`payment_period_id`),
  CONSTRAINT `fk_payment_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.payment_period
DROP TABLE IF EXISTS `payment_period`;
CREATE TABLE IF NOT EXISTS `payment_period` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `start_day` smallint(6) NOT NULL,
  `start_month` smallint(6) NOT NULL,
  `end_day` smallint(6) NOT NULL,
  `end_month` smallint(6) NOT NULL,
  `period_type` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payment_period_type_id_idx` (`period_type`),
  CONSTRAINT `fk_payment_period_type_id` FOREIGN KEY (`period_type`) REFERENCES `payment_period_type` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Períodos de pago con sus internvalos de inicio y fin';

-- Volcando datos para la tabla csacademia.payment_period: ~72 rows (aproximadamente)
/*!40000 ALTER TABLE `payment_period` DISABLE KEYS */;
INSERT INTO `payment_period` (`id`, `name`, `start_day`, `start_month`, `end_day`, `end_month`, `period_type`) VALUES
	(1, 'Enero', 1, 1, 31, 1, 1),
	(2, 'Febrero', 1, 2, 29, 2, 1),
	(3, 'Marzo', 1, 3, 31, 3, 1),
	(4, 'Abril', 1, 4, 30, 4, 1),
	(5, 'Mayo', 1, 5, 31, 5, 1),
	(6, 'Junio', 1, 6, 30, 6, 1),
	(7, 'Julio', 1, 7, 31, 7, 1),
	(8, 'Agosto', 1, 8, 31, 8, 1),
	(9, 'Septiembre', 1, 9, 30, 9, 1),
	(10, 'Octubre', 1, 10, 31, 10, 1),
	(11, 'Noviembre', 1, 11, 30, 11, 1),
	(12, 'Diciembre', 1, 12, 31, 12, 1),
	(13, 'Enero-Febrero', 1, 1, 29, 2, 2),
	(14, 'Febrero-Marzo', 1, 2, 31, 3, 2),
	(15, 'Marzo-Abril', 1, 3, 30, 4, 2),
	(16, 'Abril-Mayo', 1, 4, 31, 5, 2),
	(17, 'Mayo-Junio', 1, 5, 30, 6, 2),
	(18, 'Junio-Julio', 1, 6, 31, 7, 2),
	(19, 'Julio-Agosto', 1, 7, 31, 8, 2),
	(20, 'Agosto-Septiembre', 1, 8, 30, 9, 2),
	(21, 'Septiembre-Octubre', 1, 9, 31, 10, 2),
	(22, 'Octubre-Noviembre', 1, 10, 30, 11, 2),
	(23, 'Noviembre-Diciembre', 1, 11, 31, 12, 2),
	(24, 'Diciembre-Enero', 1, 12, 31, 1, 2),
	(25, 'Enero-Marzo', 1, 1, 31, 3, 3),
	(26, 'Febrero-Abril', 1, 2, 30, 4, 3),
	(27, 'Marzo-Mayo', 1, 3, 31, 5, 3),
	(28, 'Abril-Junio', 1, 4, 30, 6, 3),
	(29, 'Mayo-Julio', 1, 5, 31, 7, 3),
	(30, 'Junio-Agosto', 1, 6, 31, 8, 3),
	(31, 'Julio-Septiembre', 1, 7, 30, 9, 3),
	(32, 'Agosto-Octubre', 1, 8, 31, 10, 3),
	(33, 'Septiembre-Noviembre', 1, 9, 30, 11, 3),
	(34, 'Octubre-Diciembre', 1, 10, 31, 12, 3),
	(35, 'Noviembre-Enero', 1, 11, 31, 1, 3),
	(36, 'Diciembre-Febrero', 1, 12, 29, 2, 3),
	(37, 'Enero-Abril', 1, 1, 30, 4, 4),
	(38, 'Febrero-Mayo', 1, 2, 31, 5, 4),
	(39, 'Marzo-Junio', 1, 3, 30, 6, 4),
	(40, 'Abril-Julio', 1, 4, 31, 7, 4),
	(41, 'Mayo-Agosto', 1, 5, 31, 8, 4),
	(42, 'Junio-Septiembre', 1, 6, 30, 9, 4),
	(43, 'Julio-Octubre', 1, 7, 31, 10, 4),
	(44, 'Agosto-Noviembre', 1, 8, 30, 11, 4),
	(45, 'Septiembre-Diciembre', 1, 9, 31, 12, 4),
	(46, 'Octubre-Enero', 1, 10, 31, 1, 4),
	(47, 'Noviembre-Febrero', 1, 11, 29, 2, 4),
	(48, 'Diciembre-Marzo', 1, 12, 31, 3, 4),
	(49, 'Enero-Junio', 1, 1, 30, 6, 6),
	(50, 'Febrero-Julio', 1, 2, 31, 7, 6),
	(51, 'Marzo-Agosto', 1, 3, 31, 8, 6),
	(52, 'Abril-Septiembre', 1, 4, 30, 9, 6),
	(53, 'Mayo-Octubre', 1, 5, 31, 10, 6),
	(54, 'Junio-Noviembre', 1, 6, 30, 11, 6),
	(55, 'Julio-Diciembre', 1, 7, 31, 12, 6),
	(56, 'Agosto-Enero', 1, 8, 31, 1, 6),
	(57, 'Septiembre-Febrero', 1, 9, 29, 2, 6),
	(58, 'Octubre-Marzo', 1, 10, 31, 3, 6),
	(59, 'Noviembre-Abril', 1, 11, 30, 4, 6),
	(60, 'Diciembre-Mayo', 1, 12, 31, 5, 6),
	(61, 'Enero-Diciembre', 1, 1, 31, 12, 12),
	(62, 'Febrero-Enero', 1, 2, 31, 1, 12),
	(63, 'Marzo-Febrero', 1, 3, 29, 2, 12),
	(64, 'Abril-Marzo', 1, 4, 31, 3, 12),
	(65, 'Mayo-Abril', 1, 5, 30, 4, 12),
	(66, 'Junio-Mayo', 1, 6, 31, 5, 12),
	(67, 'Julio-Junio', 1, 7, 30, 6, 12),
	(68, 'Agosto-Julio', 1, 8, 31, 7, 12),
	(69, 'Septiembre-Agosto', 1, 9, 31, 8, 12),
	(70, 'Octubre-Septiembre', 1, 10, 30, 9, 12),
	(71, 'Noviembre-Octubre', 1, 11, 31, 10, 12),
	(72, 'Diciembre-Noviembre', 1, 12, 30, 11, 12);
/*!40000 ALTER TABLE `payment_period` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.payment_period_type
DROP TABLE IF EXISTS `payment_period_type`;
CREATE TABLE IF NOT EXISTS `payment_period_type` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `number_months` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla csacademia.payment_period_type: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `payment_period_type` DISABLE KEYS */;
INSERT INTO `payment_period_type` (`id`, `name`, `number_months`) VALUES
	(1, 'Mensual', 1),
	(2, 'Bimensual', 2),
	(3, 'Trimestral', 3),
	(4, 'Cuatrimestral', 4),
	(6, 'Semestral', 6),
	(12, 'Anual', 12);
/*!40000 ALTER TABLE `payment_period_type` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.qualification
DROP TABLE IF EXISTS `qualification`;
CREATE TABLE IF NOT EXISTS `qualification` (
  `student_id` int(11) NOT NULL,
  `academic_period` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `qualification` varchar(5) DEFAULT NULL,
  `trinity` varchar(10) DEFAULT NULL,
  `london` varchar(10) DEFAULT NULL,
  `others` varchar(15) DEFAULT NULL,
  `eval1` varchar(3) DEFAULT NULL,
  `eval2` varchar(3) DEFAULT NULL,
  `eval3` varchar(3) DEFAULT NULL,
  `level_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`,`academic_period`),
  KEY `fk_qualification_student1` (`student_id`),
  KEY `fk_qualification_academic_period1` (`academic_period`),
  KEY `fk_qualification_level1` (`level_code`),
  CONSTRAINT `fk_qualification_level1` FOREIGN KEY (`level_code`) REFERENCES `level` (`code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `qualification_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.role
DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla csacademia.role: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`code`, `description`) VALUES
	(2, 'Administrador'),
	(3, 'Secretaria');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.school_level
DROP TABLE IF EXISTS `school_level`;
CREATE TABLE IF NOT EXISTS `school_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_school_level_client1_idx` (`client_id`),
  CONSTRAINT `fk_school_level_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.student
DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `contact_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `school_level` int(11) DEFAULT NULL,
  `school_name` varchar(45) DEFAULT NULL,
  `language_years` tinyint(4) DEFAULT NULL,
  `bank_account_format` varchar(5) DEFAULT 'CCC',
  `bank_account_number` varchar(45) DEFAULT NULL,
  `bank_account_holder` varchar(45) DEFAULT NULL,
  `bank_payment` tinyint(1) DEFAULT NULL,
  `leave_reason_code` int(11) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `bank_notes` text,
  PRIMARY KEY (`contact_id`),
  KEY `fk_student_center1_idx` (`center_id`),
  KEY `fk_student_contact1_idx` (`contact_id`),
  KEY `fk_student_leave_reason1` (`leave_reason_code`),
  KEY `fk_student_group_idx` (`group_id`),
  KEY `fk_student_school_level_idx` (`school_level`),
  CONSTRAINT `fk_student_center1` FOREIGN KEY (`center_id`) REFERENCES `center` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_student_contact1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_student_group` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_leave_reason` FOREIGN KEY (`leave_reason_code`) REFERENCES `leave_reason` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_school_level` FOREIGN KEY (`school_level`) REFERENCES `school_level` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.task
DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11),
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  `description` text,
  `task_importance_id` int(10) unsigned DEFAULT NULL,
  `task_type_id` int(10) unsigned NOT NULL,
  `task_state_id` int(10) unsigned NOT NULL,
  `login_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_task_type1_idx` (`task_type_id`),
  KEY `fk_task_task_state1_idx` (`task_state_id`),
  KEY `fk_task_login1_idx` (`login_id`),
  KEY `fk_task_task_importance1_idx` (`task_importance_id`),
  KEY `fk_task_client1_idx` (`client_id`),
  CONSTRAINT `fk_task_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_task_login1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_task_importance1` FOREIGN KEY (`task_importance_id`) REFERENCES `task_importance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_task_state1` FOREIGN KEY (`task_state_id`) REFERENCES `task_state` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_task_type1` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.task_importance
DROP TABLE IF EXISTS `task_importance`;
CREATE TABLE IF NOT EXISTS `task_importance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_importance_client1_idx` (`client_id`),
  CONSTRAINT `fk_task_importance_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.task_state
DROP TABLE IF EXISTS `task_state`;
CREATE TABLE IF NOT EXISTS `task_state` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_state_client1_idx` (`client_id`),
  CONSTRAINT `fk_task_state_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.task_type
DROP TABLE IF EXISTS `task_type`;
CREATE TABLE IF NOT EXISTS `task_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla csacademia.task_type: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `task_type` DISABLE KEYS */;
INSERT INTO `task_type` (`id`, `name`) VALUES
	(1, 'Publico'),
	(2, 'Privado');
/*!40000 ALTER TABLE `task_type` ENABLE KEYS */;

-- Volcando estructura para tabla csacademia.teacher
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `contact_id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `cv` text,
  `type` char(1) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `state` char(1) DEFAULT NULL,
  `bank_account_format` varchar(5) DEFAULT 'CCC',
  `bank_account_number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `fk_teacher_contact1_idx` (`contact_id`),
  CONSTRAINT `fk_teacher_contact1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla csacademia.teachers_by_centers
DROP TABLE IF EXISTS `teachers_by_centers`;
CREATE TABLE IF NOT EXISTS `teachers_by_centers` (
  `center_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`center_id`,`teacher_id`),
  KEY `fk_teachers_by_centers_center1_idx` (`center_id`),
  KEY `fk_teachers_by_centers_teacher1_idx` (`teacher_id`),
  CONSTRAINT `fk_teachers_by_centers_center1` FOREIGN KEY (`center_id`) REFERENCES `center` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_teachers_by_centers_teacher1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando estructura para vista csacademia.view_student
DROP VIEW IF EXISTS `view_student`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_student` (
	`contact_id` INT(11) NOT NULL,
	`full_name` VARCHAR(91) NULL COLLATE 'utf8_general_ci',
	`client_id` INT(11) NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista csacademia.view_teacher
DROP VIEW IF EXISTS `view_teacher`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_teacher` (
	`contact_id` INT(11) NOT NULL,
	`full_name` VARCHAR(91) NULL COLLATE 'utf8_general_ci',
	`client_id` INT(11) NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista csacademia.view_student
DROP VIEW IF EXISTS `view_student`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_student`;
CREATE ALGORITHM=UNDEFINED VIEW `view_student` AS SELECT 
	`student`.`contact_id` AS `contact_id`,
	concat(`contact`.`first_name`,' ',`contact`.`last_name`) AS `full_name`,
	`contact`.client_id 
FROM `student` 
	LEFT JOIN `contact` 
		ON `student`.`contact_id` = `contact`.`id` ;

-- Volcando estructura para vista csacademia.view_teacher
DROP VIEW IF EXISTS `view_teacher`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_teacher`;
CREATE ALGORITHM=UNDEFINED VIEW `view_teacher` AS SELECT 
	`teacher`.`contact_id` AS `contact_id`,
	concat(`contact`.`first_name`,' ',`contact`.`last_name`) AS `full_name`,
	`contact`.client_id 
FROM `teacher` 
	LEFT JOIN `contact` 
		ON `teacher`.`contact_id` = `contact`.`id` ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
