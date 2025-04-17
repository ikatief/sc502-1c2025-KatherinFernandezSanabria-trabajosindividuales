-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-04-2025 a las 06:24:34
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: apptareas
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tareas
--
-- Creación: 15-04-2025 a las 15:56:31
-- Última actualización: 16-04-2025 a las 22:23:01
--

CREATE TABLE tareas (
  idTask int(11) NOT NULL,
  title varchar(400) NOT NULL,
  description varchar(400) NOT NULL,
  dueDate date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA tareas:
--

--
-- Volcado de datos para la tabla tareas
--

INSERT INTO tareas (idTask, title, description, dueDate) VALUES
(1, 'Programacion', 'Practica 4 programada de php en Ambiente Web Cliente/Servidor', '2025-04-16'),
(2, 'Algebra Lineal', 'Integración de Conocimientos', '2025-04-16'),
(16, 'Administración de Proyectos', 'Entrega final del proyecto y exposición', '2025-04-19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla tareas
--
ALTER TABLE tareas
  ADD PRIMARY KEY (idTask);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla tareas
--
ALTER TABLE tareas
  MODIFY idTask int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
