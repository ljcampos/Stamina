ALTER TABLE `usuario`
	add  COLUMN `imagen` varchar(255) DEFAULT 'NULL' AFTER `email`;

ALTER TABLE `universidad`
	add  COLUMN `imagen` varchar(255) DEFAULT 'NULL' AFTER `nombre`;