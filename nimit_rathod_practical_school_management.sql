-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 08:11 PM
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
-- Database: `practical_school_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target` varchar(255) NOT NULL COMMENT 'teachers',
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `target`, `role_id`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'SMS 1', 'SMS 1 Test', 'teachers', 5, 1, NULL, '2024-07-07 11:42:55', '2024-07-07 11:42:55'),
(5, 'SMS 1', 'SMS 1 Test', 'students', 6, 1, NULL, '2024-07-07 11:42:55', '2024-07-07 11:42:55'),
(6, 'SMS 1', 'SMS 1 Test', 'parents', 7, 1, NULL, '2024-07-07 11:42:55', '2024-07-07 11:42:55'),
(7, 'On this Sunday', 'This day outing of all students', 'students', 6, 6, NULL, '2024-07-07 11:59:37', '2024-07-07 11:59:37'),
(8, 'On this Sunday', 'This day outing of all students', 'parents', 7, 6, NULL, '2024-07-07 11:59:37', '2024-07-07 11:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:28:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"no-permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:5;i:3;i:6;i:4;i:7;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:20:\"panel-user-managment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"users-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"users-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"users-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"users-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"roles-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"roles-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:10:\"roles-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"roles-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"permissions-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"permissions-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"permissions-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:18:\"permissions-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:13:\"teachers-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"teachers-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:13:\"teachers-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"teachers-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:13:\"students-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"students-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"students-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:15:\"students-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"parents-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:14:\"parents-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"parents-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"parents-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:18:\"announcements-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:5;i:3;i:6;i:4;i:7;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:20:\"announcements-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"developer\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"teachers\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:8:\"students\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:7:\"parents\";s:1:\"c\";s:3:\"web\";}}}', 1720460363);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(53, '0001_01_01_000000_create_users_table', 1),
(54, '0001_01_01_000001_create_cache_table', 1),
(55, '0001_01_01_000002_create_jobs_table', 1),
(56, '2024_07_05_160740_create_permission_tables', 1),
(58, '2024_07_07_062841_create_announcements_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(5, 'App\\Models\\Teachers', 6),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\Teachers', 7),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\Teachers', 8),
(5, 'App\\Models\\User', 8),
(5, 'App\\Models\\Teachers', 9),
(5, 'App\\Models\\User', 9),
(6, 'App\\Models\\Student', 10),
(6, 'App\\Models\\User', 10),
(6, 'App\\Models\\Student', 11),
(6, 'App\\Models\\User', 11),
(7, 'App\\Models\\Parents', 12),
(7, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'no-permission', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(2, 'panel-user-managment', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(3, 'users-list', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(4, 'users-create', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(5, 'users-edit', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(6, 'users-delete', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(7, 'roles-list', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(8, 'roles-create', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(9, 'roles-edit', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(10, 'roles-delete', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(11, 'permissions-list', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(12, 'permissions-create', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(13, 'permissions-edit', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(14, 'permissions-delete', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(15, 'teachers-list', 'web', NULL, '2024-07-07 00:31:31', '2024-07-07 00:31:31'),
(16, 'teachers-create', 'web', NULL, '2024-07-07 00:31:40', '2024-07-07 00:32:16'),
(17, 'teachers-edit', 'web', NULL, '2024-07-07 00:31:46', '2024-07-07 00:31:46'),
(18, 'teachers-delete', 'web', NULL, '2024-07-07 00:31:52', '2024-07-07 00:31:52'),
(19, 'students-list', 'web', NULL, '2024-07-07 00:40:08', '2024-07-07 00:40:08'),
(20, 'students-create', 'web', NULL, '2024-07-07 00:40:16', '2024-07-07 00:40:16'),
(21, 'students-edit', 'web', NULL, '2024-07-07 00:40:24', '2024-07-07 00:40:24'),
(22, 'students-delete', 'web', NULL, '2024-07-07 00:40:29', '2024-07-07 00:40:29'),
(23, 'parents-list', 'web', NULL, '2024-07-07 00:40:43', '2024-07-07 00:40:43'),
(24, 'parents-create', 'web', NULL, '2024-07-07 00:40:48', '2024-07-07 00:40:48'),
(25, 'parents-edit', 'web', NULL, '2024-07-07 00:40:52', '2024-07-07 00:40:52'),
(26, 'parents-delete', 'web', NULL, '2024-07-07 00:40:57', '2024-07-07 00:40:57'),
(27, 'announcements-list', 'web', NULL, '2024-07-07 08:47:47', '2024-07-07 08:47:47'),
(28, 'announcements-create', 'web', NULL, '2024-07-07 08:47:56', '2024-07-07 08:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'developer', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(2, 'admin', 'web', NULL, '2024-07-07 00:19:50', '2024-07-07 00:19:50'),
(5, 'teachers', 'web', NULL, '2024-07-07 00:21:35', '2024-07-07 01:50:03'),
(6, 'students', 'web', NULL, '2024-07-07 02:12:29', '2024-07-07 02:12:51'),
(7, 'parents', 'web', NULL, '2024-07-07 02:29:57', '2024-07-07 02:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 5),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(19, 5),
(20, 1),
(20, 2),
(20, 5),
(21, 1),
(21, 2),
(21, 5),
(22, 1),
(22, 2),
(22, 5),
(23, 1),
(23, 2),
(23, 5),
(24, 1),
(24, 2),
(24, 5),
(25, 1),
(25, 2),
(25, 5),
(26, 1),
(26, 2),
(26, 5),
(27, 1),
(27, 2),
(27, 5),
(27, 6),
(27, 7),
(28, 1),
(28, 2),
(28, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AuPXNe5twcuKnzjtU8VKHMhvSZ0KZljYiD4n4vqk', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTWdyQWNBcTdSeEx6YlBYZXJ1WW5LMEhCSUxuMDUzeWw3a0QxV0p2dyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hbm5vdW5jZW1lbnRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzIwMzczOTA1O319', 1720373971),
('AZknnc3ulOvaiqlVG7L4DwRSLBbGg0NrDywc3w3Z', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUjdvMzdtdnphMnJyWjNsYmhwUW0yb1hvaG1NWDgyc3c1ZURpRGpMVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vYW5ub3VuY2VtZW50cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzIwMzcwNzg1O319', 1720373734),
('BFEEX0zO0pCaWjdNq7xXBn17RNq12s42ei6yU0MO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVVqZGt6MDdVcXEyWFRXT1g0Y2ZyOVVpTDJJbXlCVVcwdE9lOVVoTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1720375842),
('JRcKSUckCRme75PKiif74GU6sIf9U9k8QFLDBhx3', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVHI2amVtc3RjNXBBRE8wbFBOUXh1SWd5dzNWUjF2RHlrZXdQN1k2dyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yb2xlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzIwMzYyMTI4O319', 1720373965);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive' COMMENT 'inactive, active',
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Nimit Rathod', 'nimitrathod1997@gmail.com', NULL, '$2y$12$Bh8wMpsD30AnCVoHScdMRuFScu4rhi57sSltq98f1iLxIppD03lK6', 'inactive', NULL, NULL, '2024-07-07 00:19:51', '2024-07-07 00:19:51'),
(2, 'School Admin', 'schooladmin@gmail.com', NULL, '$2y$12$sxLqjcMIzqLqCewGPfPBF.MO1qmNjXlCzCi834hOBPw3B84Humcia', 'active', NULL, NULL, '2024-07-07 00:22:41', '2024-07-07 00:22:41'),
(6, 'Maths Teachers', 'mathsteacher@gmail.com', NULL, '$2y$12$7I0tVVXPuYOqXqtXMJD1T.s6I8drCrXE3MnzyZNPT7/OemxO/BK1W', 'inactive', NULL, NULL, '2024-07-07 01:39:48', '2024-07-07 01:48:45'),
(7, 'Science', 'scienceteacher@gmail.com', NULL, '$2y$12$ZBrBJlLP4BwEBhoJSlFd6.xbcZEMoYnYg6md.MMBkYEhekEdzTuQe', 'active', NULL, NULL, '2024-07-07 01:46:53', '2024-07-07 01:46:58'),
(8, 'Physics Teacher', 'physicsteacher@gmail.com', NULL, '$2y$12$OTOY8lDEeFYUHC86O13YQu1trDiIoydAaZXIKeykcJ78VHPcUT4IK', 'active', NULL, NULL, '2024-07-07 01:56:19', '2024-07-07 02:02:37'),
(9, 'Biology Teacher', 'biologyteacher@gmail.com', NULL, '$2y$12$s3rI3OGU.fzaRyOlIYlR5.6wVRjfa5j1.8D.Ib90S/BpJlO7yuYHq', 'inactive', NULL, NULL, '2024-07-07 02:03:40', '2024-07-07 02:03:40'),
(10, 'Student', 'student@gmail.com', NULL, '$2y$12$Jpn1y2C5M/6JAKnlvEn.t.6lQx34YDv6RmUQxKx/VahcqOOnDc9xu', 'active', NULL, NULL, '2024-07-07 02:22:17', '2024-07-07 02:24:17'),
(11, 'Teacher to student', 'student2@gmail.com', NULL, '$2y$12$sB39.mZBj8cNEXM8QtEEceoT5gT8jpSontKBnyBUMQoosx7DKYLb2', 'inactive', NULL, NULL, '2024-07-07 02:25:43', '2024-07-07 02:26:13'),
(12, 'Parents', 'parents@gmail.com', NULL, '$2y$12$ju.JmkL0CjvcQbny1AQY1egM873rhuArF36cIvCM6xlBaOPn86lkK', 'active', NULL, NULL, '2024-07-07 02:32:25', '2024-07-07 02:32:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_role_id_foreign` (`role_id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `announcements_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
