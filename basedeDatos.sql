-- Crear la base de datos prestamos
CREATE DATABASE IF NOT EXISTS prestamos;

-- Seleccionar la base de datos
USE prestamos;

-- Crear la tabla de Roles
CREATE TABLE IF NOT EXISTS Roles (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50)
);

-- Insertar roles disponibles
INSERT INTO Roles (Nombre) VALUES ('admin');
INSERT INTO Roles (Nombre) VALUES ('supervisor');
INSERT INTO Roles (Nombre) VALUES ('cobrador');

-- Crear la tabla de Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Apellido VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Password VARCHAR(255),
    Zona VARCHAR(255),
    MonedaPreferida VARCHAR(50),
    RolID INT,
    FOREIGN KEY (RolID) REFERENCES Roles(ID)
);

-- Crear la tabla de Monedas sin la columna de TasaCambio
CREATE TABLE IF NOT EXISTS Monedas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) UNIQUE,
    Simbolo VARCHAR(10)
);

-- Insertar datos en la tabla Monedas
INSERT INTO Monedas (Nombre, Simbolo) VALUES
('pesos_colombianos', 'COP'),
('pesos_mexicanos', 'MXN'),
('dolares', 'USD');

-- Crear la tabla de Clientes (anteriormente Prestatarios)
CREATE TABLE IF NOT EXISTS Clientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Apellido VARCHAR(255),
    Direccion VARCHAR(255),
    Telefono VARCHAR(20),
    HistorialCrediticio TEXT,
    ReferenciasPersonales TEXT
);

-- Crear la tabla de Zonas
CREATE TABLE IF NOT EXISTS Zonas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Descripcion TEXT,
    CobradorAsignado INT,
    FOREIGN KEY (CobradorAsignado) REFERENCES Usuarios(ID)
);

-- Crear la tabla de Prestamos
CREATE TABLE IF NOT EXISTS Prestamos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    IDCliente INT,
    Monto DECIMAL(10, 2),
    TasaInteres DECIMAL(5, 2),
    Plazo INT,
    MonedaID INT,
    FechaInicio DATE,
    FechaVencimiento DATE,
    Estado ENUM('pendiente', 'pagado', 'vencido'),
    CobradorAsignado INT,
    Zona VARCHAR(255),
    FOREIGN KEY (IDCliente) REFERENCES Clientes(ID),
    FOREIGN KEY (MonedaID) REFERENCES Monedas(ID),
    FOREIGN KEY (CobradorAsignado) REFERENCES Usuarios(ID),
    FOREIGN KEY (Zona) REFERENCES Zonas(Nombre)
);






