-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 07:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 'Super User', 'adminsu@gmail.com', NULL, '0851567198324', '$2y$12$fhaFKW9D3NSOJlOGiZeA0up49zjQyp68kFdJ5vVc/2oPJMcNy69GG', 1, NULL, '2024-02-16 12:19:05', '2024-02-16 15:42:27'),
(24, 'Gilang Syahputra', 'ouka.dev@gmail.com', '2024-02-19 20:54:15', '085156719836', '$2y$12$xbXT3d9pauKRe9YgtUWs6O0wCU254Ig0ivVlovTey8vyWqSlEV1ve', 1, NULL, '2024-02-19 20:53:50', '2024-02-19 20:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `id_tenant`, `batch_code`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 7, 'LSP', 'Laptop Sparepart', '2024-02-20 00:53:11', '2024-02-20 00:53:11'),
(2, 7, 'HSP', 'Sparepart HP', '2024-02-20 00:53:29', '2024-02-20 00:53:29'),
(3, 7, 'LP', 'Unit Laptop', '2024-02-20 00:53:44', '2024-02-20 00:53:44'),
(4, 7, 'KMP', 'Komputer Unit', '2024-02-20 00:54:01', '2024-02-20 00:54:01'),
(5, 7, 'ASCLP', 'Accessories Laptop', '2024-02-20 00:54:16', '2024-02-20 01:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `category_products`
--

CREATE TABLE `category_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_admins`
--

CREATE TABLE `detail_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_admins`
--

INSERT INTO `detail_admins` (`id`, `id_admin`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(2, 8, '1234567890123456', 'Sidoarjooooopppppp', '2024-02-01', 'Laki-laki', 'Surabaya', 'Super User 2-1708132796.webp', '2024-02-16 12:19:05', '2024-02-16 18:19:56'),
(18, 24, '6545434567654323', 'Sidoarjo', '2023-11-08', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 20:53:50', '2024-02-19 20:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `detail_kasirs`
--

CREATE TABLE `detail_kasirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` bigint(20) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_kasirs`
--

INSERT INTO `detail_kasirs` (`id`, `id_kasir`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 2, '9876543245678765', 'Surabaya', '2024-01-31', 'Laki-laki', 'Jl. Brigjend Katamso 45', NULL, '2024-02-16 12:42:44', '2024-02-16 12:42:44'),
(2, 3, '7654567876545678', 'Sidoarjo', '2024-02-08', 'Laki-laki', 'Surabaya', NULL, '2024-02-18 22:14:28', '2024-02-18 22:14:28'),
(3, 4, '7654345654342567', 'Sidoarjo', '2001-02-06', 'Perempuan', 'Jl. Wiyung Surabaya No. 45', NULL, '2024-02-20 01:39:07', '2024-02-20 01:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `detail_marketings`
--

CREATE TABLE `detail_marketings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_marketing` bigint(20) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_marketings`
--

INSERT INTO `detail_marketings` (`id`, `id_marketing`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 4, '9876543456543456', 'Surabaya', '2024-01-31', 'Laki-laki', 'Jl. Brigjend Katamso', NULL, '2024-02-16 12:35:35', '2024-02-16 12:35:35'),
(2, 5, '7656543456765432', 'Surabaya', '2024-01-31', 'Perempuan', 'Waru, Sidoarjooooo', '-1708140791.webp', '2024-02-16 12:47:50', '2024-02-16 20:33:21'),
(4, 7, '8987654565434567', 'Surabaya', '2024-02-01', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:18:50', '2024-02-19 21:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `detail_tenants`
--

CREATE TABLE `detail_tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_tenants`
--

INSERT INTO `detail_tenants` (`id`, `id_tenant`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 3, '9876545676545432', 'Sidoarjo', '2024-01-30', 'Laki-laki', 'Waru, Sidoarjo', NULL, '2024-02-16 12:46:11', '2024-02-16 12:46:11'),
(3, 5, '6754345676545678', 'Sidoarjooo', '2024-02-01', 'Laki-laki', 'Surabaya', '-1708323229.jpg', '2024-02-18 21:23:52', '2024-02-18 23:13:49'),
(4, 6, '8765654567654345', 'Sidoarjo', '2024-01-31', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:53:18', '2024-02-19 21:53:18'),
(5, 7, '7654345654323456', 'Sidoarjo', '2024-01-31', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:55:33', '2024-02-19 21:55:33');

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
-- Table structure for table `invitation_codes`
--

CREATE TABLE `invitation_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_marketing` bigint(20) NOT NULL,
  `inv_code` varchar(5) NOT NULL,
  `holder` varchar(255) NOT NULL,
  `attempt` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invitation_codes`
--

INSERT INTO `invitation_codes` (`id`, `id_marketing`, `inv_code`, `holder`, `attempt`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 5, 'XAKL1', 'Amar', 0, 1, '2024-02-16 21:04:05', '2024-02-16 21:04:05'),
(2, 5, 'DGHT5', 'Denny Ahmad', 0, 1, '2024-02-16 21:04:26', '2024-02-16 21:04:26'),
(3, 5, 'GHTY5', 'Indira Soraya', 0, 1, '2024-02-16 21:04:40', '2024-02-16 21:04:40'),
(4, 5, 'GHJN8', 'Budi Priyatno', 0, 1, '2024-02-16 21:05:00', '2024-02-16 21:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `kasirs`
--

CREATE TABLE `kasirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `id_tenant` bigint(20) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kasirs`
--

INSERT INTO `kasirs` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `id_tenant`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Budi Santoso', 'budisans@gmail.com', NULL, '089765432345', '$2y$12$jo5bwEi4Jo0SLDmksEsA5.rLjiRZa.KeH4kYtk0j7OITlh0cTXQz2', 1, 0, NULL, '2024-02-16 12:42:44', '2024-02-16 12:42:44'),
(3, 'Hanif Putra', 'hanifsyhptr@gmail.com', NULL, '0876545423324', '$2y$12$0Sv9gMUUci.UvvD8BBbUBOzOElXCSQ9PywLPaVtoR3nF7tJFFrtRi', 1, 5, NULL, '2024-02-18 22:14:28', '2024-02-18 22:14:28'),
(4, 'Indira Putri', 'indiraputri456@gmail.com', NULL, '0813456786345', '$2y$12$1DixkxhffH6BSyZ342yD/.qNSdiFmLARHfJUVAxm/jJg25yps82T.', 1, 7, NULL, '2024-02-20 01:39:07', '2024-02-20 01:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `marketings`
--

CREATE TABLE `marketings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketings`
--

INSERT INTO `marketings` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Deny Mahendra', 'denymhndr@gmail.com', NULL, '087656543456', '$2y$12$.gQCYwFnX5igsCAVwHfXYOMU0b2eWYtL3gD0J6HRnTGMoK1Zia9U2', 0, NULL, '2024-02-16 12:35:35', '2024-02-16 12:35:35'),
(5, 'Inayah Indah Putri', 'inay_98767@gmail.com', NULL, '0815625337232', '$2y$12$hnUwP.UcO/Pq80rmshFPseJU0xebXQ2eJfU1gOOsoKo5zmBQhbpJu', 1, NULL, '2024-02-16 12:47:50', '2024-02-16 20:37:59'),
(7, 'Angga Priyambodo', 'apriyambodo487@gmail.com', '2024-02-19 21:19:32', '087654434567', '$2y$12$iiuX1DSrtWA7.NOdMzqqoePa8sr8jq6MIMzuBbd98U4Vx66Th9ghG', 0, NULL, '2024-02-19 21:18:50', '2024-02-19 21:19:32');

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
(25, '2024_02_16_193803_add_photo_field_to_table_tenant', 8),
(26, '2024_02_17_030947_create_invitation_codes_table', 9),
(31, '2024_02_19_023656_add_email_verification_timestamp_to_admin_table', 10),
(32, '2024_02_19_023710_add_email_verification_timestamp_to_marketing_table', 10),
(33, '2024_02_19_023723_add_email_verification_timestamp_to_tenants_table', 10),
(34, '2024_02_19_023734_add_email_verification_timestamp_to_kasirs_table', 10),
(36, '2024_02_19_041723_add_inv_code_to_tenant_user', 11),
(37, '2024_02_19_042539_add_inv_code_to_kasir_user', 12),
(39, '2024_02_19_062311_create_store_details_table', 13),
(40, '2024_02_19_072025_create_suppliers_table', 14),
(41, '2024_02_19_084814_create_product_categories_table', 15),
(42, '2024_02_20_064240_create_products_table', 16),
(43, '2024_02_20_065327_create_category_products_table', 17),
(44, '2024_02_20_073324_create_batches_table', 18),
(45, '2024_02_20_074532_add_id_tenant_field_to_table_batch', 19),
(46, '2024_02_20_074646_add_id_tenant_field_to_table_product', 19);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nomor_gudang` varchar(255) DEFAULT NULL,
  `nomor_rak` varchar(255) DEFAULT NULL,
  `tanggal_beli` date DEFAULT NULL,
  `tanggal_expired` date DEFAULT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `id_tenant`, `name`, `created_at`, `updated_at`) VALUES
(1, 7, 'Sparepart Laptop', '2024-02-19 23:08:28', '2024-02-19 23:18:35'),
(2, 7, 'Sparepart Komputer', '2024-02-19 23:31:39', '2024-02-19 23:31:39'),
(3, 7, 'Sparepart Printer', '2024-02-19 23:31:52', '2024-02-19 23:31:52'),
(4, 7, 'Aksesoris HP', '2024-02-19 23:32:06', '2024-02-19 23:32:06'),
(5, 7, 'Battery', '2024-02-19 23:32:16', '2024-02-19 23:32:16'),
(6, 7, 'PC Buildup', '2024-02-19 23:32:39', '2024-02-19 23:32:39'),
(7, 7, 'PC Rakitan', '2024-02-19 23:32:46', '2024-02-19 23:32:46'),
(8, 7, 'Chipset Android', '2024-02-19 23:32:59', '2024-02-19 23:32:59'),
(9, 7, 'HP', '2024-02-19 23:33:06', '2024-02-19 23:33:06'),
(10, 7, 'Komputer', '2024-02-19 23:33:13', '2024-02-19 23:33:13'),
(11, 7, 'Laptop', '2024-02-19 23:33:20', '2024-02-19 23:33:20'),
(12, 7, 'Projector', '2024-02-19 23:33:26', '2024-02-19 23:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `store_details`
--

CREATE TABLE `store_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `status_umi` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_details`
--

INSERT INTO `store_details` (`id`, `id_tenant`, `name`, `alamat`, `jenis_usaha`, `status_umi`, `photo`, `created_at`, `updated_at`) VALUES
(1, 5, 'Tolo Bangunan Surabaya', 'Surabaya', 'Penjualan Toko Bangunan', 1, '-1708327020.jpg', NULL, '2024-02-19 00:17:00'),
(2, 6, NULL, NULL, NULL, NULL, NULL, '2024-02-19 21:53:18', '2024-02-19 21:53:18'),
(3, 7, 'Toko Komputer Surabaya', 'Jl. Brigjend Katamso No. 45', 'Penjualan Alat dan Aksesoris Komputer', 1, '-1708406926.jpg', '2024-02-19 21:55:33', '2024-02-19 22:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `email_supplier` varchar(255) DEFAULT NULL,
  `phone_supplier` varchar(20) DEFAULT NULL,
  `alamat_supplier` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `id_tenant`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 5, 'Toko Semen Gresik', 'penjual@gmail.com', '0876577677765', 'Toko Supplier Semen Gresik', 'Tempat kulak an smen', '2024-02-19 00:51:59', '2024-02-19 01:45:25'),
(3, 7, 'PT. Projector Surabaya', 'projectorsurabaya123@gmail.com', '081567876577', 'Jl. Pemuda No. 45 Surabaya Jawa Timur', 'Supplier penyedia sparepart projector', '2024-02-19 22:30:41', '2024-02-19 22:30:41'),
(4, 7, 'PT. Komputer Giant', 'tokokomputer@gmail.com', '0876537828373', 'Jl. Ahmad Yani No. 06 Surabaya Jawa Timur', 'Supplier penyedia aksesoris dan sparepart komputer', '2024-02-19 22:31:50', '2024-02-19 22:31:50'),
(5, 7, 'PT. Sparepart Android', 'spareparthp123@gmail.com', '0815676254335', 'Jl. Brigjend Katamso No 20 Janti Waru Sidoarjo', 'Supplier penyedia sparepart hp', '2024-02-19 22:32:44', '2024-02-19 22:32:44'),
(6, 7, 'PT. Buku Tulis Sidoarjo', 'bukutulimakmur@gmail.com', '081456787625', 'Jl. Janti Waru Sidoarjo No. 45 Desa Cucung Sidoarjo', 'Supplier penyedia ATK di Sidoarjo', '2024-02-19 22:34:04', '2024-02-19 22:34:04'),
(7, 7, 'PT. Printer Jaya', 'printerjayasurabaya@gmail.com', '081456782698', 'Jl. Manca Negara No. 17 Kec. Surakarta, Surabaya Jawa Timur', 'SUpplier untuk peralatan printer', '2024-02-19 22:51:53', '2024-02-19 22:51:53'),
(8, 7, 'PT. Sparepart Iphone', 'iphoneofficialsparepart@gmailc.com', '087637323383', 'Jl. Pemuda Surabaya Merdeka No. 45 Wiyung Surabaya, 61254', 'Suppier penyedia untuk sparepart iphone', '2024-02-19 23:26:53', '2024-02-19 23:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `id_inv_code` bigint(20) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `id_inv_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Tommy Syahputra', 'tommy_mah@gmail.com', NULL, '0813433765362', '$2y$12$zdbV4GnX/Hj7FefibbrbE.qfDG1ZBjQuJstyPdhYjvH1K0mOy33ai', 1, 1, NULL, '2024-02-16 12:46:11', '2024-02-16 12:46:11'),
(5, 'Tomy Budianto', 'tommybudiant@gmail.com', NULL, '0876545677877', '$2y$12$UmUN/hW4G6Pj7wjS1aCv6.QCz1.3RMm3SK5bZp4WkGqoexiMCTw8e', 1, 1, NULL, '2024-02-18 21:23:52', '2024-02-18 23:17:23'),
(7, 'Anrdiansyah Indra SYahputra', 'solutionmanunggal@gmail.com', '2024-02-19 21:55:58', '087654322434', '$2y$12$sdCCBtSih5rdn4uhP23CA.SIkVqophWxYXPyNWMFCc7awzKjaWF3q', 1, 2, NULL, '2024-02-19 21:55:33', '2024-02-19 21:55:58');

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
  `remember_token` varchar(100) DEFAULT NULL,
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
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batches_batch_code_unique` (`batch_code`);

--
-- Indexes for table `category_products`
--
ALTER TABLE `category_products`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `invitation_codes`
--
ALTER TABLE `invitation_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invitation_codes_inv_code_unique` (`inv_code`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_batch_code_unique` (`batch_code`),
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_details`
--
ALTER TABLE `store_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_details_id_tenant_unique` (`id_tenant`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category_products`
--
ALTER TABLE `category_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_admins`
--
ALTER TABLE `detail_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitation_codes`
--
ALTER TABLE `invitation_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kasirs`
--
ALTER TABLE `kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `store_details`
--
ALTER TABLE `store_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
