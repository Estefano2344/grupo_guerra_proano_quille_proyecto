-- 1. Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS `las_huequitas`;

-- 2. Seleccionar la base de datos
USE `las_huequitas`;

-- 3. Crear la tabla de reseñas
CREATE TABLE IF NOT EXISTS `resenas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `restaurante` VARCHAR(255) NOT NULL,
  `resena` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);
