-- Agregar campo client_id en las tablas y vistas para el control de clientes 
ALTER TABLE `task`
	ADD COLUMN `client_id` INT(11) NULL AFTER `id`,
        ADD INDEX `fk_task_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_task_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `school_level`
	ADD COLUMN `client_id` INT(11) NULL AFTER `id`,
        ADD INDEX `fk_school_level_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_school_level_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `academic_period`
	ADD COLUMN `client_id` INT(11) NULL AFTER `code`,
        ADD INDEX `fk_academic_period_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_academic_period_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `leave_reason`
	ADD COLUMN `client_id` INT(11) NULL AFTER `code`,
        ADD INDEX `fk_leave_reason_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_leave_reason_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `task_importance`
	ADD COLUMN `client_id` INT(11) NULL AFTER `id`,
        ADD INDEX `fk_task_importance_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_task_importance_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `task_state`
	ADD COLUMN `client_id` INT(11) NULL AFTER `id`,
        ADD INDEX `fk_task_state_client1_idx` (`client_id`),
        ADD CONSTRAINT `fk_task_state_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER ALGORITHM = UNDEFINED VIEW `view_teacher` AS 
SELECT 
	`teacher`.`contact_id` AS `contact_id`,
	concat(`contact`.`first_name`,' ',`contact`.`last_name`) AS `full_name`,
	`contact`.client_id 
FROM `teacher` 
	LEFT JOIN `contact` 
		ON `teacher`.`contact_id` = `contact`.`id`;

ALTER ALGORITHM = UNDEFINED VIEW `view_student` AS 
SELECT 
	`student`.`contact_id` AS `contact_id`,
	concat(`contact`.`first_name`,' ',`contact`.`last_name`) AS `full_name`,
	`contact`.client_id 
FROM `student` 
	LEFT JOIN `contact` 
		ON `student`.`contact_id` = `contact`.`id`;

-- Nueva tabla para configurar la informacion del cliente
CREATE TABLE `cliente_info` (
	`client_id` INT(11) NOT NULL,
        `name` VARCHAR(250) NULL DEFAULT NULL,
	`cif` VARCHAR(50) NULL DEFAULT NULL,
	`address` VARCHAR(250) NULL DEFAULT NULL,
	`city` VARCHAR(50) NULL DEFAULT NULL,
	`phone1` VARCHAR(15) NULL DEFAULT NULL,
	`phone2` VARCHAR(15) NULL DEFAULT NULL,
        `web` VARCHAR(255) NULL DEFAULT NULL,
        `report_logo` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`client_id`),
	CONSTRAINT `fk_info_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
ENGINE=InnoDB;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tri_client_after_insert` AFTER INSERT ON `client` FOR EACH ROW BEGIN
	INSERT INTO client_info (client_id) VALUES (NEW.id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

INSERT INTO `client_info` (`client_id`, `name`, `cif`, `address`, `city`, `phone1`, `phone2`, `web`, `report_logo`) VALUES 
    (1, 'Dundee School of English', 'B79907044', 'Avda. Juan Carlos I, 92-2.14 <br> Avda. Juan Carlos I, 79-8 B  ', '28916 LEGANES', '91 680 10 44', '91 680 80 82', 'www.dundeeschool.com', 'logo_dundee_print.png');

-- Actualizar cliente en los datos actuales
UPDATE `task` SET `client_id`=1;
UPDATE `school_level` SET `client_id`=1;
UPDATE `academic_period` SET `client_id`=1;
UPDATE `leave_reason` SET `client_id`=1;
UPDATE `task_importance` SET `client_id`=1;
UPDATE `task_state` SET `client_id`=1;

ALTER TABLE `task`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `id`;
ALTER TABLE `school_level`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `id`;
ALTER TABLE `academic_period`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `code`;
ALTER TABLE `leave_reason`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `code`;
ALTER TABLE `task_importance`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `id`;
ALTER TABLE `task_state`
	CHANGE COLUMN `client_id` `client_id` INT(11) NOT NULL AFTER `id`;