-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2023 at 09:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universidad`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `clase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `email`, `clase_id`) VALUES
(1, 'Luis Rodríguez', 'luis@example.com', 3),
(2, 'Laura Gómez', 'laura@example.com', 2),
(3, 'Carlos Sánchez', 'carlos@example.com', 3),
(4, 'María Ramírez', 'maria@example.com', 4);

-- --------------------------------------------------------

--
-- Table structure for table `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `clase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clases`
--

INSERT INTO `clases` (`id`, `nombre`) VALUES
(1, 'Matemáticas 101'),
(2, 'Historia del Arte'),
(3, 'Programación en C++'),
(4, 'Economía 201');

-- --------------------------------------------------------

--
-- Table structure for table `maestros`
--

CREATE TABLE `maestros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `clase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maestros`
--

INSERT INTO `maestros` (`id`, `nombre`, `email`, `clase_id`) VALUES
(1, 'Juan Pérez', 'juan@example.com', 1),
(2, 'María López', 'maria@example.com', 2),
(3, 'Carlos González', 'carlos@example.com', 3),
(4, 'John Smith', 'smith@example.com', 4),
(5, 'Roman Franco', 'roman@example.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','maestro','alumno') NOT NULL,
  `habilitado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `habilitado`) VALUES
(1, 'Administrador', 'admin@admin.com', '$2y$10$HPxd2sHYByl8KlUaQlqCiuZy9ejAYSwGERZz.RgdGnZbZSrqIgYsO', 'admin', 1),
(2, 'Juan Pérez', 'juan@example.com', '$2y$10$wV5l1TL40xzSTnac1fxdVe/69Z826ctjE3RAOJC1OqvJRZsrc0iIa', 'maestro', 1),
(3, 'María López', 'maria@example.com', '$2y$10$FKwOaK37AvJqbVs6K/Q4bu7lw6kmv8s8xQBWa9Ol5t69TsZryIhFu', 'maestro', 1),
(4, 'Carlos González', 'carlos@example.com', '$2y$10$OTLjoWkV9x5ibGW7j9aZxuk9ITlUas3MeQVG2nMmvC4Eri5t.EHOy', 'maestro', 1),
(5, 'Luis Rodríguez', 'luis@example.com', '$2y$10$RrxcErK63LPmb.zyFFpjaeb2oKjRdHjLlbGcTRgdSJYXro4ywhVUS', 'alumno', 1),
(6, 'Laura Gómez', 'laura@example.com', '$2y$10$K0JqHvLRysNDgJskd7U34OI5XA5UCHW/WuyypTSUZqq9Noha3fIC6', 'alumno', 1),
(7, 'Carlos Sánchez', 'carlos@example.com', '$2y$10$3WptiJrOjotvfTEf0NqT1u3dJyxVVVIo49y/2V9YK8XR9bD7X4h1e', 'alumno', 1),
(11, 'Roman Franco', 'roman@example.com', '$2y$10$Myv.5FVYHmpGP41iximjVOK8EP/PiFjp1V7LX./nwIAytLk5Jonly', 'maestro', 1),
(12, 'John Smith', 'smith@example.com', '$2y$10$3xGLADl/br/HHwHvGbaLterNzNlmefTmN3ks8K6CZBZBI0D3obUDi', 'alumno', 1),
(13, 'Jack Bauer', 'jack@ctu.com', '$2y$10$zP/VcW6g3/R7shEA9Nqw3.i/sYvnyHkmXFlk3xAGwzd0RVc.KaBXi', 'alumno', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clase_id` (`clase_id`);

--
-- Indexes for table `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `clase_id` (`clase_id`);

--
-- Indexes for table `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maestros`
--
ALTER TABLE `maestros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clase_id` (`clase_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `maestros`
--
ALTER TABLE `maestros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`);

--
-- Constraints for table `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`);

--
-- Constraints for table `maestros`
--
ALTER TABLE `maestros`
  ADD CONSTRAINT `maestros_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
