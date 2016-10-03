ALTER TABLE `universidad`
    ADD COLUMN `fecha_inicio_servicio` DATE NOT NULL AFTER `usuario_id`,
    ADD COLUMN `fecha_final_servicio` DATE NOT NULL AFTER `fecha_inicio_servicio`;