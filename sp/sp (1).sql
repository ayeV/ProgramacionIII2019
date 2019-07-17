-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2019 a las 02:00:43
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sp`
--
CREATE DATABASE IF NOT EXISTS `sp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `sp`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `cupos` int(11) NOT NULL,
  `profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id`, `nombre`, `cuatrimestre`, `cupos`, `profesor`) VALUES
(1, 'Programacion', 1, 8, 12),
(2, 'Programacion 2', 1, 9, 12),
(3, 'Programacion 22', 1, 0, 0),
(4, 'fisica', 2, 8, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_alumno`
--

CREATE TABLE `materia_alumno` (
  `id` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `legajo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `materia_alumno`
--

INSERT INTO `materia_alumno` (`id`, `materia`, `legajo`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 3, 3),
(4, 4, 13),
(5, 4, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `legajo` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`legajo`, `nombre`, `clave`, `tipo`, `email`) VALUES
(2, 'alumno1', '1234', 'alumno', 'email@asd.com'),
(3, 'alumno1', '1234', 'alumno', ''),
(4, 'alumno1', '1234', 'alumno', ''),
(5, 'alumno1', '1234', 'alumno', ''),
(6, 'alumno1', '1234', 'alumno', 'asd'),
(7, 'alumno1', '1234', 'alumno', ''),
(8, 'admin1', '1234', 'admin', ''),
(9, 'profesor1', '1234', 'profesor', 'ssss'),
(10, 'mario', '123', 'profesor', 'emaasdasdil@sdfdsfdsffsdf.com'),
(11, 'pepe', 'pepe', 'admin', ''),
(12, 'juana', 'juana', 'profesor', 'emaasdasdil@sdfdsfdsffsdf.com'),
(13, 'alumno', 'alumno', 'alumno', 'asd'),
(14, 'sp', 'sp', 'alumno', 'dfsdgst');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia_alumno`
--
ALTER TABLE `materia_alumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`legajo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materia_alumno`
--
ALTER TABLE `materia_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `legajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
