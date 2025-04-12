-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2025 a las 21:45:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_practica`
--
CREATE DATABASE IF NOT EXISTS `inventario_practica` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `inventario_practica`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(7) NOT NULL,
  `categoria_nombre` varchar(50) NOT NULL,
  `categoria_ubicacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_ubicacion`) VALUES
(6, 'Herramientas Manuales', ''),
(7, 'Herramientas Eléctricas', ''),
(8, 'Materiales de Construcción', ''),
(9, 'Ferretería en General', ''),
(10, 'Pinturas y Acabados', ''),
(11, 'Electricidad', ''),
(12, 'Fontanería', ''),
(13, 'Seguridad', ''),
(14, 'Jardinería', ''),
(15, 'Equipos de Protección Personal', ''),
(16, 'Adhesivos y Selladores', 'Pasillo 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL,
  `cliente_cedula` int(10) NOT NULL,
  `cliente_nombre` varchar(255) NOT NULL,
  `cliente_ubicacion` varchar(255) NOT NULL,
  `cliente_telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_cedula`, `cliente_nombre`, `cliente_ubicacion`, `cliente_telefono`) VALUES
(1, 30666341, 'Richel Avendaño', 'Silvia Sofia, Calle 3', '04264136447'),
(3, 24304425, 'Rileny Coromoto', 'Palma de Oro, Calle 3', '04148953992'),
(4, 14219692, 'Arlenis Colmenares', 'Silvia Sofia, Calle 3', '04167293773'),
(5, 12583633, 'Richard', 'Campo Movil', '04167293123'),
(7, 30444123, 'Martinez Paez', 'En el Centro', '04167293321'),
(9, 20345765, 'Jeremias Ruiz', 'Silvia Sofia, Calle 7', '04167293234'),
(10, 12324334, 'Juan Perez', 'Avenida Concha', '04167293534'),
(13, 9235456, 'Maria', 'petare', '04126723377'),
(16, 28453201, 'Juana Valdor', 'Centro', '04147123455'),
(19, 23450922, 'Matias', 'Barinitas', '04161593773'),
(20, 25687933, 'Alberta', 'Varina', '04127299973'),
(41, 13993120, 'Maikol', 'Palma', '04122738674');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `factura_id` int(10) NOT NULL,
  `factura_monto` decimal(30,2) NOT NULL,
  `factura_concepto` varchar(150) NOT NULL,
  `factura_observacion` varchar(200) NOT NULL,
  `factura_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cliente_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`factura_id`, `factura_monto`, `factura_concepto`, `factura_observacion`, `factura_fecha`, `cliente_id`) VALUES
(74, 33.02, 'Venta de Productos', '', '2025-02-10 03:47:01', 1),
(75, 18.43, 'Venta de Productos', '', '2025-02-12 18:37:29', 1),
(76, 3.56, 'Venta de Productos', '', '2025-02-12 18:37:40', 1),
(77, 46.80, 'Venta de Productos', '', '2025-02-12 19:34:16', 9),
(78, 71.96, 'Venta de Productos', '', '2025-02-12 19:46:16', 20),
(79, 23.00, 'Venta de Productos', '', '2025-02-05 21:35:44', 10),
(80, 18.43, 'Venta de Productos', '', '2025-02-13 02:32:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_producto`
--

CREATE TABLE `factura_producto` (
  `factura_producto_id` int(10) NOT NULL,
  `factura_id` int(10) NOT NULL,
  `producto_id` int(10) DEFAULT NULL,
  `producto_cantidad` int(10) NOT NULL,
  `producto_nombre` varchar(70) NOT NULL,
  `producto_precio` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `factura_producto`
--

INSERT INTO `factura_producto` (`factura_producto_id`, `factura_id`, `producto_id`, `producto_cantidad`, `producto_nombre`, `producto_precio`) VALUES
(203, 74, 13, 2, 'Clavos Finos, 100 unidades', 10.00),
(204, 74, 21, 3, 'tubo pvc', 4.34),
(205, 75, 23, 1, 'Cemento de 60kg', 18.43),
(206, 76, 25, 1, 'Brocha para Pintar', 3.56),
(207, 77, 28, 20, 'Ladrillos de Concreto', 2.34),
(208, 78, 23, 2, 'Cemento de 60kg', 18.43),
(209, 78, 28, 15, 'Ladrillos de Concreto', 2.34),
(210, 79, 11, 1, 'Cable de Cobre 1kg', 23.00),
(216, 80, 23, 1, 'Cemento de 60kg', 18.43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL,
  `producto_nombre` varchar(70) NOT NULL,
  `producto_precio` decimal(30,2) NOT NULL,
  `producto_stock` int(25) NOT NULL,
  `producto_foto` varchar(500) NOT NULL,
  `categoria_id` int(7) NOT NULL,
  `proveedor_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `producto_nombre`, `producto_precio`, `producto_stock`, `producto_foto`, `categoria_id`, `proveedor_id`) VALUES
(11, 'Cable de Cobre 1kg', 23.00, 84, 'Cable_de_Cobre_1kg_254.jpg', 11, 1),
(13, 'Clavos Finos, 100 unidades', 10.00, 81, 'Clavos_Finos__100_unidades_535.jpg', 9, 1),
(16, 'Destornillador de Pala', 6.00, 321, 'Destornillador_de_Pala_810.jpg', 6, 1),
(21, 'tubo pvc', 4.34, 67, 'tubo_pvc_649.jpg', 12, 1),
(23, 'Cemento de 60kg', 18.43, 0, 'Cemento_de_60kg_11.jpg', 16, 1),
(24, 'Martillo', 9.99, 66, 'Martillo_874.jpg', 6, 1),
(25, 'Brocha para Pintar', 3.56, 66, 'Brocha_para_Pintar_28.jpg', 10, 2),
(26, 'Guantes de Trabajo', 7.99, 67, 'Guantes_de_Trabajo_920.jpg', 15, 2),
(27, 'tijera de podar', 14.50, 67, 'tijera_de_podar_891.jpg', 14, 2),
(28, 'Ladrillos de Concreto', 2.34, 43, 'Ladrillos_de_Concreto_579.jpg', 8, 2),
(29, 'Casco Azul de Seguridad', 25.00, 67, 'Casco_Azul_de_Seguridad_32.jpg', 13, 2),
(30, 'Taladro Inalambrico', 31.00, 67, 'Taladro_Inalambrico_495.jpg', 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(20) NOT NULL,
  `proveedor_nombre` varchar(255) NOT NULL,
  `proveedor_rif` varchar(15) NOT NULL,
  `proveedor_direccion` varchar(255) NOT NULL,
  `proveedor_telefono` varchar(15) NOT NULL,
  `proveedor_contacto_persona` varchar(255) NOT NULL,
  `proveedor_contacto_telefono` varchar(15) NOT NULL,
  `proveedor_condicion_pago` varchar(255) NOT NULL,
  `proveedor_observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `proveedor_nombre`, `proveedor_rif`, `proveedor_direccion`, `proveedor_telefono`, `proveedor_contacto_persona`, `proveedor_contacto_telefono`, `proveedor_condicion_pago`, `proveedor_observacion`) VALUES
(1, 'AgroLlano', '12838999', 'Av Paez 123', '04165369999', 'Juanito Manola', '04128348999', 'A 20 Dias', 'Buen Proveedor y Mal Amante'),
(2, 'FerreCopArt', '238829321', 'Av Colombia', '04122738674', '', '', 'A plazo de 30 dias', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_usuario` varchar(20) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_usuario`, `usuario_clave`) VALUES
(4, 'richel123', '$2y$04$kawtqsh5jW73s.ghB97YvuW7U.TtVSq5ROassEnJecDOhiEaT9I9u'),
(27, 'rileny123', '$2y$04$7al9GfEfe6DIv/MGi7/nhOhZN4RB.oCa6PYm94YdWxEZbzKSPSd5S'),
(28, 'arlenis123', '$2y$04$V0R9v/RMc8dELgPl8bqQkePDuL.4aafmWKoZIf3zYrFULh66PuseS'),
(29, 'fernando123', '$2y$04$tlIFfbDIjOlc8W9K275XROgy8rdLK/rZJEALFW5wm6qp11gw3/jVK'),
(30, 'maria123', '$2y$04$gMBTjxxuLZuWVH8oC4m2Iu5amKFKAmyvC1d7mGWPn2LX9XpL4wHsC'),
(46, 'Jeremias', ''),
(48, 'franklin123', '$2y$04$TrMr1G5trqiBnK7GsUSKSuKdEoESVu5.djPUivWSH6PDLgbaEchHu');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `factura_producto`
--
ALTER TABLE `factura_producto`
  ADD PRIMARY KEY (`factura_producto_id`),
  ADD KEY `factura_id` (`factura_id`,`producto_id`),
  ADD KEY `factura_producto_ibfk_2` (`producto_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `factura_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `factura_producto`
--
ALTER TABLE `factura_producto`
  MODIFY `factura_producto_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`);

--
-- Filtros para la tabla `factura_producto`
--
ALTER TABLE `factura_producto`
  ADD CONSTRAINT `factura_producto_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`factura_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_producto_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
