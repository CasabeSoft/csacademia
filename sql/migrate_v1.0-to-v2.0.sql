-- Renombrar tabla payment_type a payment_period_type
ALTER TABLE `payment_type` RENAME TO `payment_period_type`;

-- Añadir tabla `payment_period`

CREATE TABLE `payment_period` (
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

-- Añadir datos a `payment_period`

LOCK TABLES `payment_period` WRITE;
/*!40000 ALTER TABLE `payment_period` DISABLE KEYS */;
INSERT INTO `payment_period` (`id`, `name`, `start_day`, `start_month`, `end_day`, `end_month`, `period_type`) VALUES (1,'Enero',1,1,31,1,1),(2,'Febrero',1,2,29,2,1),(3,'Marzo',1,3,31,3,1),(4,'Abril',1,4,30,4,1),(5,'Mayo',1,5,31,5,1),(6,'Junio',1,6,30,6,1),(7,'Julio',1,7,31,7,1),(8,'Agosto',1,8,31,8,1),(9,'Septiembre',1,9,30,9,1),(10,'Octubre',1,10,31,10,1),(11,'Noviembre',1,11,30,11,1),(12,'Diciembre',1,12,31,12,1),(13,'Enero-Febrero',1,1,29,2,2),(14,'Febrero-Marzo',1,2,31,3,2),(15,'Marzo-Abril',1,3,30,4,2),(16,'Abril-Mayo',1,4,31,5,2),(17,'Mayo-Junio',1,5,30,6,2),(18,'Junio-Julio',1,6,31,7,2),(19,'Julio-Agosto',1,7,31,8,2),(20,'Agosto-Septiembre',1,8,30,9,2),(21,'Septiembre-Octubre',1,9,31,10,2),(22,'Octubre-Noviembre',1,10,30,11,2),(23,'Noviembre-Diciembre',1,11,31,12,2),(24,'Diciembre-Enero',1,12,31,1,2),(25,'Enero-Marzo',1,1,31,3,3),(26,'Febrero-Abril',1,2,30,4,3),(27,'Marzo-Mayo',1,3,31,5,3),(28,'Abril-Junio',1,4,30,6,3),(29,'Mayo-Julio',1,5,31,7,3),(30,'Junio-Agosto',1,6,31,8,3),(31,'Julio-Septiembre',1,7,30,9,3),(32,'Agosto-Octubre',1,8,31,10,3),(33,'Septiembre-Noviembre',1,9,30,11,3),(34,'Octubre-Diciembre',1,10,31,12,3),(35,'Noviembre-Enero',1,11,31,1,3),(36,'Diciembre-Febrero',1,12,29,2,3),(37,'Enero-Abril',1,1,30,4,4),(38,'Febrero-Mayo',1,2,31,5,4),(39,'Marzo-Junio',1,3,30,6,4),(40,'Abril-Julio',1,4,31,7,4),(41,'Mayo-Agosto',1,5,31,8,4),(42,'Junio-Septiembre',1,6,30,9,4),(43,'Julio-Octubre',1,7,31,10,4),(44,'Agosto-Noviembre',1,8,30,11,4),(45,'Septiembre-Diciembre',1,9,31,12,4),(46,'Octubre-Enero',1,10,31,1,4),(47,'Noviembre-Febrero',1,11,29,2,4),(48,'Diciembre-Marzo',1,12,31,3,4),(49,'Enero-Junio',1,1,30,6,6),(50,'Febrero-Julio',1,2,31,7,6),(51,'Marzo-Agosto',1,3,31,8,6),(52,'Abril-Septiembre',1,4,30,9,6),(53,'Mayo-Octubre',1,5,31,10,6),(54,'Junio-Noviembre',1,6,30,11,6),(55,'Julio-Diciembre',1,7,31,12,6),(56,'Agosto-Enero',1,8,31,1,6),(57,'Septiembre-Febrero',1,9,29,2,6),(58,'Octubre-Marzo',1,10,31,3,6),(59,'Noviembre-Abril',1,11,30,4,6),(60,'Diciembre-Mayo',1,12,31,5,6),(61,'Enero-Diciembre',1,1,31,12,12),(62,'Febrero-Enero',1,2,31,1,12),(63,'Marzo-Febrero',1,3,29,2,12),(64,'Abril-Marzo',1,4,31,3,12),(65,'Mayo-Abril',1,5,30,4,12),(66,'Junio-Mayo',1,6,31,5,12),(67,'Julio-Junio',1,7,30,6,12),(68,'Agosto-Julio',1,8,31,7,12),(69,'Septiembre-Agosto',1,9,31,8,12),(70,'Octubre-Septiembre',1,10,30,9,12),(71,'Noviembre-Octubre',1,11,31,10,12),(72,'Diciembre-Noviembre',1,12,30,11,12);
/*!40000 ALTER TABLE `payment_period` ENABLE KEYS */;
UNLOCK TABLES;

-- Renombrar columna piriod a concept
ALTER TABLE payment 
	CHANGE COLUMN `piriod` `concept` VARCHAR(45) NULL DEFAULT NULL;

-- Añadir columnas payment_period*
ALTER TABLE payment
	ADD COLUMN `payment_period_id` INT NULL  AFTER `notes` , 
	ADD COLUMN `payment_period_year` SMALLINT NULL  AFTER `payment_period_id`,
	ADD KEY `fk_payment_period_id_idx` (`payment_period_id`),
	ADD CONSTRAINT `fk_payment_period_id` FOREIGN KEY (`payment_period_id`) REFERENCES `payment_period` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

-- Establecer el valor del código del período y el año del pago
update payment p 
		left join payment_period pp on p.concept = pp.name
	set p.payment_period_id = pp.id, p.payment_period_year = year(p.date)
	where not pp.id is null or p.payment_type_id = 12;

-- Establecer el período Septiembre-Agosot para los pagos anuales
update payment p
	set p.payment_period_id = 69
	where p.payment_type_id = 12;

-- Eliminar columna payment_type_id innecesaria 
ALTER TABLE `academia_dev`.`payment` 
    DROP FOREIGN KEY `fk_payment_payment_type1`;
ALTER TABLE `academia_dev`.`payment` 
    DROP COLUMN `payment_type_id`,
    DROP INDEX `fk_payment_payment_type1_idx` ;
