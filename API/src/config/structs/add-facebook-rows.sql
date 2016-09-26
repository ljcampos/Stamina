ALTER TABLE `usuario` add  `facebookId` bigint(20) DEFAULT '0' AFTER `estatus_id`,
ALTER TABLE `usuario` add  `isFacebookUser` tinyint(1) DEFAULT '0' AFTER `estatus_id`