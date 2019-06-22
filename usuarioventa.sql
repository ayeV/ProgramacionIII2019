-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2019 a las 22:12:07
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarioventa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `articulo` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `precio` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `foto` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `articulo`, `fecha`, `precio`, `id_user`, `foto`) VALUES
(1, 'mesa', '0000-00-00', 200, 2, NULL),
(2, 'silla', '0000-00-00', 100, 2, NULL),
(3, 'sillon', '2019-06-20', 555, 2, NULL),
(4, 'sillon', '2019-06-20', 1500, 2, NULL),
(5, 'jarra', '2019-06-22', 120, 2, NULL),
(6, 'jarra', '2019-06-22', 120, 3, NULL),
(7, 'jarra', '2019-06-22', 120, 3, NULL),
(8, 'alfombra', '2019-06-22', 250, 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `metodo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_historial`, `id_user`, `metodo`, `ruta`, `hora`) VALUES
(1, 2, 'GET', 'http://localhost/Modelo2doParcial/compras/Compra', '16:28:42'),
(2, 3, 'POST', 'http://localhost/Modelo2doParcial/compras/Compra', '16:38:01'),
(3, 2, 'GET', 'http://localhost/Modelo2doParcial/compras/Compra', '16:38:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `sexo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `perfil` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombre`, `clave`, `sexo`, `perfil`) VALUES
(1, 'admin', 'admin', 'femenino', 'admin'),
(2, 'user01', 'user01', 'femenino', 'Usuario'),
(3, 'user02', 'user02', 'femenino', 'Usuario'),
(4, 'user03', 'user03', 'masculino', 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
