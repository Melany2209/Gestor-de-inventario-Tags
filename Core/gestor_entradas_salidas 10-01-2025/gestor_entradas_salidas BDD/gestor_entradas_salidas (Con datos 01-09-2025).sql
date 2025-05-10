CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `status`) VALUES
(1, 'Tintas', 1),
(2, 'Telas', 1),
(3, 'Papel', 1),
(4, 'Repuestos', 1),
(5, 'D Flex', 1),
(6, 'T Flex', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_sub_categoria`
--

CREATE TABLE `categoria_sub_categoria` (
  `id` int(11) NOT NULL,
  `id_sub_categoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categoria_sub_categoria`
--

INSERT INTO `categoria_sub_categoria` (`id`, `id_sub_categoria`, `id_categoria`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 2, 1),
(7, 7, 3, 1),
(8, 8, 5, 1),
(9, 9, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradasalidaTotal`
--

CREATE TABLE `entradasalidaTotal` (
  `id` int(11) NOT NULL,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL,
  `fecha_salida` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL,
  `fecha_salida` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `producto` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_minimo` double DEFAULT NULL,
  `tipo_de_unidad` varchar(100) DEFAULT NULL,
  `id_sub_categoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `status`, `entradas`, `salidas`, `stock_actual`, `fecha_creacion`, `fecha_modificacion`, `stock_minimo`, `tipo_de_unidad`, `id_sub_categoria`, `id_categoria`) VALUES
(1, 'Negro', 1, 0, 0, 8, '2025-01-09 05:22:54', '2025-01-10 05:02:31', 2, 'unidades', 1, 1),
(2, 'Yellow', 1, 0, 0, 6, '2025-01-09 05:23:27', '2025-01-10 05:03:46', 2, 'unidades', 1, 1),
(3, 'Magenta', 1, 0, 0, 5, '2025-01-09 05:23:40', '2025-01-10 05:02:31', 2, 'unidades', 1, 1),
(4, 'Cyan (azul)', 1, 0, 0, 7, '2025-01-09 05:23:55', '2025-01-09 05:23:55', 2, 'unidades', 1, 1),
(5, 'Negro', 1, 0, 0, 5, '2025-01-09 05:24:45', '2025-01-09 05:24:45', 5, 'unidades', 2, 1),
(6, 'Yellow', 1, 0, 0, 0, '2025-01-09 05:25:03', '2025-01-09 05:25:03', 5, 'unidades', 2, 1),
(7, 'Magenta', 1, 0, 0, 20, '2025-01-09 05:25:22', '2025-01-09 05:25:22', 5, 'unidades', 2, 1),
(8, 'Cyan (azul)', 1, 0, 0, 0, '2025-01-09 05:25:43', '2025-01-09 05:25:43', 5, 'unidades', 2, 1),
(9, 'FP', 1, 0, 0, 2, '2025-01-09 05:26:02', '2025-01-09 05:26:02', 5, 'unidades', 2, 1),
(10, 'FY', 1, 0, 0, 3, '2025-01-09 05:26:18', '2025-01-09 05:26:18', 5, 'unidades', 2, 1),
(11, 'Negro', 1, 0, 0, 12, '2025-01-09 05:27:14', '2025-01-09 05:27:14', 4, 'unidades', 3, 1),
(12, 'Yellow', 1, 0, 0, 14, '2025-01-09 05:27:35', '2025-01-09 05:27:35', 4, 'unidades', 3, 1),
(13, 'Magenta', 1, 0, 0, 13, '2025-01-09 05:28:05', '2025-01-09 05:28:05', 4, 'unidades', 3, 1),
(14, 'Cyan (azul)', 1, 0, 0, 16, '2025-01-09 05:28:24', '2025-01-09 05:28:24', 4, 'unidades', 3, 1),
(15, 'Blanco (2)', 1, 0, 0, 27, '2025-01-09 05:28:56', '2025-01-09 05:28:56', 10, 'unidades', 3, 1),
(16, 'No color', 1, 0, 0, 2, '2025-01-09 05:29:18', '2025-01-09 05:29:18', 4, 'unidades', 3, 1),
(17, 'Negro', 1, 0, 0, 28, '2025-01-09 05:30:39', '2025-01-09 05:30:39', 5, 'unidades', 4, 1),
(18, 'Yellow', 1, 0, 0, 20, '2025-01-09 05:31:05', '2025-01-09 05:31:05', 5, 'unidades', 4, 1),
(19, 'Magenta', 1, 0, 0, 24, '2025-01-09 05:31:24', '2025-01-09 05:31:24', 5, 'unidades', 4, 1),
(20, 'Cyan (azul)', 1, 0, 0, 25, '2025-01-09 05:31:44', '2025-01-09 05:31:44', 5, 'unidades', 4, 1),
(21, 'Yellow', 1, 0, 0, 15, '2025-01-09 05:33:43', '2025-01-09 05:33:43', 5, 'unidades', 5, 1),
(22, 'Magenta', 1, 0, 0, 15, '2025-01-09 05:34:37', '2025-01-09 05:34:37', 5, 'unidades', 5, 1),
(23, 'Cyan (azul)', 1, 0, 0, 13, '2025-01-09 05:34:55', '2025-01-09 05:34:55', 5, 'unidades', 5, 1),
(24, 'Negro', 1, 0, 0, 14, '2025-01-09 05:35:15', '2025-01-09 05:35:15', 5, 'unidades', 5, 1),
(25, 'ATENAS SPORT', 1, 0, 0, 68, '2025-01-09 05:39:39', '2025-01-09 05:39:39', 50, 'metros', 6, 2),
(26, 'DRY FIT', 1, 0, 0, 30, '2025-01-09 05:40:27', '2025-01-09 05:40:27', 50, 'metros', 6, 2),
(27, 'FLY BANNER BRILLANTE', 1, 0, 0, 40.7, '2025-01-09 05:41:27', '2025-01-09 05:41:27', 50, 'metros', 6, 2),
(28, 'FLY BANNER', 1, 0, 0, 1050, '2025-01-09 05:42:04', '2025-01-09 05:42:04', 300, 'metros', 6, 2),
(29, 'GOLF ESCOCIA', 1, 0, 0, 2, '2025-01-09 05:45:11', '2025-01-09 05:45:11', 50, 'rollos', 6, 2),
(30, 'MICRO FIBRA ACUALITI (LICRA)', 1, 0, 0, 441.3, '2025-01-09 05:49:58', '2025-01-09 05:49:58', 50, 'metros', 6, 2),
(31, 'MICROFIBRA', 1, 0, 0, 89, '2025-01-09 05:51:13', '2025-01-09 05:51:13', 50, 'metros', 6, 2),
(32, 'MINIMAT', 1, 0, 0, 49, '2025-01-09 05:51:41', '2025-01-09 05:51:41', 50, 'metros', 6, 2),
(33, 'OXFORD 300', 1, 0, 0, 956, '2025-01-09 05:52:07', '2025-01-09 05:52:07', 100, 'metros', 6, 2),
(34, 'OXFORD 420', 1, 0, 0, 600, '2025-01-09 05:52:50', '2025-01-09 05:52:50', 400, 'metros', 6, 2),
(35, 'OXFORT INFLABL', 1, 0, 0, 207, '2025-01-09 05:53:34', '2025-01-09 05:53:34', 50, 'metros', 6, 2),
(36, 'REEBAG', 1, 0, 0, 151.8, '2025-01-09 05:54:00', '2025-01-09 05:54:00', 50, 'metros', 6, 2),
(37, 'GSUPER POLI-02', 1, 0, 0, 43, '2025-01-09 05:55:42', '2025-01-09 05:55:42', 50, 'metros', 6, 2),
(38, 'TAFETA ANTISTATIC', 1, 0, 0, 194, '2025-01-09 05:56:08', '2025-01-09 05:56:08', 50, 'metros', 6, 2),
(39, 'Papel de sublimacion', 1, 0, 0, 2, '2025-01-09 05:57:04', '2025-01-09 05:57:04', 10, 'metros', 7, 3),
(40, 'Papel de proteccion', 1, 0, 0, 2, '2025-01-09 05:57:24', '2025-01-09 05:57:24', 2, 'metros', 7, 3),
(41, 'azul profundo', 1, 0, 0, 2, '2025-01-09 05:59:44', '2025-01-09 05:59:44', 2, 'rollos', 8, 5),
(42, 'rojo intenso', 1, 0, 0, 1, '2025-01-09 06:00:15', '2025-01-09 06:00:15', 2, 'rollos', 8, 5),
(43, 'Verde Bosque', 1, 0, 0, 1, '2025-01-09 06:00:32', '2025-01-09 06:00:32', 2, 'rollos', 8, 5),
(44, 'Vinotinto', 1, 0, 0, 1, '2025-01-09 06:00:50', '2025-01-09 06:00:50', 2, 'rollos', 8, 5),
(45, 'Rosa Barbie', 1, 0, 0, 1, '2025-01-09 06:01:02', '2025-01-09 06:01:02', 2, 'rollos', 8, 5),
(46, 'Aguamarina', 1, 0, 0, 2, '2025-01-09 06:01:17', '2025-01-09 06:01:17', 2, 'rollos', 8, 5),
(47, 'Negro Puro', 1, 0, 0, 1, '2025-01-09 06:01:33', '2025-01-09 06:01:33', 2, 'rollos', 8, 5),
(48, 'blanco', 1, 0, 0, 4, '2025-01-09 06:02:09', '2025-01-09 06:02:09', 2, 'rollos', 9, 6),
(49, 'azul (joya)', 1, 0, 0, 1, '2025-01-09 06:02:21', '2025-01-09 06:02:21', 2, 'rollos', 9, 6),
(50, 'Amarillo Tostado', 1, 0, 0, 2, '2025-01-09 06:02:34', '2025-01-09 06:02:34', 2, 'rollos', 9, 6),
(51, 'Naranja', 1, 0, 0, 1, '2025-01-09 06:03:12', '2025-01-09 06:03:12', 2, 'rollos', 9, 6),
(52, 'Azul Rey', 1, 0, 0, 1, '2025-01-09 06:03:30', '2025-01-09 06:03:30', 2, 'rollos', 9, 6),
(53, 'Negro', 1, 0, 0, 3, '2025-01-09 06:03:43', '2025-01-09 06:03:43', 2, 'rollos', 9, 6),
(54, 'Gris Castor', 1, 0, 0, 2, '2025-01-09 06:03:54', '2025-01-09 06:03:54', 2, 'rollos', 9, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categorias`
--

CREATE TABLE `sub_categorias` (
  `id` int(11) NOT NULL,
  `sub_categoria` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `sub_categorias`
--

INSERT INTO `sub_categorias` (`id`, `sub_categoria`, `status`) VALUES
(1, 'Tinta ECO', 1),
(2, 'Tinta sub - papel', 1),
(3, 'Tinta UV', 1),
(4, 'Sublimacion directa', 1),
(5, 'Sublimacion Mimaki', 1),
(6, 'Tipos de telas', 1),
(7, 'Papel', 1),
(8, 'D Flex', 1),
(9, 'T Flex', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `status`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_sub_categoria`
--
ALTER TABLE `categoria_sub_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_sub_categoria_2` (`id_sub_categoria`),
  ADD KEY `fk_id_categoria_2` (`id_categoria`);

--
-- Indices de la tabla `entradasalidaTotal`
--
ALTER TABLE `entradasalidaTotal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_producto_2` (`id_producto`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_producto_3` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_sub_categoria_1` (`id_sub_categoria`),
  ADD KEY `fk_id_categoria_1` (`id_categoria`);

--
-- Indices de la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categoria_sub_categoria`
--
ALTER TABLE `categoria_sub_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `entradasalidaTotal`
--
ALTER TABLE `entradasalidaTotal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria_sub_categoria`
--
ALTER TABLE `categoria_sub_categoria`
  ADD CONSTRAINT `fk_id_categoria_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_id_sub_categoria_2` FOREIGN KEY (`id_sub_categoria`) REFERENCES `sub_categorias` (`id`);

--
-- Filtros para la tabla `entradasalidaTotal`
--
ALTER TABLE `entradasalidaTotal`
  ADD CONSTRAINT `fk_id_producto_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `fk_id_producto_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_id_categoria_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_id_sub_categoria_1` FOREIGN KEY (`id_sub_categoria`) REFERENCES `sub_categorias` (`id`);
COMMIT;