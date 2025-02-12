-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 09:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Belum Selesai','Selesai') DEFAULT 'Belum Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `task_id`, `name`, `status`) VALUES
(9, 19, 'db siswa', 'Selesai'),
(14, 19, 'r', 'Selesai'),
(25, 20, 'mtk', 'Belum Selesai'),
(26, 19, 'table user', 'Selesai'),
(28, 22, 'b', 'Selesai'),
(29, 22, 'c', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Belum Selesai','Selesai') COLLATE utf8mb4_general_ci DEFAULT 'Belum Selesai',
  `priority` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `status`, `priority`, `deadline`, `created_at`) VALUES
(19, 'membuat database', 'Selesai', 'Rendah', '2025-02-15', '2025-02-07 05:46:34'),
(20, 'pr', 'Belum Selesai', 'Medium', '2025-02-14', '2025-02-07 07:17:26'),
(22, 'a', 'Selesai', 'Medium', '2025-02-08', '2025-02-08 09:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, '2', '$2y$10$mn.oglYtgdLqX06.w6cwAewrZBn.CXP9gUbqJejFn.O7G6K7gQBIG'),
(2, 'ririnn', '$2y$10$CFRJctQ1ZswQeLMPXUxhf.jCBl7m2sOD0ddAHCgP8av7pM4NuUkTy'),
(3, 'rrin', '$2y$10$EgqatXw0pcJ5XwxXNzmEeOa9qy6lqynJ3hol9Uf4urrtpwbvbHW9G'),
(5, '3', '$2y$10$0oV0tL8g2ZLoCy.C5yuxtueH3XViCl0ni0inidaONMA/amMN9PpTK'),
(10, 'titi', '$2y$10$hgLP709DBttrMiM3OwL4L.vxVaAxpRX/6ZimJaJXlCFghiRSi64Fy'),
(11, 'ririn', '$2y$10$2z3puyizMxswjd4WuTDfMubRd/S7UseEwq6/1MsJXHIV0qCrVKDW2'),
(12, '1', '$2y$10$IoEO7m8.Aladuuo.SBJXwuWBWLT.kbvPuZeoL.WxS/4EhMwbTrrl2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
