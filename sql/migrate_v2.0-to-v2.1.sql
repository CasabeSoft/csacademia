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

-- Agregar campos a la tabla cliente
ALTER TABLE `client`
	ADD COLUMN `cif` VARCHAR(50) NULL DEFAULT NULL AFTER `name`,
	ADD COLUMN `address` VARCHAR(250) NULL DEFAULT NULL AFTER `cif`,
	ADD COLUMN `city` VARCHAR(50) NULL DEFAULT NULL AFTER `address`,
	ADD COLUMN `phone1` VARCHAR(15) NULL DEFAULT NULL AFTER `city`,
	ADD COLUMN `phone2` VARCHAR(15) NULL DEFAULT NULL AFTER `phone1`,
        ADD COLUMN `web` VARCHAR(255) NULL DEFAULT NULL AFTER `phone2`,
        ADD COLUMN`report_logo` VARCHAR(255) NULL DEFAULT NULL AFTER `web`;

-- Actualizar cliente en los datos actuales
UPDATE `task` SET `client_id`=1;
UPDATE `school_level` SET `client_id`=1;
UPDATE `academic_period` SET `client_id`=1;
UPDATE `leave_reason` SET `client_id`=1;
UPDATE `task_importance` SET `client_id`=1;
UPDATE `task_state` SET `client_id`=1;
UPDATE `client` 
SET `cif`= 'B79907044', 
    `address` = 'Avda. Juan Carlos I, 92-2.14 <br> Avda. Juan Carlos I, 79-8 B  ',
    `city` = '28916 LEGANES',
    `phone1` = '91 680 10 44',
    `phone2` = '91 680 80 82',
    `web` = 'www.dundeeschool.com',
    `report_logo` = 'logo_dundee_print.png'
WHERE `id`=1;
