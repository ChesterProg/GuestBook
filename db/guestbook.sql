-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Sep 10, 2024 at 07:46 PM
-- Server version: 5.7.40
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240909094307', '2024-09-10 19:04:16', 61),
('DoctrineMigrations\\Version20240909095530', '2024-09-10 19:04:17', 19),
('DoctrineMigrations\\Version20240909100855', '2024-09-10 19:04:17', 15);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `homepage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `email`, `text`, `homepage`, `image_path`, `status`, `created_at`, `user_agent`, `user_id`) VALUES
(1, 'User #1', 'test@mail.com1', 'Тестове повідомлення номер 1', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:35:31', NULL, NULL),
(2, 'User #2', 'test@mail.com2', 'Тестове повідомлення номер 2', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:36:31', NULL, NULL),
(3, 'User #3', 'test@mail.com3', 'Тестове повідомлення номер 3', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:37:31', NULL, NULL),
(4, 'User #4', 'test@mail.com4', 'Тестове повідомлення номер 4', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:38:31', NULL, NULL),
(5, 'User #5', 'test@mail.com5', 'Тестове повідомлення номер 5', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:39:31', NULL, NULL),
(6, 'User #6', 'test@mail.com6', 'Тестове повідомлення номер 6', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:40:31', NULL, NULL),
(7, 'User #7', 'test@mail.com7', 'Тестове повідомлення номер 7', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:41:31', NULL, NULL),
(8, 'User #8', 'test@mail.com8', 'Тестове повідомлення номер 8', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:42:31', NULL, NULL),
(9, 'User #9', 'test@mail.com9', 'Тестове повідомлення номер 9', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:43:31', NULL, NULL),
(10, 'User #10', 'test@mail.com10', 'Тестове повідомлення номер 10', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:44:31', NULL, NULL),
(11, 'User #11', 'test@mail.com11', 'Тестове повідомлення номер 11', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:45:31', NULL, NULL),
(12, 'User #12', 'test@mail.com12', 'Тестове повідомлення номер 12', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:46:31', NULL, NULL),
(13, 'User #13', 'test@mail.com13', 'Тестове повідомлення номер 13', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:47:31', NULL, NULL),
(14, 'User #14', 'test@mail.com14', 'Тестове повідомлення номер 14', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:48:31', NULL, NULL),
(15, 'User #15', 'test@mail.com15', 'Тестове повідомлення номер 15', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:49:31', NULL, NULL),
(16, 'User #16', 'test@mail.com16', 'Тестове повідомлення номер 16', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:50:31', NULL, NULL),
(17, 'User #17', 'test@mail.com17', 'Тестове повідомлення номер 17', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:51:31', NULL, NULL),
(18, 'User #18', 'test@mail.com18', 'Тестове повідомлення номер 18', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:52:31', NULL, NULL),
(19, 'User #19', 'test@mail.com19', 'Тестове повідомлення номер 19', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:53:31', NULL, NULL),
(20, 'User #20', 'test@mail.com20', 'Тестове повідомлення номер 20', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:54:31', NULL, NULL),
(21, 'User #21', 'test@mail.com21', 'Тестове повідомлення номер 21', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:55:31', NULL, NULL),
(22, 'User #22', 'test@mail.com22', 'Тестове повідомлення номер 22', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:56:31', NULL, NULL),
(23, 'User #23', 'test@mail.com23', 'Тестове повідомлення номер 23', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:57:31', NULL, NULL),
(24, 'User #24', 'test@mail.com24', 'Тестове повідомлення номер 24', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:58:31', NULL, NULL),
(25, 'User #25', 'test@mail.com25', 'Тестове повідомлення номер 25', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:59:31', NULL, NULL),
(26, 'User #26', 'test@mail.com26', 'Тестове повідомлення номер 26', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:00:31', NULL, NULL),
(27, 'User #27', 'test@mail.com27', 'Тестове повідомлення номер 27', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:01:31', NULL, NULL),
(28, 'User #28', 'test@mail.com28', 'Тестове повідомлення номер 28', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:02:31', NULL, NULL),
(29, 'User #29', 'test@mail.com29', 'Тестове повідомлення номер 29', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:03:31', NULL, NULL),
(30, 'User #30', 'test@mail.com30', 'Тестове повідомлення номер 30', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:04:31', NULL, NULL),
(31, 'User #31', 'test@mail.com31', 'Тестове повідомлення номер 31', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:05:31', NULL, NULL),
(32, 'User #32', 'test@mail.com32', 'Тестове повідомлення номер 32', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:06:31', NULL, NULL),
(33, 'User #33', 'test@mail.com33', 'Тестове повідомлення номер 33', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:07:31', NULL, NULL),
(34, 'User #34', 'test@mail.com34', 'Тестове повідомлення номер 34', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:08:31', NULL, NULL),
(35, 'User #35', 'test@mail.com35', 'Тестове повідомлення номер 35', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:09:31', NULL, NULL),
(36, 'User #36', 'test@mail.com36', 'Тестове повідомлення номер 36', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:10:31', NULL, NULL),
(37, 'User #37', 'test@mail.com37', 'Тестове повідомлення номер 37', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:11:31', NULL, NULL),
(38, 'User #38', 'test@mail.com38', 'Тестове повідомлення номер 38', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:12:31', NULL, NULL),
(39, 'User #39', 'test@mail.com39', 'Тестове повідомлення номер 39', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:13:31', NULL, NULL),
(40, 'User #40', 'test@mail.com40', 'Тестове повідомлення номер 40', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:14:31', NULL, NULL),
(41, 'User #41', 'test@mail.com41', 'Тестове повідомлення номер 41', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:15:31', NULL, NULL),
(42, 'User #42', 'test@mail.com42', 'Тестове повідомлення номер 42', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:16:31', NULL, NULL),
(43, 'User #43', 'test@mail.com43', 'Тестове повідомлення номер 43', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:17:31', NULL, NULL),
(44, 'User #44', 'test@mail.com44', 'Тестове повідомлення номер 44', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:18:31', NULL, NULL),
(45, 'User #45', 'test@mail.com45', 'Тестове повідомлення номер 45', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:19:31', NULL, NULL),
(46, 'User #46', 'test@mail.com46', 'Тестове повідомлення номер 46', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:20:31', NULL, NULL),
(47, 'User #47', 'test@mail.com47', 'Тестове повідомлення номер 47', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:21:31', NULL, NULL),
(48, 'User #48', 'test@mail.com48', 'Тестове повідомлення номер 48', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:22:31', NULL, NULL),
(49, 'User #49', 'test@mail.com49', 'Тестове повідомлення номер 49', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:23:31', NULL, NULL),
(50, 'User #50', 'test@mail.com50', 'Тестове повідомлення номер 50', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:24:31', NULL, NULL),
(51, 'User #1', 'test@mail.com1', 'Тестове повідомлення номер 1', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:40:11', NULL, NULL),
(52, 'User #2', 'test@mail.com2', 'Тестове повідомлення номер 2', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:41:11', NULL, NULL),
(53, 'User #3', 'test@mail.com3', 'Тестове повідомлення номер 3', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:42:11', NULL, NULL),
(54, 'User #4', 'test@mail.com4', 'Тестове повідомлення номер 4', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:43:11', NULL, NULL),
(55, 'User #5', 'test@mail.com5', 'Тестове повідомлення номер 5', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:44:11', NULL, NULL),
(56, 'User #6', 'test@mail.com6', 'Тестове повідомлення номер 6', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:45:11', NULL, NULL),
(57, 'User #7', 'test@mail.com7', 'Тестове повідомлення номер 7', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:46:11', NULL, NULL),
(58, 'User #8', 'test@mail.com8', 'Тестове повідомлення номер 8', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:47:11', NULL, NULL),
(59, 'User #9', 'test@mail.com9', 'Тестове повідомлення номер 9', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:48:11', NULL, NULL),
(60, 'User #10', 'test@mail.com10', 'Тестове повідомлення номер 10', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:49:11', NULL, NULL),
(61, 'User #11', 'test@mail.com11', 'Тестове повідомлення номер 11', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:50:11', NULL, NULL),
(62, 'User #12', 'test@mail.com12', 'Тестове повідомлення номер 12', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:51:11', NULL, NULL),
(63, 'User #13', 'test@mail.com13', 'Тестове повідомлення номер 13', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:52:11', NULL, NULL),
(64, 'User #14', 'test@mail.com14', 'Тестове повідомлення номер 14', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:53:11', NULL, NULL),
(65, 'User #15', 'test@mail.com15', 'Тестове повідомлення номер 15', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:54:11', NULL, NULL),
(66, 'User #16', 'test@mail.com16', 'Тестове повідомлення номер 16', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:55:11', NULL, NULL),
(67, 'User #17', 'test@mail.com17', 'Тестове повідомлення номер 17', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:56:11', NULL, NULL),
(68, 'User #18', 'test@mail.com18', 'Тестове повідомлення номер 18', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:57:11', NULL, NULL),
(69, 'User #19', 'test@mail.com19', 'Тестове повідомлення номер 19', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:58:11', NULL, NULL),
(70, 'User #20', 'test@mail.com20', 'Тестове повідомлення номер 20', NULL, '/uploads/images/test.png', 1, '2024-09-10 19:59:11', NULL, NULL),
(71, 'User #21', 'test@mail.com21', 'Тестове повідомлення номер 21', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:00:11', NULL, NULL),
(72, 'User #22', 'test@mail.com22', 'Тестове повідомлення номер 22', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:01:11', NULL, NULL),
(73, 'User #23', 'test@mail.com23', 'Тестове повідомлення номер 23', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:02:11', NULL, NULL),
(74, 'User #24', 'test@mail.com24', 'Тестове повідомлення номер 24', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:03:11', NULL, NULL),
(75, 'User #25', 'test@mail.com25', 'Тестове повідомлення номер 25', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:04:11', NULL, NULL),
(76, 'User #26', 'test@mail.com26', 'Тестове повідомлення номер 26', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:05:11', NULL, NULL),
(77, 'User #27', 'test@mail.com27', 'Тестове повідомлення номер 27', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:06:11', NULL, NULL),
(78, 'User #28', 'test@mail.com28', 'Тестове повідомлення номер 28', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:07:11', NULL, NULL),
(79, 'User #29', 'test@mail.com29', 'Тестове повідомлення номер 29', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:08:11', NULL, NULL),
(80, 'User #30', 'test@mail.com30', 'Тестове повідомлення номер 30', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:09:11', NULL, NULL),
(81, 'User #31', 'test@mail.com31', 'Тестове повідомлення номер 31', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:10:11', NULL, NULL),
(82, 'User #32', 'test@mail.com32', 'Тестове повідомлення номер 32', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:11:11', NULL, NULL),
(83, 'User #33', 'test@mail.com33', 'Тестове повідомлення номер 33', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:12:11', NULL, NULL),
(84, 'User #34', 'test@mail.com34', 'Тестове повідомлення номер 34', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:13:11', NULL, NULL),
(85, 'User #35', 'test@mail.com35', 'Тестове повідомлення номер 35', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:14:11', NULL, NULL),
(86, 'User #36', 'test@mail.com36', 'Тестове повідомлення номер 36', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:15:11', NULL, NULL),
(87, 'User #37', 'test@mail.com37', 'Тестове повідомлення номер 37', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:16:11', NULL, NULL),
(88, 'User #38', 'test@mail.com38', 'Тестове повідомлення номер 38', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:17:11', NULL, NULL),
(89, 'User #39', 'test@mail.com39', 'Тестове повідомлення номер 39', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:18:11', NULL, NULL),
(90, 'User #40', 'test@mail.com40', 'Тестове повідомлення номер 40', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:19:11', NULL, NULL),
(91, 'User #41', 'test@mail.com41', 'Тестове повідомлення номер 41', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:20:11', NULL, NULL),
(92, 'User #42', 'test@mail.com42', 'Тестове повідомлення номер 42', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:21:11', NULL, NULL),
(93, 'User #43', 'test@mail.com43', 'Тестове повідомлення номер 43', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:22:11', NULL, NULL),
(94, 'User #44', 'test@mail.com44', 'Тестове повідомлення номер 44', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:23:11', NULL, NULL),
(95, 'User #45', 'test@mail.com45', 'Тестове повідомлення номер 45', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:24:11', NULL, NULL),
(96, 'User #46', 'test@mail.com46', 'Тестове повідомлення номер 46', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:25:11', NULL, NULL),
(97, 'User #47', 'test@mail.com47', 'Тестове повідомлення номер 47', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:26:11', NULL, NULL),
(98, 'User #48', 'test@mail.com48', 'Тестове повідомлення номер 48', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:27:11', NULL, NULL),
(99, 'User #49', 'test@mail.com49', 'Тестове повідомлення номер 49', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:28:11', NULL, NULL),
(100, 'User #50', 'test@mail.com50', 'Тестове повідомлення номер 50', NULL, '/uploads/images/test.png', 1, '2024-09-10 20:29:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `is_blocked` tinyint(1) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `is_blocked`, `email`, `roles`, `password`) VALUES
(1, 0, 'admin@admin.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$o0pHAdHjBUlAFeSaeU4mLuMHLQiGnlfAmSDUQRZUQOcbnpgHBA3dS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
