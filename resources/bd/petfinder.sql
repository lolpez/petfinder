-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2016 a las 22:08:52
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `petfinder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE IF NOT EXISTS `imagen` (
`pkimagen` int(11) NOT NULL,
  `ruta` varchar(100) NOT NULL,
  `fkposter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE IF NOT EXISTS `mascota` (
`pkmascota` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `tamano` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `fktipo_mascota` int(11) NOT NULL,
  `fkraza` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0' COMMENT '0=perdido'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE IF NOT EXISTS `notificacion` (
`pknotificacion` int(11) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL,
  `fkusuario_destino` int(11) NOT NULL,
  `fkposter` int(11) NOT NULL,
  `visto` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poster`
--

CREATE TABLE IF NOT EXISTS `poster` (
`pkposter` int(11) NOT NULL,
  `fkusuario` int(11) NOT NULL,
  `fkmascota` int(11) NOT NULL,
  `fktipo_poster` int(11) NOT NULL,
  `latitud` varchar(30) NOT NULL,
  `longitud` varchar(30) NOT NULL,
  `recompensa` float NOT NULL,
  `tipo_moneda` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE IF NOT EXISTS `raza` (
`pkraza` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `fktipo_mascota` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`pkraza`, `nombre`, `fktipo_mascota`) VALUES
(1, 'Pastor Aleman', 1),
(2, 'Chihuahua', 1),
(3, 'Poodle', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mascota`
--

CREATE TABLE IF NOT EXISTS `tipo_mascota` (
`pktipo_mascota` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_mascota`
--

INSERT INTO `tipo_mascota` (`pktipo_mascota`, `nombre`) VALUES
(1, 'Perrito'),
(2, 'Gatito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_poster`
--

CREATE TABLE IF NOT EXISTS `tipo_poster` (
`pktipo_poster` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` float NOT NULL,
  `tipo_moneda` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_poster`
--

INSERT INTO `tipo_poster` (`pktipo_poster`, `nombre`, `descripcion`, `precio`, `tipo_moneda`) VALUES
(1, 'Normal', 'Poster gratis para todos :)', 0, 'bs'),
(2, 'Pro', 'Tu publicacion aparecera en primera fila', 10, 'bs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`pkusuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`pkusuario`, `nombre`) VALUES
(1, 'Luis Daniel'),
(2, 'Alejandro Molloja');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
 ADD PRIMARY KEY (`pkimagen`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
 ADD PRIMARY KEY (`pkmascota`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
 ADD PRIMARY KEY (`pknotificacion`);

--
-- Indices de la tabla `poster`
--
ALTER TABLE `poster`
 ADD PRIMARY KEY (`pkposter`);

--
-- Indices de la tabla `raza`
--
ALTER TABLE `raza`
 ADD PRIMARY KEY (`pkraza`);

--
-- Indices de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
 ADD PRIMARY KEY (`pktipo_mascota`);

--
-- Indices de la tabla `tipo_poster`
--
ALTER TABLE `tipo_poster`
 ADD PRIMARY KEY (`pktipo_poster`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`pkusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
MODIFY `pkimagen` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
MODIFY `pkmascota` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
MODIFY `pknotificacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `poster`
--
ALTER TABLE `poster`
MODIFY `pkposter` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
MODIFY `pkraza` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipo_mascota`
--
ALTER TABLE `tipo_mascota`
MODIFY `pktipo_mascota` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_poster`
--
ALTER TABLE `tipo_poster`
MODIFY `pktipo_poster` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `pkusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
