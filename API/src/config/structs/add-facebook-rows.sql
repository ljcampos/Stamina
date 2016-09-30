ALTER TABLE `usuario`
	add  COLUMN `facebookId` bigint(20) DEFAULT '0' AFTER `estatus_id`,
	add  COLUMN `isFacebookUser` tinyint(1) DEFAULT '0' AFTER `estatus_id`;