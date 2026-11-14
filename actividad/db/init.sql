SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS visitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO visitas (fecha) VALUES (NOW());

CREATE TABLE IF NOT EXISTS estudiantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  programa VARCHAR(100) NOT NULL
);
INSERT INTO estudiantes (nombre, programa) VALUES
  ('Camilo Rodríguez', 'Ingeniería de Sistemas'),
  ('Ana Pérez', 'Ingeniería de Sistemas'),
  ('Luis Gómez', 'Ingeniería Industrial');
