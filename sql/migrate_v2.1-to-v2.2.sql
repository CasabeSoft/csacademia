-- Añaidr tabla `key_value_storage`
DROP TABLE IF EXISTS `key_value_storage`;
CREATE TABLE `key_value_storage` (
  `client_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`client_id`,`key`),
  CONSTRAINT `fk_key_value_storage_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=uft8;