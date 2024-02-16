-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 11:44 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super User', 'admin@gmail.com', NULL, '$2y$12$hH8cDM3LUQ7itdOB775e3ewG1DF9U9yep6KAdAofkmLKXzyCUwqWK', 1, NULL, '2024-02-16 06:27:47', '2024-02-16 06:27:47'),
(8, 'Super User 2', 'adminsu@gmail.com', '0851567198324', '$2y$12$fhaFKW9D3NSOJlOGiZeA0up49zjQyp68kFdJ5vVc/2oPJMcNy69GG', 1, NULL, '2024-02-16 12:19:05', '2024-02-16 15:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `detail_admins`
--

CREATE TABLE `detail_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_admins`
--

INSERT INTO `detail_admins` (`id`, `id_admin`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(2, 8, '1234567890123456', 'Sidoarjooooopppppp', '2024-02-01', 'Laki-laki', 'Surabaya', 'Super User 2-1708122324.jpg', '2024-02-16 12:19:05', '2024-02-16 15:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `detail_kasirs`
--

CREATE TABLE `detail_kasirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` bigint(20) NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_kasirs`
--

INSERT INTO `detail_kasirs` (`id`, `id_kasir`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 2, '9876543245678765', 'Surabaya', '2024-01-31', 'Laki-laki', 'Jl. Brigjend Katamso 45', NULL, '2024-02-16 12:42:44', '2024-02-16 12:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `detail_marketings`
--

CREATE TABLE `detail_marketings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_marketing` bigint(20) NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_marketings`
--

INSERT INTO `detail_marketings` (`id`, `id_marketing`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 4, '9876543456543456', 'Surabaya', '2024-01-31', 'Laki-laki', 'Jl. Brigjend Katamso', NULL, '2024-02-16 12:35:35', '2024-02-16 12:35:35'),
(2, 5, '7656543456765432', 'Surabaya', '2024-01-31', 'Perempuan', 'Waru, Sidoarjo', NULL, '2024-02-16 12:47:50', '2024-02-16 12:47:50');

-- --------------------------------------------------------

--
-- Table structure for table `detail_tenants`
--

CREATE TABLE `detail_tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_tenants`
--

INSERT INTO `detail_tenants` (`id`, `id_tenant`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 3, '9876545676545432', 'Sidoarjo', '2024-01-30', 'Laki-laki', 'Waru, Sidoarjo', NULL, '2024-02-16 12:46:11', '2024-02-16 12:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasirs`
--

CREATE TABLE `kasirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kasirs`
--

INSERT INTO `kasirs` (`id`, `name`, `email`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Andy', 'andy@gmail.com', NULL, '$2y$12$o9ZXKmiC8DP2APqIUFg8g.Ak5EKPsGoVAOkSPMV1ndEBezS5oCNnu', 1, NULL, '2024-02-16 10:32:21', '2024-02-16 10:32:21'),
(2, 'Budi Santoso', 'budisans@gmail.com', '089765432345', '$2y$12$jo5bwEi4Jo0SLDmksEsA5.rLjiRZa.KeH4kYtk0j7OITlh0cTXQz2', 1, NULL, '2024-02-16 12:42:44', '2024-02-16 12:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `marketings`
--

CREATE TABLE `marketings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketings`
--

INSERT INTO `marketings` (`id`, `name`, `email`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Amar', 'admm@gmail.com', NULL, '$2y$12$qK2qNnpY5EJWiJFQ.QQnAeoVweh.BPnBpO0TkirbKG6h7QAG.PizC', 0, NULL, '2024-02-16 08:46:57', '2024-02-16 08:46:57'),
(2, 'Amar Wibi', 'admin@gmail.com', NULL, '$2y$12$QO1gCoedrDgZkts7YkphL.3LhmLAt7VHJ1VP3Et6dKCzuka9d1sGa', 0, NULL, '2024-02-16 08:47:59', '2024-02-16 08:47:59'),
(3, 'Amar', 'adminnnnnxxx@gmail.com', NULL, '$2y$12$/TQI9rt.wb5LPEcLFOA/6uPzmBYO8A8X4a/eR2k8dnoTBn8Ig7xp6', 0, NULL, '2024-02-16 08:51:59', '2024-02-16 08:51:59'),
(4, 'Deny Mahendra', 'denymhndr@gmail.com', '087656543456', '$2y$12$.gQCYwFnX5igsCAVwHfXYOMU0b2eWYtL3gD0J6HRnTGMoK1Zia9U2', 0, NULL, '2024-02-16 12:35:35', '2024-02-16 12:35:35'),
(5, 'Inayah Indah Putri', 'inay_98767@gmail.com', '081562533723', '$2y$12$8z/AqTEuw6C3B3ONueNDkOIs99FtvWdHuUsezDELFZvPQCHgl5YIW', 0, NULL, '2024-02-16 12:47:50', '2024-02-16 12:47:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_16_130932_create_admins_table', 2),
(7, '2024_02_16_152649_create_marketings_table', 3),
(8, '2024_02_16_160846_create_tenants_table', 4),
(9, '2024_02_16_171707_create_kasirs_table', 5),
(10, '2024_02_16_181934_create_detail_marketings_table', 6),
(11, '2024_02_16_181940_create_detail_tenants_table', 6),
(12, '2024_02_16_181945_create_detail_kasirs_table', 6),
(13, '2024_02_16_182005_create_detail_admins_table', 6),
(14, '2024_02_16_182134_add_is_active_field_to_table_admin', 6),
(15, '2024_02_16_182143_add_is_active_field_to_table_admin', 6),
(16, '2024_02_16_182155_add_is_active_field_to_table_admin', 6),
(17, '2024_02_16_182203_add_is_active_field_to_table_admin', 6),
(18, '2024_02_16_185305_add_phone_field_to_table_admin', 7),
(19, '2024_02_16_185329_add_phone_field_to_table_marketing', 7),
(20, '2024_02_16_185351_add_phone_field_to_table_tenant', 7),
(21, '2024_02_16_185406_add_phone_field_to_table_kasirs', 7),
(22, '2024_02_16_193718_add_photo_field_to_table_admins', 8),
(23, '2024_02_16_193739_add_photo_field_to_table_marketing', 8),
(24, '2024_02_16_193751_add_photo_field_to_table_kasir', 8),
(25, '2024_02_16_193803_add_photo_field_to_table_tenant', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `email`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Amar', 'amar@gmail.com', NULL, '$2y$12$iLKExEk8zw6Ge4kou8lR3.vzNOlquZ7Rv1VF5P4xkUdWUILsr2x1u', 1, NULL, '2024-02-16 10:16:19', '2024-02-16 10:16:19'),
(3, 'Tommy Syahputra', 'tommy_mah@gmail.com', '0813433765362', '$2y$12$zdbV4GnX/Hj7FefibbrbE.qfDG1ZBjQuJstyPdhYjvH1K0mOy33ai', 1, NULL, '2024-02-16 12:46:11', '2024-02-16 12:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `detail_admins`
--
ALTER TABLE `detail_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_admins_id_admin_unique` (`id_admin`),
  ADD UNIQUE KEY `detail_admins_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_kasirs_id_kasir_unique` (`id_kasir`),
  ADD UNIQUE KEY `detail_kasirs_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_marketings_id_marketing_unique` (`id_marketing`),
  ADD UNIQUE KEY `detail_marketings_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_tenants_id_tenant_unique` (`id_tenant`),
  ADD UNIQUE KEY `detail_tenants_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kasirs`
--
ALTER TABLE `kasirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kasirs_email_unique` (`email`);

--
-- Indexes for table `marketings`
--
ALTER TABLE `marketings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marketings_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_admins`
--
ALTER TABLE `detail_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasirs`
--
ALTER TABLE `kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
