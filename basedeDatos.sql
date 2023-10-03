-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-10-2023 a las 21:33:58
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
(1, 'juan', 'bohorquez', 'calle20e', '304044', NULL, NULL, 3, 'Bello', NULL, NULL);

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
(1, 1, 200.00, 12.00, 1201, 1, '2023-09-30', '2027-01-13', 'pendiente', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 200.00, 12.00, 30, 3, '2023-09-30', '2023-10-30', 'pendiente', NULL, 'Bello', NULL, NULL, NULL, NULL),
(3, 1, 200.00, 12.00, 30, 3, '2023-09-30', '2023-10-30', 'pendiente', NULL, 'Bello', 224.00, NULL, NULL, NULL),
(4, 1, 120.00, 5.00, 300, 3, '2023-09-30', '2029-06-30', 'pendiente', NULL, 'Bello', 126.00, NULL, NULL, NULL),
(5, 1, 120.00, 5.00, 60, 2, '2023-09-30', '2028-09-30', 'pendiente', NULL, 'Bello', 126.00, NULL, NULL, NULL),
(6, 1, 10000.00, 0.10, 20, 1, '2023-09-30', '2023-10-20', 'pendiente', NULL, 'Bello', 10010.00, NULL, NULL, NULL),
(7, 1, 10000.00, 20.00, 20, 1, '2023-09-30', '2024-02-17', 'pendiente', NULL, 'Bello', 12000.00, 'semanal', NULL, NULL),
(8, 1, 10000.00, 20.00, 20, 2, '2023-09-30', '2024-07-26', 'pendiente', NULL, 'Bello', 12000.00, 'quincenal', 600.00, 600.00),
(9, 1, 10000.00, 20.00, 20, 2, '2023-09-30', '2025-05-30', 'pendiente', NULL, 'Bello', 12000.00, 'mensual', 600.00, 600.00);

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
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$XDfoiP2yTk9W9kk7nIlsuu6mFXrqjnAKwXMQO5X/M5awNqX1bM19W', '1', 1),
(5, 'juan', 'restrepo', 'supervisor@supervisor.com', '$2y$10$DzrGFhvSqM6Vy63VdYQg3Osrl3JqWYYc7JwBckxj0L0VwkYQPgIOy', '1', 2),
(6, 'juan', 'restrepo', 'cobrador@cob.com', '$2y$10$7ewe67fdgGyK2ms8KMtmkOTtI2E5tnkzDZj8IPmw0brUsOPLCz4Bi', '1', 1),
(10, 'Stiven', 'delgado', 'admin@aa.com', '$2y$10$pK3NLiesn9zhjyAcfDbHreO90IKP7yLAwToyuJ47m/e.R.bGFLmRu', '1', 1),
(12, 'juan', 'aaaa', 'admin@kkiok.com', '$2y$10$rAS6uwe0ga8uQ.YW5NmBqeJjojYvI38MTNIsAL0BMYHItZmJCa5au', '1', 1),
(13, 'juan', 'aaaa', 'admin@kkkkkiok.com', '$2y$10$jRxcIsGGlS1rgjSdt9zAP.y/q152kw/hUIyCcqbXLBW6UBCX0W60.', '1', 1),
(14, 'juan', 'aaaa', 'admllin@kkkkkiok.com', '$2y$10$7ZgBmfH4qRWdlxnQ2FJFE.cC6ab7H3ZMf7ULwyt/YsFgQ19ei0/4e', '1', 1),
(15, 'juan', 'aaaa', 'admllllin@kkkkkiok.com', '$2y$10$ZeHsRpcZlEw2TMCa3xXSyOVVEc77PUwsBDH49wgljcZ1PvKnTwtou', '1', 1),
(16, 'juan', 'aaaa', 'lllllll@kkkkkiok.com', '$2y$10$DBsmseJgr7T0ciGDPmLlGuuA9nbV0HB4UtoB.YVQhDZ.GyIPzae5G', '1', 1),
(17, 'juan', 'aaaa', 'llllllhhl@kkkkkiok.com', '$2y$10$CAGfnGbTFlbEY07rD18e/u5yq6rfRUpDYH1ZkonVzm/.uEQ7X4lB6', '1', 1),
(18, 'juan', 'aaaa', 'lllllhhhlhhl@kkkkkiok.com', '$2y$10$7LRtHWCsgj3FrVD5S75hSutFsmxF4KrE1OegmfI4hXLbUR0TOGDYi', '1', 1),
(19, 'juan', 'aaaa', 'llllhhhlhhhlhhl@kkkkkiok.com', '$2y$10$ayIuXrgFi1wgTA.f4I8vOuYazDHbdiC73Oz2MB3Yx50ZKVNWv7hbK', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Descripcion` text,
  `CobradorAsignado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`ID`, `Nombre`, `Descripcion`, `CobradorAsignado`) VALUES
(1, 'Bello', 'q', NULL),
(2, 'Medellin', 'a', 6);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`ZonaAsignada`) REFERENCES `zonas` (`Nombre`);

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
-- Filtros para la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD CONSTRAINT `zonas_ibfk_1` FOREIGN KEY (`CobradorAsignado`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
