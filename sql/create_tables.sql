-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS curso_idiomas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE curso_idiomas;

-- Tabla para las clases
CREATE TABLE IF NOT EXISTS clases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ponderacion TINYINT NOT NULL CHECK (ponderacion BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre)
) ENGINE=InnoDB;

-- Tabla para los exámenes
CREATE TABLE IF NOT EXISTS examenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('seleccion', 'pregunta_respuesta', 'completacion') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre)
) ENGINE=InnoDB;

-- Datos de ejemplo para clases
INSERT INTO clases (nombre, ponderacion) VALUES
('Vocabulario sobre Trabajo en Inglés', 5),
('Conversaciones de Trabajo en Inglés', 5),
('Gramática Avanzada para Trabajo', 4),
('Frases comunes en el Trabajo', 3),
('Vocabulario Básico de Francés', 4),
('Conversación Básica en Alemán', 3),
('Palabras Esenciales en Italiano', 4),
('Trabajos y profesiones en Japonés', 5);

-- Datos de ejemplo para exámenes
INSERT INTO examenes (nombre, tipo) VALUES
('Trabajos y ocupaciones en Inglés', 'seleccion'),
('Trabajo y Vocabulario Comercial', 'pregunta_respuesta'),
('Conversación de Trabajo Avanzado', 'completacion'),
('Prueba de Nivel de Trabajo', 'seleccion'),
('Vocabulario Básico de Alemán', 'seleccion'),
('Frases de Trabajo en Francés', 'pregunta_respuesta'),
('Examen Final de Trabajo Chino', 'completacion'),
('Vocabulario de Trabajo en Español', 'seleccion');