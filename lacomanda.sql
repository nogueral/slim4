-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2021 a las 20:50:22
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacomanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `puntajeMesa` int(11) NOT NULL,
  `puntajeRestaurant` int(11) NOT NULL,
  `puntajeMozo` int(11) NOT NULL,
  `puntajeCocinero` int(11) NOT NULL,
  `promedio` int(11) NOT NULL,
  `comentarios` varchar(66) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id`, `idPedido`, `puntajeMesa`, `puntajeRestaurant`, `puntajeMozo`, `puntajeCocinero`, `promedio`, `comentarios`) VALUES
(1, 2, 5, 7, 8, 8, 7, 'Buena experiencia'),
(2, 1, 4, 4, 4, 4, 4, 'Horrible'),
(3, 1, 8, 7, 9, 9, 8, 'Excelente plato'),
(4, 2, 8, 7, 9, 4, 7, 'Hamburguesas quemadas'),
(5, 3, 8, 7, 9, 4, 7, 'Cerveza caliente'),
(6, 4, 8, 7, 9, 6, 8, 'Buen trago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `idMesa` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `idMesa`, `estado`) VALUES
(1, '10001', 'cerrada'),
(2, '10002', 'cerrada'),
(3, '10003', 'cerrada'),
(4, '10004', 'cerrada'),
(5, '10005', 'cerrada'),
(6, '10006', 'cerrada'),
(7, '10007', 'cerrada'),
(8, '10008', 'cerrada'),
(9, '10009', 'cerrada'),
(10, '10010', 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `horaIngreso` timestamp NULL DEFAULT NULL,
  `tiempoEstimado` timestamp NULL DEFAULT NULL,
  `rutaFoto` varchar(250) NOT NULL,
  `horaEntrega` timestamp NULL DEFAULT NULL,
  `monto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idMesa`, `idProducto`, `cantidad`, `cliente`, `perfil`, `estado`, `horaIngreso`, `tiempoEstimado`, `rutaFoto`, `horaEntrega`, `monto`) VALUES
(1, 10005, 1, 1, 'juan perez', 'cocinero', 'cobrado', '2021-11-27 17:49:34', '2021-11-27 18:09:34', './fotos/10005.jpg', '2021-11-27 18:14:50', 600),
(2, 10005, 2, 2, 'juan perez', 'cocinero', 'cobrado', '2021-11-27 17:50:33', '2021-11-27 18:05:33', 'sin foto', '2021-11-27 18:23:48', 600),
(3, 10005, 4, 1, 'juan perez', 'cervecero', 'cobrado', '2021-11-27 17:58:19', '2021-11-27 18:08:19', 'sin foto', '2021-11-27 18:15:59', 250),
(4, 10005, 3, 1, 'juan perez', 'bartender', 'cobrado', '2021-11-27 18:02:01', '2021-11-27 18:17:01', 'sin foto', '2021-11-27 18:16:36', 450);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `precio`) VALUES
(1, 'Milanesa a caballo', 600),
(2, 'Hamburguesa de garbanzo', 300),
(3, 'Daikiri', 450),
(4, 'Corona', 250),
(5, 'Quilmes', 250),
(6, 'Volcan de chocolate', 320),
(7, 'Sorrentinos con bolognesa', 460),
(8, 'suprema con guarnicion', 450),
(9, 'pollo al verdeo con papas', 660),
(10, 'pizza muzzarella', 450),
(11, 'pizza cuatro quesos', 660),
(12, 'flan mixto', 250),
(13, 'arroz con leche', 260);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`id`, `idUsuario`, `usuario`, `fecha`) VALUES
(1, 2, 'Juan', '2021-11-27 03:57:44'),
(2, 2, 'Juan', '2021-11-27 15:42:44'),
(3, 9, 'wfernicola', '2021-11-27 17:36:24'),
(4, 10, 'anavarro', '2021-11-27 17:38:31'),
(5, 4, 'mlopez', '2021-11-27 17:38:53'),
(6, 2, 'jdiaz', '2021-11-27 17:39:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` text NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fechaBaja` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `perfil`, `estado`, `fechaBaja`) VALUES
(1, 'lnoguera', '$2y$10$j9yayFePO/3R9XLvkMZlqOkP.H2RV1ycSmr993UxY3xRlUXB7.xVe', 'administrador', 'disponible', NULL),
(2, 'jdiaz', '$2y$10$j5Y7gaE3cfcP0NsBe/I82OREl2fLsSxvInCqYjCkCmCkRrHuqYsOW', 'mozo', 'disponible', NULL),
(3, 'jgomez', '$2y$10$GyuSJzbGkhIRFhzJXWc7VO1pp6lcNn4VB9c8oLIvYoSxoWrEYauBy', 'cervecero', 'disponible', NULL),
(4, 'mlopez', '$2y$10$DU8.T.EuR.OQ/Y2tV07pI.irMBHvKha9WpYaVVzPXQQ31t3ZqivkG', 'cocinero', 'disponible', NULL),
(5, 'arodriguez', '$2y$10$E2dlUzmRaQ1RfYk6Nr/MlOWbAfL6hSjL9fPvUfRaa3VIl/w5ASTly', 'bartender', 'disponible', NULL),
(6, 'jroig', '$2y$10$1juTdkxGAilytdOrx6VY4OcAGuD/A5UbHGT7HR6U72IRL2CSgG.hK', 'administrador', 'disponible', NULL),
(7, 'pbustamante', '$2y$10$SlBEOggf1Yq5MPxaNZzzPuWjU/hvcnwmXk0UMf1MwF4rmFqKVLa5G', 'administrador', 'disponible', NULL),
(8, 'rgomez', '$2y$10$lSp9KY33WkbG21qwnH5xQucUpAfm2A7LDIImNhx8AbPLhR/T4TQBW', 'cocinero', 'disponible', NULL),
(9, 'wfernicola', '$2y$10$GK4/a2.J7SvE.HWr3mx/q.Np3lA.0co95B2yjqlKCBBE9Or4L2mxu', 'cervecero', 'disponible', NULL),
(10, 'anavarro', '$2y$10$SP.Y6Etb0Cc4P/GJ6YtmaO0ClYjHDIkO.mJwpOn1xLb.MJVFD7KYe', 'bartender', 'disponible', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
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
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
