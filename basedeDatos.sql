

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




CREATE TABLE `gastos` (
  `ID` int NOT NULL,
  `IDZona` int DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;





CREATE TABLE `historial_pagos` (
  `ID` int NOT NULL,
  `IDCliente` int DEFAULT NULL,
  `FechaPago` date DEFAULT NULL,
  `MontoPagado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




-- --------------------------------------------------------

CREATE TABLE `monedas` (
  `ID` int NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Simbolo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `monedas` (`ID`, `Nombre`, `Simbolo`) VALUES
(1, 'MNX', 'MNX'),
(2, 'COP', 'COP'),
(3, 'USD', 'USD');


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



CREATE TABLE `retiros` (
  `ID` int NOT NULL,
  `IDZona` int NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



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
  `ID` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Zona` varchar(255) DEFAULT NULL,
  `Rol` enum('admin', 'supervisor', 'cobrador') DEFAULT 'cobrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `zonas` (
  `ID` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Capital` varchar(255) DEFAULT NULL,
  `CobradorAsignado` int DEFAULT NULL,
  `CodigoPostal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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



