-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-07-2021 a las 08:44:21
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbasociados`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `eliminarAsociado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarAsociado` (`_id` INT)  BEGIN
    UPDATE asociados SET deleted_at=1 WHERE id=_id;
END$$

DROP PROCEDURE IF EXISTS `getAsociados`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAsociados` (`_id` INT)  BEGIN
IF _id IS NULL THEN
    SELECT a.id, a.nombre,a.apellido, a.edad, a.direccion, a.dui, a.nit, p.id as profesion_id, p.profesion, u.id as agencia_id, u.agencia FROM asociados as a inner join profesiones as p on a.profesion_id=p.id INNER join agencias as u on a.agencia_id=u.id WHERE a.deleted_at=0;
ELSEIF _id IS NOT NULL THEN
    SELECT a.id, a.nombre,a.apellido, a.edad, a.direccion, a.dui, a.nit, p.id as profesion_id, p.profesion, u.id as agencia_id, u.agencia FROM asociados as a inner join profesiones as p on a.profesion_id=p.id INNER join agencias as u on a.agencia_id=u.id WHERE a.id=_id;
END IF;
END$$

DROP PROCEDURE IF EXISTS `getHistorial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getHistorial` (`_asociado_id` INT)  BEGIN
    SELECT u.nombre as usuario, a.id as asociado_id, a.nombre as asociado, h.* FROM historial as h inner join usuarios as u on u.id=h.usuario_id INNER JOIN asociados as a on a.id=h.asociado_id WHERE h.asociado_id=_asociado_id ORDER BY h.fecha DESC; 
END$$

DROP PROCEDURE IF EXISTS `saveAsociado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `saveAsociado` (`_nombre` VARCHAR(60), `_apellido` VARCHAR(60), `_direccion` TEXT, `_edad` INT, `_dui` VARCHAR(25), `_nit` VARCHAR(25), `_profesion_id` INT, `_agencia_id` INT, `_id` INT)  BEGIN
IF _id IS NULL THEN
    INSERT INTO asociados (nombre, apellido, direccion, edad, dui, nit, profesion_id, agencia_id) VALUES (_nombre, _apellido, _direccion, _edad, _dui, _nit, _profesion_id, _agencia_id);
    SET @id = LAST_INSERT_ID();
    CALL getAsociados(@id);
ELSEIF _id IS NOT NULL THEN
    UPDATE asociados SET nombre=_nombre, apellido=_apellido, direccion=_direccion, edad=_edad, dui=_dui, nit=_nit, profesion_id=_profesion_id, agencia_id=_agencia_id WHERE id=_id;
    CALL getAsociados(_id);
END IF;
END$$

DROP PROCEDURE IF EXISTS `saveHistorial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `saveHistorial` (`_usuario_id` INT, `_asociado_id` INT, `_campo` VARCHAR(50), `_old` VARCHAR(255), `_new` VARCHAR(255))  BEGIN
    INSERT INTO historial (usuario_id, asociado_id, campo, antiguo, nuevo) VALUES(_usuario_id, _asociado_id, _campo, _old, _new);
END$$

DROP PROCEDURE IF EXISTS `uniqueDui`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `uniqueDui` (`_dui` VARCHAR(25), `_id` INT)  BEGIN
    IF _id IS NULL THEN
        SELECT * FROM asociados WHERE dui=_dui;
    ELSEIF _id IS NOT NULL THEN
        SELECT * FROM asociados WHERE dui=_dui AND id <> _id;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias`
--

DROP TABLE IF EXISTS `agencias`;
CREATE TABLE IF NOT EXISTS `agencias` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `agencia` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `agencias`
--

INSERT INTO `agencias` (`id`, `agencia`) VALUES
(1, 'Chalatenango'),
(2, 'Nueva Concepcion'),
(3, 'Concepcion Quezalpeque'),
(4, 'La Palma');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociados`
--

DROP TABLE IF EXISTS `asociados`;
CREATE TABLE IF NOT EXISTS `asociados` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `direccion` text NOT NULL,
  `edad` int(11) NOT NULL,
  `dui` varchar(25) NOT NULL,
  `nit` varchar(25) NOT NULL,
  `profesion_id` int(255) NOT NULL,
  `agencia_id` int(255) NOT NULL,
  `deleted_at` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pk_asociados_agencia` (`agencia_id`),
  KEY `pk_asociados_profesion` (`profesion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asociados`
--

INSERT INTO `asociados` (`id`, `nombre`, `apellido`, `direccion`, `edad`, `dui`, `nit`, `profesion_id`, `agencia_id`, `deleted_at`, `created_at`) VALUES
(1, 'Marcos', 'Verrati', 'Chalatenango Barrio el chile', 28, '12345678-9', '0406-231198-101-1', 1, 1, 0, '2021-07-24 06:24:14'),
(2, 'Leonel Andres', 'Messi', 'Barrio El Calvario', 34, '23456789-1', '1234-102020-122-0', 2, 1, 0, '2021-07-24 06:25:37'),
(3, 'Cristiano', 'Ronaldo', 'Portugal Barrio el centro', 35, '98652287-9', '0406-231198-101-1', 4, 3, 0, '2021-07-24 06:28:14'),
(4, 'Andres', 'Iniesta', 'Caserio Rosario', 38, '92837211-1', '1000-234567-121-0', 3, 4, 0, '2021-07-24 06:29:11'),
(5, 'Xavi', 'Hernandez', 'frente a parque en spain', 39, '88883721-6', '1000-234567-121-0', 3, 2, 0, '2021-07-24 06:30:50'),
(6, 'Luis', 'Henrique', 'Avenida Spain', 50, '21834787-4', '0406-231198-101-1', 2, 1, 0, '2021-07-24 06:34:47'),
(7, 'Rodrigo', 'De Paul', 'Colonia Argentina', 28, '02034201-9', '1000-234567-121-0', 2, 4, 0, '2021-07-24 06:40:53'),
(8, 'Hector', 'Herrera', 'Caserio Nuevo Mexico', 33, '10037211-1', '1000-234567-121-0', 2, 1, 0, '2021-07-24 06:43:45'),
(9, 'Pedri', 'Gonzales', 'cuidad de barcelona', 18, '57577211-1', '1000-234567-121-0', 1, 4, 0, '2021-07-24 06:51:41'),
(10, 'Guillermo', 'Ochoa', 'Colonia las brisas', 32, '08629911-3', '1000-234567-121-0', 2, 1, 0, '2021-07-24 08:25:59'),
(11, 'Alfonso', 'Alvarado', 'barrio san antonio', 21, '92837211-9', '1234-102020-122-0', 3, 2, 1, '2021-07-24 08:29:30'),
(12, 'Sergio', 'Ramos', 'Barrio san jacinto', 34, '12125678-9', '0216-290980-101-1', 2, 2, 0, '2021-07-24 08:40:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int(255) NOT NULL,
  `asociado_id` int(255) NOT NULL,
  `campo` varchar(20) NOT NULL,
  `antiguo` varchar(60) NOT NULL,
  `nuevo` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pk_historial_usuario` (`usuario_id`),
  KEY `pk_historial_asociado` (`asociado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `fecha`, `usuario_id`, `asociado_id`, `campo`, `antiguo`, `nuevo`) VALUES
(1, '2021-07-24 07:18:24', 1, 1, 'direccion', 'Chalatenango Barrio el centro', 'Chalatenango Barrio el chile'),
(2, '2021-07-24 07:19:01', 1, 2, 'nombre', 'Leo', 'Leonel Andres'),
(3, '2021-07-24 07:20:09', 1, 8, 'edad', '31', '33'),
(4, '2021-07-24 07:20:50', 1, 3, 'direccion', 'Barrio el centro', 'Portugal Barrio el centro'),
(5, '2021-07-24 07:21:12', 1, 4, 'agencia_id', '4', '1'),
(6, '2021-07-24 07:22:02', 1, 5, 'direccion', 'frente a parque', 'frente a parque en spain'),
(7, '2021-07-24 07:55:39', 1, 1, 'nombre', 'Marco', 'Marcos'),
(8, '2021-07-24 08:26:40', 1, 10, 'nombre', 'Memo', 'Guillermo'),
(9, '2021-07-24 08:29:51', 1, 11, 'edad', '23', '21'),
(10, '2021-07-24 08:31:52', 1, 6, 'apellido', 'Suarez', 'Henrique'),
(11, '2021-07-24 08:31:52', 1, 6, 'edad', '35', '50'),
(12, '2021-07-24 08:31:52', 1, 6, 'direccion', 'Avenida Uruguay', 'Avenida Spain'),
(13, '2021-07-24 08:31:52', 1, 6, 'profesion_id', '3', '2'),
(14, '2021-07-24 08:40:46', 1, 12, 'edad', '33', '34'),
(15, '2021-07-24 08:40:46', 1, 12, 'direccion', 'Barrio las flores', 'Barrio san jacinto'),
(16, '2021-07-24 08:42:09', 2, 4, 'direccion', 'Canton rosario', 'Caserio Rosario'),
(17, '2021-07-24 08:42:09', 2, 4, 'agencia_id', '1', '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesiones`
--

DROP TABLE IF EXISTS `profesiones`;
CREATE TABLE IF NOT EXISTS `profesiones` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `profesion` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesiones`
--

INSERT INTO `profesiones` (`id`, `profesion`) VALUES
(1, 'Agronomo'),
(2, 'Agricultor'),
(3, 'Ganadero'),
(4, 'Ingeniero Civil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`) VALUES
(1, 'Jonathan', 'Alvarado', 'jonathanalvarado@hotmail.es', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6'),
(2, 'Admin', 'Admin', 'administrador@gmail.com', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asociados`
--
ALTER TABLE `asociados`
  ADD CONSTRAINT `pk_asociados_agencia` FOREIGN KEY (`agencia_id`) REFERENCES `agencias` (`id`),
  ADD CONSTRAINT `pk_asociados_profesion` FOREIGN KEY (`profesion_id`) REFERENCES `profesiones` (`id`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `pk_historial_asociado` FOREIGN KEY (`asociado_id`) REFERENCES `asociados` (`id`),
  ADD CONSTRAINT `pk_historial_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
