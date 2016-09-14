-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-09-2016 a las 00:17:00
-- Versión del servidor: 5.6.28-0ubuntu0.15.04.1
-- Versión de PHP: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `stamina3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_respuesta_pregunta_formulario_aplicacion`
--

CREATE TABLE IF NOT EXISTS `calificacion_respuesta_pregunta_formulario_aplicacion` (
`id` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `calificacion` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `tipo` int(11) NOT NULL COMMENT 'este es el rol del usuario',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estado`
--

CREATE TABLE IF NOT EXISTS `cat_estado` (
`estado_id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Catálogo de estados';

--
-- Volcado de datos para la tabla `cat_estado`
--

INSERT INTO `cat_estado` (`estado_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Tabasco', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estatus`
--

CREATE TABLE IF NOT EXISTS `cat_estatus` (
`estatus_id` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Catálogos de estatus';

--
-- Volcado de datos para la tabla `cat_estatus`
--

INSERT INTO `cat_estatus` (`estatus_id`, `estatus`, `descr`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'Usuario activo', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE IF NOT EXISTS `convocatoria` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `universidad_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendedor_convocatoria`
--

CREATE TABLE IF NOT EXISTS `emprendedor_convocatoria` (
`id` int(11) NOT NULL,
  `id_emprendedor` int(11) NOT NULL,
  `id_convocatoria` int(11) NOT NULL,
  `estatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_aplicacion`
--

CREATE TABLE IF NOT EXISTS `formulario_aplicacion` (
`id` int(11) NOT NULL,
  `seccion` varchar(255) NOT NULL,
  `estatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mentor`
--

CREATE TABLE IF NOT EXISTS `mentor` (
  `mentor_id` int(11) NOT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `descr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mentor`
--

INSERT INTO `mentor` (`mentor_id`, `cargo`, `descr`) VALUES
(2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
`permiso_id` int(11) NOT NULL,
  `permiso` varchar(50) NOT NULL,
  `descr` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Catálogo de permisos existentes para los usuarios';

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`permiso_id`, `permiso`, `descr`, `created_at`, `updated_at`) VALUES
(1, 'addEmp', 'Crear usuario emprendedor', '2016-09-13 00:00:00', '2016-09-13 00:00:00'),
(2, 'addMent', 'Crear usuario mentor', '2016-09-13 00:00:00', '2016-09-13 00:00:00'),
(3, 'addAdmin', 'Crear usuario administrador', NULL, NULL),
(4, 'addConv', 'Crear convocatoria', NULL, NULL),
(5, 'addUniv', 'Agregar universidad', NULL, NULL),
(6, 'addRole', 'Agregar rol', NULL, NULL),
(7, 'addPerm', 'Agregar permiso', NULL, NULL),
(8, 'addStatus', 'Agregar estatus', NULL, NULL),
(9, 'addEst', 'Agregar estado', NULL, NULL),
(10, 'addInsConv', 'Inscribir usuario a convocatoria', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE IF NOT EXISTS `permiso_rol` (
  `permiso_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `persona_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) DEFAULT NULL,
  `apellido_materno` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`persona_id`, `nombre`, `apellido_paterno`, `apellido_materno`) VALUES
(2, 'aaron', 'lopez', 'sosa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_formulario_aplicacion`
--

CREATE TABLE IF NOT EXISTS `pregunta_formulario_aplicacion` (
`id` int(11) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `nota` text NOT NULL,
  `ayuda` text NOT NULL,
  `aplica_calificacion` int(1) NOT NULL,
  `id_seccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promedio_calificacion_respuesta_formulario_aplicacion`
--

CREATE TABLE IF NOT EXISTS `promedio_calificacion_respuesta_formulario_aplicacion` (
`id` int(11) NOT NULL,
  `promedio` varchar(255) NOT NULL,
  `conclusion` text NOT NULL,
  `id_emprendedor_convocatoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_pregunta_formulario_aplicacion`
--

CREATE TABLE IF NOT EXISTS `respuesta_pregunta_formulario_aplicacion` (
`id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `calificacion_final` varchar(255) NOT NULL,
  `comentario_final` text NOT NULL,
  `id_emprendedor_convocatoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`rol_id` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `descr` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Catálogo de roles';

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol`, `descr`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Usuario administrador de la plataforma', NULL, NULL),
(2, 'mentor', 'Usuario mentor', NULL, NULL),
(3, 'emprendedor', 'Usuario emprendedor', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE IF NOT EXISTS `rol_usuario` (
  `rol_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de conexión entre usuario  y rol';

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`rol_id`, `user_id`) VALUES
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

CREATE TABLE IF NOT EXISTS `universidad` (
  `universidad_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`usuario_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `estatus_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Catálogos de usuarios registrados en la plataforma';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `username`, `email`, `password`, `salt`, `token`, `estatus_id`, `created_at`, `updated_at`, `last_login`) VALUES
(2, 'alsvader', 'alsvader@hotmail.com', 'aec4799ed14264a83adfa48f680a77a0707754aca75db786f46268038f300541', '39696e7ebea0bfef7d3d29dc015950c5c9f098cbed3e8c5b26718b6ff2c127ad', '1412ab6ee333f817668c55ed1eaccc4ad283f233bb535082e95935d6e6c4a1df', 1, '2016-09-13 23:37:20', '2016-09-13 23:37:20', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion_respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `calificacion_respuesta_pregunta_formulario_aplicacion`
 ADD PRIMARY KEY (`id`), ADD KEY `id_respuesta` (`id_respuesta`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
 ADD PRIMARY KEY (`estado_id`);

--
-- Indices de la tabla `cat_estatus`
--
ALTER TABLE `cat_estatus`
 ADD PRIMARY KEY (`estatus_id`);

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
 ADD PRIMARY KEY (`id`), ADD KEY `universidad_id` (`universidad_id`);

--
-- Indices de la tabla `emprendedor_convocatoria`
--
ALTER TABLE `emprendedor_convocatoria`
 ADD PRIMARY KEY (`id`), ADD KEY `id_emprendedor` (`id_emprendedor`), ADD KEY `id_convocatoria` (`id_convocatoria`);

--
-- Indices de la tabla `formulario_aplicacion`
--
ALTER TABLE `formulario_aplicacion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mentor`
--
ALTER TABLE `mentor`
 ADD PRIMARY KEY (`mentor_id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
 ADD PRIMARY KEY (`permiso_id`);

--
-- Indices de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
 ADD KEY `fk_pr_rol_idx` (`rol_id`), ADD KEY `fk_pr_permiso_idx` (`permiso_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
 ADD PRIMARY KEY (`persona_id`);

--
-- Indices de la tabla `pregunta_formulario_aplicacion`
--
ALTER TABLE `pregunta_formulario_aplicacion`
 ADD PRIMARY KEY (`id`), ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `promedio_calificacion_respuesta_formulario_aplicacion`
--
ALTER TABLE `promedio_calificacion_respuesta_formulario_aplicacion`
 ADD PRIMARY KEY (`id`), ADD KEY `id_emprendedor_convocatoria` (`id_emprendedor_convocatoria`);

--
-- Indices de la tabla `respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `respuesta_pregunta_formulario_aplicacion`
 ADD PRIMARY KEY (`id`), ADD KEY `id_pregunta` (`id_pregunta`), ADD KEY `id_emprendedor_convocatoria` (`id_emprendedor_convocatoria`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
 ADD KEY `fk_ru_rol_idx` (`rol_id`), ADD KEY `fk_ru_usuario_idx` (`user_id`);

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
 ADD PRIMARY KEY (`universidad_id`), ADD KEY `fk_universidad_usuario_idx` (`usuario_id`), ADD KEY `fk_universidad_estado` (`estado_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`usuario_id`), ADD KEY `fk_usuario_estatus_idx` (`estatus_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacion_respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `calificacion_respuesta_pregunta_formulario_aplicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
MODIFY `estado_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_estatus`
--
ALTER TABLE `cat_estatus`
MODIFY `estatus_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `emprendedor_convocatoria`
--
ALTER TABLE `emprendedor_convocatoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `formulario_aplicacion`
--
ALTER TABLE `formulario_aplicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
MODIFY `permiso_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pregunta_formulario_aplicacion`
--
ALTER TABLE `pregunta_formulario_aplicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `promedio_calificacion_respuesta_formulario_aplicacion`
--
ALTER TABLE `promedio_calificacion_respuesta_formulario_aplicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `respuesta_pregunta_formulario_aplicacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
MODIFY `universidad_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificacion_respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `calificacion_respuesta_pregunta_formulario_aplicacion`
ADD CONSTRAINT `fk_crpfa_persona_que_califica` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_crpfa_respuesta` FOREIGN KEY (`id_respuesta`) REFERENCES `respuesta_pregunta_formulario_aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
ADD CONSTRAINT `convocatoria_ibfk_1` FOREIGN KEY (`universidad_id`) REFERENCES `universidad` (`universidad_id`);

--
-- Filtros para la tabla `emprendedor_convocatoria`
--
ALTER TABLE `emprendedor_convocatoria`
ADD CONSTRAINT `fk_ec_convocatoria` FOREIGN KEY (`id_convocatoria`) REFERENCES `convocatoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ec_emprendedor` FOREIGN KEY (`id_emprendedor`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mentor`
--
ALTER TABLE `mentor`
ADD CONSTRAINT `fk_mentor_usuario` FOREIGN KEY (`mentor_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
ADD CONSTRAINT `fk_pr_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`permiso_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pr_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
ADD CONSTRAINT `fk_persona_usuario` FOREIGN KEY (`persona_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pregunta_formulario_aplicacion`
--
ALTER TABLE `pregunta_formulario_aplicacion`
ADD CONSTRAINT `fk_pfa_seccion` FOREIGN KEY (`id_seccion`) REFERENCES `formulario_aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `promedio_calificacion_respuesta_formulario_aplicacion`
--
ALTER TABLE `promedio_calificacion_respuesta_formulario_aplicacion`
ADD CONSTRAINT `fk_pcrfa_emprendedor_convocatoria` FOREIGN KEY (`id_emprendedor_convocatoria`) REFERENCES `emprendedor_convocatoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `respuesta_pregunta_formulario_aplicacion`
--
ALTER TABLE `respuesta_pregunta_formulario_aplicacion`
ADD CONSTRAINT `fk_rpfa_emprendedor_convocatoria` FOREIGN KEY (`id_emprendedor_convocatoria`) REFERENCES `emprendedor_convocatoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_rpfa_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta_formulario_aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
ADD CONSTRAINT `fk_ru_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ru_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `universidad`
--
ALTER TABLE `universidad`
ADD CONSTRAINT `fk_universidad_estado` FOREIGN KEY (`estado_id`) REFERENCES `cat_estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_universidad_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `fk_usuario_estatus` FOREIGN KEY (`estatus_id`) REFERENCES `cat_estatus` (`estatus_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
