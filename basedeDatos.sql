-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-10-2023 a las 19:39:08
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
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Domicilio` varchar(255) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `HistorialCrediticio` text,
  `ReferenciasPersonales` text,
  `MonedaPreferida` int DEFAULT NULL,
  `ZonaAsignada` varchar(255) DEFAULT NULL,
  `IdentificacionCURP` varchar(255) DEFAULT NULL,
  `ImagenCliente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID`, `Nombre`, `Apellido`, `Domicilio`, `Telefono`, `HistorialCrediticio`, `ReferenciasPersonales`, `MonedaPreferida`, `ZonaAsignada`, `IdentificacionCURP`, `ImagenCliente`) VALUES
(1, 'Juan', 'Pérez', 'Calle #123', '(123) 456-7890', 'bueno', 'bien', 1, 'Coahuila', 'ABCD123456EFGHJKL', '../public/assets/img/imgclient/imgclientperfil1.png'),
(2, 'Ana', 'García', 'Avenida #456', '(789) 123-4567', 'bueno', 'bien', 3, 'Oaxaca', 'WXYZ987654ABCD1234', '../public/assets/img/imgclient/imgclientperfil2.png'),
(3, 'Carlos', 'Rodríguez', 'Calle #873', ' (456) 789-0123', 'bueno', 'bien', 1, 'Michoacán', 'LMNO5678PQRS9012T', '../public/assets/img/imgclient/imgclientperfil3.png'),
(4, 'Laura', 'Martínez', 'Camino #101', '(321) 654-9870', 'buenooo', 'bienn', 2, 'Durango', 'UVWX123456YZAB789C', '../public/assets/img/imgclient/imgclientperfil4.png'),
(5, 'kevin', 'alvarez', 'Avenida #451', '(123) 456-7890', 'biennn', 'stiven delgado', 2, 'Durango', 'WXYZ987654ABCD1234', '../public/assets/img/imgclient/imgclientperfil1.png'),
(7, 'samuel', 'Duarte', 'cr43 cl32', '(123) 456-7890', 'malo', 'nadie confia en el', 2, 'Colima', 'WXYZ987654ABCD1234', '../public/assets/img/imgclient/imgclientperfil2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `ID` int NOT NULL,
  `IDZona` int DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`ID`, `IDZona`, `Fecha`, `Descripcion`, `Valor`) VALUES
(1, 29, '2023-10-04', 'Comida', 15000.00),
(2, 5, '1970-01-01', 'transporte', 20000.00),
(3, 8, '2023-09-10', 'transporte', 10000.00),
(4, 15, '2023-04-10', 'comida', 5000.00),
(5, 20, '2023-04-10', 'Comida2', 15000.00),
(6, 19, '2023-05-10', 'comida', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_pagos`
--

CREATE TABLE `historial_pagos` (
  `ID` int NOT NULL,
  `IDCliente` int DEFAULT NULL,
  `FechaPago` date DEFAULT NULL,
  `MontoPagado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `ID` int NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Simbolo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `Estado` enum('pendiente','pagado','vencido') DEFAULT NULL,
  `CobradorAsignado` int DEFAULT NULL,
  `Zona` varchar(255) DEFAULT NULL,
  `MontoAPagar` decimal(10,2) DEFAULT NULL,
  `FrecuenciaPago` varchar(20) DEFAULT NULL,
  `MontoCuota` decimal(10,2) DEFAULT NULL,
  `Cuota` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`ID`, `IDCliente`, `Monto`, `TasaInteres`, `Plazo`, `MonedaID`, `FechaInicio`, `FechaVencimiento`, `Estado`, `CobradorAsignado`, `Zona`, `MontoAPagar`, `FrecuenciaPago`, `MontoCuota`, `Cuota`) VALUES
(1, 1, 10000.00, 20.00, 20, 1, '2023-10-04', '2024-02-21', 'pendiente', NULL, 'Colima', 12000.00, 'semanal', 600.00, 600.00),
(2, 2, 1000.00, 20.00, 20, 1, '2023-10-04', '2024-07-30', 'pendiente', NULL, 'Oaxaca', 1200.00, 'quincenal', 60.00, 60.00),
(3, 3, 3000.00, 25.00, 30, 3, '2023-10-04', '2026-04-04', 'pendiente', NULL, 'Estado de México', 3750.00, 'mensual', 125.00, 125.00),
(4, 4, 2000000.00, 20.00, 20, 2, '2023-10-04', '2024-07-30', 'pendiente', NULL, 'Chihuahua', 2400000.00, 'quincenal', 120000.00, 120000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID` int NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID`, `Nombre`) VALUES
(1, 'admin'),
(2, 'supervisor'),
(3, 'cobrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Zona` varchar(255) DEFAULT NULL,
  `RolID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Apellido`, `Email`, `Password`, `Zona`, `RolID`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$KUgTKdmckTNWlVdemdO21umorBtl5w0u/6odNECG3HkU/cmpOGaDm', '2', 1),
(3, 'supervisor', 'super', 'supervisor@super.com', '$2y$10$zCfeEzy.qgTo3qKoOMQjNOj2NMSfK/ScgB6Fux.q1MI1xGXqVO9Ty', '10', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Capital` varchar(255) DEFAULT NULL,
  `CobradorAsignado` int DEFAULT NULL,
  `CodigoPostal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MonedaPreferida` (`MonedaPreferida`),
  ADD KEY `ZonaAsignada` (`ZonaAsignada`);

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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
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
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `zona_cobrador`
--
ALTER TABLE `zona_cobrador`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`ZonaAsignada`) REFERENCES `zonas` (`Nombre`);

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
