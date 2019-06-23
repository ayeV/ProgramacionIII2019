-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2018 a las 01:21:54
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bicicletasdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bicis`
--

CREATE TABLE `bicis` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  `foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bicis`
--

INSERT INTO `bicis` (`id`, `marca`, `precio`, `foto`) VALUES
(1, 'marca1', 1900, 'marca1_Foto.jpg'),
(2, 'marca2', 1587, 'marca2_Foto.jpg'),
(3, 'marca3', 1899, 'marca3_Foto.jpg'),
(4, 'marca4', 200, 'marca4_Foto.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `metodo` varchar(50) NOT NULL,
  `ruta` varchar(350) NOT NULL,
  `hora` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `id_usuario`, `metodo`, `ruta`, `hora`) VALUES
(7, NULL, 'POST', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/crearUsuario', '20:19'),
(8, NULL, 'POST', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/login', '20:19'),
(9, NULL, 'GET', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/bicicletas', '20:19'),
(10, 1, 'POST', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/bicicletas', '20:19'),
(11, NULL, 'GET', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/bicicletas', '20:19'),
(12, 3, 'GET', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/ventas', '20:20'),
(13, 1, 'POST', 'http://localhost:8080/MauricioCerizza_ProgIII_2doParcial/ventas', '20:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `nivel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `clave`, `id`, `nivel`) VALUES
('admin', 'admin', 1, 'admin'),
('user', '1234', 2, 'usuario'),
('user2', 'user2', 3, 'usuario'),
('usuario', 'usuario', 4, 'usuario'),
('usuario2', 'usuario2', 5, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `usuario` int(11) NOT NULL,
  `bici` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`usuario`, `bici`) VALUES
(2, 1),
(3, 1),
(3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bicis`
--
ALTER TABLE `bicis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bicis`
--
ALTER TABLE `bicis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
