DROP DATABASE IF EXISTS segec;
CREATE DATABASE segec;
USE segec;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('enfermeria','paciente') NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (usuario, password, rol) VALUES
('enfermeria01', 'segecmaster', 'enfermeria'),
('paciente01', 'segec01', 'paciente');

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cedula VARCHAR(50) NOT NULL,
    genero VARCHAR(20),
    edad INT,
    tipo_sangre VARCHAR(5),
    especialidad VARCHAR(50),
    telefono VARCHAR(50),
    correo VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    especialidad VARCHAR(50) NOT NULL,
    motivo VARCHAR(255),
    correo_paciente VARCHAR(100),
    creado_por VARCHAR(50) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE glucosa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(50) NOT NULL,
    lectura INT NOT NULL,
    momento ENUM('Ayunas','Antes de comer','2h después') NOT NULL,
    estado ENUM('Normal','Hipoglucemia','Prediabetes','Hiperglucemia') NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

