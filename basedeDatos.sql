-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-11-2023 a las 04:30:57
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prestamos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carteras`
--

CREATE TABLE `carteras` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `IDZona` int NOT NULL,
  `codigoPostal` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--



--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Domicilio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `HistorialCrediticio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ReferenciasPersonales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `MonedaPreferida` int DEFAULT NULL,
  `ZonaAsignada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `IdentificacionCURP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ImagenCliente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT '1',
  `ciudad` int DEFAULT NULL,
  `asentamiento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cartera_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_sistema`
--

CREATE TABLE `configuracion_sistema` (
  `id` int NOT NULL,
  `sistema_activo` tinyint(1) NOT NULL DEFAULT '1',
  `hora_apertura` time NOT NULL DEFAULT '08:00:00',
  `hora_cierre` time NOT NULL DEFAULT '18:00:00',
  `administrador_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int NOT NULL,
  `cliente_id` int DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `monto_deuda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_pago`
--

CREATE TABLE `fechas_pago` (
  `ID` int NOT NULL,
  `IDPrestamo` int DEFAULT NULL,
  `FechaPago` date DEFAULT NULL,
  `EstadoPago` enum('pendiente','pagado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Zona` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `ID` int NOT NULL,
  `IDUsuario` int DEFAULT NULL,
  `IDZona` int DEFAULT NULL,
  `Ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Asentamiento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Valor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_pagos`
--

CREATE TABLE `historial_pagos` (
  `ID` int NOT NULL,
  `IDCliente` int DEFAULT NULL,
  `FechaPago` date DEFAULT NULL,
  `MontoPagado` decimal(10,2) DEFAULT NULL,
  `IDPrestamo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `ID` int NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Simbolo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`ID`, `Nombre`, `Simbolo`) VALUES
(1, 'Pesos_mexicanos', 'MNX'),
(2, 'pesos_colombianos', 'COP'),
(3, 'dolares', 'USD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `ID` int NOT NULL,
  `IDCliente` int DEFAULT NULL,
  `Monto` decimal(10,2) DEFAULT NULL,
  `TasaInteres` decimal(5,2) DEFAULT NULL,
  `Plazo` int DEFAULT NULL,
  `MonedaID` int DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `FechaVencimiento` date DEFAULT NULL,
  `Estado` enum('pendiente','pagado','vencido') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CobradorAsignado` int DEFAULT NULL,
  `Zona` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MontoAPagar` decimal(10,2) DEFAULT NULL,
  `FrecuenciaPago` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MontoCuota` decimal(10,2) DEFAULT NULL,
  `Cuota` decimal(10,2) DEFAULT NULL,
  `Comision` decimal(10,2) DEFAULT '0.00',
  `EstadoP` tinyint(1) DEFAULT '1',
  `Pospuesto` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retiros`
--

CREATE TABLE `retiros` (
  `ID` int NOT NULL,
  `IDUsuario` int NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID` int NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID`, `Nombre`) VALUES
(1, 'admin'),
(2, 'supervisor'),
(3, 'cobrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldo_admin`
--

CREATE TABLE `saldo_admin` (
  `ID` int NOT NULL,
  `IDUsuario` int NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Monto_Neto` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Zona` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `RolID` int DEFAULT NULL,
  `Estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Apellido`, `Email`, `Password`, `Zona`, `RolID`, `Estado`) VALUES
(1, 'Stiven', 'Delgado', 'admin@admin.com', '0123', '2', 1, 'activo'),
(6, 'supervisor', 'super', 'supervisor@super.com', '0123', '20', 2, 'activo'),
(7, 'cobrador', 'cob', 'cobrador@cob.com', '0123', '20', 3, 'activo'),
(8, 'supervisor', 'super', 'supervisor2@super.com', '0123', '6', 2, 'activo'),
(9, 'cobrador', 'cob', 'cobrador2@cob.com', '0123', '6', 3, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Capital` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CobradorAsignado` int DEFAULT NULL,
  `CodigoPostal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`ID`, `Nombre`, `Capital`, `CobradorAsignado`, `CodigoPostal`) VALUES
(1, 'Aguascalientes', 'Aguascalientes', NULL, '20000'),
(2, 'Baja California', 'Mexicali', NULL, '21000'),
(3, 'Baja California Sur', 'La Paz', NULL, '23000'),
(4, 'Campeche', 'San Francisco de Campeche', NULL, '24000'),
(5, 'Chiapas', 'Tuxtla Gutiérrez', NULL, '29000'),
(6, 'Chihuahua', 'Chihuahua', NULL, '31000'),
(7, 'Coahuila', 'Saltillo', NULL, '25000'),
(8, 'Colima', 'Colima', NULL, '28000'),
(9, 'Durango', 'Victoria de Durango', NULL, '34000'),
(10, 'Guanajuato', 'Guanajuato', NULL, '36000'),
(11, 'Guerrero', 'Chilpancingo', NULL, '39000'),
(12, 'Hidalgo', 'Pachuca', NULL, '42000'),
(13, 'Jalisco', 'Guadalajara', NULL, '44100'),
(14, 'Estado de México', 'Toluca', NULL, '50000'),
(15, 'Michoacán', 'Morelia', NULL, '58000'),
(16, 'Morelos', 'Cuernavaca', NULL, '62000'),
(17, 'Nayarit', 'Tepic', NULL, '63000'),
(18, 'Nuevo León', 'Monterrey', NULL, '64000'),
(19, 'Oaxaca', 'Oaxaca de Juárez', NULL, '68000'),
(20, 'Puebla', 'Puebla', NULL, '72000'),
(21, 'Querétaro', 'Santiago de Querétaro', NULL, '76000'),
(22, 'Quintana Roo', 'Chetumal', NULL, '77000'),
(23, 'San Luis Potosí', 'San Luis Potosí', NULL, '78000'),
(24, 'Sinaloa', 'Culiacán', NULL, '80000'),
(25, 'Sonora', 'Hermosillo', NULL, '83000'),
(26, 'Tabasco', 'Villahermosa', NULL, '86000'),
(27, 'Tamaulipas', 'Ciudad Victoria', NULL, '87000'),
(28, 'Tlaxcala', 'Tlaxcala', NULL, '90000'),
(29, 'Veracruz', 'Xalapa', NULL, '91000'),
(30, 'Yucatán', 'Mérida', NULL, '97000'),
(31, 'Zacatecas', 'Zacatecas', NULL, '98000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_cobrador`
--

CREATE TABLE `zona_cobrador` (
  `ID` int NOT NULL,
  `ZonaID` int NOT NULL,
  `CobradorID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carteras`
--
ALTER TABLE `carteras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDZona` (`IDZona`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MonedaPreferida` (`MonedaPreferida`),
  ADD KEY `ZonaAsignada` (`ZonaAsignada`),
  ADD KEY `ciudad` (`ciudad`),
  ADD KEY `fk_cliente_cartera` (`cartera_id`);

--
-- Indices de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrador_id` (`administrador_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `fechas_pago`
--
ALTER TABLE `fechas_pago`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDZona` (`IDZona`);

--
-- Indices de la tabla `historial_pagos`
--
ALTER TABLE `historial_pagos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDCliente` (`IDCliente`),
  ADD KEY `MonedaID` (`MonedaID`),
  ADD KEY `CobradorAsignado` (`CobradorAsignado`),
  ADD KEY `Zona` (`Zona`);

--
-- Indices de la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDUsuario` (`IDUsuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `saldo_admin`
--
ALTER TABLE `saldo_admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `RolID` (`RolID`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nombre` (`Nombre`),
  ADD KEY `CobradorAsignado` (`CobradorAsignado`);

--
-- Indices de la tabla `zona_cobrador`
--
ALTER TABLE `zona_cobrador`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ZonaID` (`ZonaID`),
  ADD KEY `CobradorID` (`CobradorID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carteras`
--
ALTER TABLE `carteras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fechas_pago`
--
ALTER TABLE `fechas_pago`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_pagos`
--
ALTER TABLE `historial_pagos`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `retiros`
--
ALTER TABLE `retiros`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `saldo_admin`
--
ALTER TABLE `saldo_admin`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `zona_cobrador`
--
ALTER TABLE `zona_cobrador`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `ciudades_ibfk_1` FOREIGN KEY (`IDZona`) REFERENCES `zonas` (`ID`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`ZonaAsignada`) REFERENCES `zonas` (`Nombre`),
  ADD CONSTRAINT `clientes_ibfk_3` FOREIGN KEY (`ciudad`) REFERENCES `ciudades` (`ID`),
  ADD CONSTRAINT `fk_cliente_cartera` FOREIGN KEY (`cartera_id`) REFERENCES `carteras` (`id`);

--
-- Filtros para la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  ADD CONSTRAINT `configuracion_sistema_ibfk_1` FOREIGN KEY (`administrador_id`) REFERENCES `usuarios` (`ID`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`ID`);

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`IDZona`) REFERENCES `zonas` (`ID`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`IDCliente`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`MonedaID`) REFERENCES `monedas` (`ID`),
  ADD CONSTRAINT `prestamos_ibfk_3` FOREIGN KEY (`CobradorAsignado`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `prestamos_ibfk_4` FOREIGN KEY (`Zona`) REFERENCES `zonas` (`Nombre`);

--
-- Filtros para la tabla `retiros`
--
ALTER TABLE `retiros`
  ADD CONSTRAINT `retiros_ibfk_1` FOREIGN KEY (`IDUsuario`) REFERENCES `usuarios` (`ID`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`RolID`) REFERENCES `roles` (`ID`);

--
-- Filtros para la tabla `zona_cobrador`
--
ALTER TABLE `zona_cobrador`
  ADD CONSTRAINT `zona_cobrador_ibfk_1` FOREIGN KEY (`ZonaID`) REFERENCES `zonas` (`ID`),
  ADD CONSTRAINT `zona_cobrador_ibfk_2` FOREIGN KEY (`CobradorID`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
