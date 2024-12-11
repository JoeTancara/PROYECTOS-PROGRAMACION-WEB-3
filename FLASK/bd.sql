CREATE DATABASE IF NOT EXISTS automotriz;
USE automotriz;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL
);

CREATE TABLE vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(50) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tiposreparacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE reparaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehiculo_id INT NOT NULL,
    fecha DATE NOT NULL,
    costo DECIMAL(10, 2) NOT NULL,
    descripcion TEXT NOT NULL,
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO clientes (nombre, telefono) VALUES
('Juan Pérez', '123456789'),
('María López', '987654321'),
('Carlos García', '456789123');

INSERT INTO vehiculos (matricula, marca, modelo, cliente_id) VALUES
('ABC123', 'Toyota', 'Corolla', 1),
('DEF456', 'Honda', 'Civic', 2),
('GHI789', 'Ford', 'Focus', 3);

INSERT INTO tiposreparacion (nombre) VALUES
('Cambio de Aceite'),
('Revisión General'),
('Reparación de Frenos');

INSERT INTO reparaciones (vehiculo_id, fecha, costo, descripcion) VALUES
(1, '2024-12-01', 150.00, 'Cambio de aceite y filtro'),
(2, '2024-12-05', 300.00, 'Revisión general y cambio de pastillas de freno'),
(3, '2024-12-10', 200.00, 'Reparación del sistema de frenos');
