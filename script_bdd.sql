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

-- Crear la tabla de anuncios
CREATE TABLE IF NOT EXISTS `anuncios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `restaurante` VARCHAR(255) NOT NULL,
    `anuncio` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de usuarios para manejar el registro y login
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Agregar columna `user_id` a las tablas existentes para asociar usuarios con reseñas/anuncios
ALTER TABLE resenas ADD COLUMN user_id INT NOT NULL AFTER id;
ALTER TABLE anuncios ADD COLUMN user_id INT NOT NULL AFTER id;