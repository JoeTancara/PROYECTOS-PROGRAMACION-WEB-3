create database sis_asistencia;


CREATE TABLE empleados (
  id_empleado INT AUTO_INCREMENT PRIMARY KEY,  
  nombre VARCHAR(255),                         
  cargo VARCHAR(255),                         
  fecha_ingreso DATE                           
);

CREATE TABLE asistencias (
  id_asistencia INT AUTO_INCREMENT PRIMARY KEY,  
  id_empleado INT,                             
  fecha DATE,                                   
  estado VARCHAR(50),                          
  FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);


INSERT INTO empleados (nombre, cargo, fecha_ingreso) VALUES
('Juan Pérez', 'Gerente', '2020-03-15'),
('Ana García', 'Administrativa', '2019-08-20'),
('Carlos Martínez', 'Vendedor', '2021-05-10'),
('Laura López', 'Contadora', '2018-11-01'),
('Pedro Díaz', 'Desarrollador', '2022-07-23'),
('María Rodríguez', 'Recursos Humanos', '2020-01-05'),
('José Sánchez', 'Marketing', '2017-06-30'),
('Sofía Romero', 'Soporte Técnico', '2021-09-14'),
('Luis Fernández', 'Director', '2015-02-25'),
('Raquel Ruiz', 'Diseñadora', '2023-03-01');


INSERT INTO asistencias (id_empleado, fecha, estado) VALUES
(1, '2023-11-01', 'Presente'),
(2, '2023-11-01', 'Ausente'),
(3, '2023-11-01', 'Presente'),
(4, '2023-11-01', 'Presente'),
(5, '2023-11-01', 'Presente'),
(6, '2023-11-01', 'Ausente'),
(7, '2023-11-01', 'Presente'),
(8, '2023-11-01', 'Presente'),
(9, '2023-11-01', 'Presente'),
(10, '2023-11-01', 'Ausente'),

(1, '2023-11-02', 'Presente'),
(2, '2023-11-02', 'Presente'),
(3, '2023-11-02', 'Presente'),
(4, '2023-11-02', 'Ausente'),
(5, '2023-11-02', 'Presente'),
(6, '2023-11-02', 'Presente'),
(7, '2023-11-02', 'Presente'),
(8, '2023-11-02', 'Presente'),
(9, '2023-11-02', 'Presente'),
(10, '2023-11-02', 'Presente');