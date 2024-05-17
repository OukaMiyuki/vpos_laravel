-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 03:59 AM
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
(8, 'HR Fery', 'adminsu@vpos.my.id.com', '2024-02-19 20:54:15', '0851567198324', '$2y$12$xbXT3d9pauKRe9YgtUWs6O0wCU254Ig0ivVlovTey8vyWqSlEV1ve', 1, NULL, '2024-02-16 12:19:05', '2024-02-16 15:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `agregate_wallets`
--

CREATE TABLE `agregate_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saldo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agregate_wallets`
--

INSERT INTO `agregate_wallets` (`id`, `saldo`, `created_at`, `updated_at`) VALUES
(1, '1400', NULL, '2024-05-16 09:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `batch_code` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `store_identifier`, `batch_code`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'DP', 'Produk Desktop', '2024-05-13 06:58:43', '2024-05-13 06:59:02'),
(8, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'LP', 'Produk Laptop', '2024-05-13 07:12:40', '2024-05-13 07:12:40'),
(9, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'HP', 'Produk HP', '2024-05-13 07:12:50', '2024-05-13 07:12:50'),
(10, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'ACS', 'Produk Aksesoris', '2024-05-13 07:13:01', '2024-05-13 07:13:01'),
(12, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'LP', 'Laptop', '2024-05-14 04:27:57', '2024-05-14 04:27:57'),
(13, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'PTR', 'Printer Product', '2024-05-15 04:36:43', '2024-05-15 04:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `customer_identifiers`
--

CREATE TABLE `customer_identifiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_invoice` bigint(20) NOT NULL,
  `customer_info` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_identifiers`
--

INSERT INTO `customer_identifiers` (`id`, `id_invoice`, `customer_info`, `description`, `created_at`, `updated_at`) VALUES
(17, 19, '', NULL, '2024-05-13 09:15:31', '2024-05-13 09:15:31'),
(18, 20, '', NULL, '2024-05-13 09:26:34', '2024-05-13 09:26:34'),
(19, 21, '', NULL, '2024-05-13 09:30:20', '2024-05-13 09:30:20'),
(20, 22, 'Amar Wibianto', NULL, '2024-05-13 14:43:18', '2024-05-13 14:43:18'),
(21, 23, '', NULL, '2024-05-13 14:49:24', '2024-05-13 14:49:24'),
(22, 24, '', NULL, '2024-05-13 14:52:29', '2024-05-13 14:52:29'),
(23, 25, '', NULL, '2024-05-13 14:54:22', '2024-05-13 14:54:22'),
(24, 27, 'Deni Wijaya', 'Lupa Ambil Dompet', '2024-05-13 15:02:46', '2024-05-13 15:02:46'),
(25, 28, '', 'Ambil Dompet', '2024-05-13 15:30:59', '2024-05-13 15:43:51'),
(26, 29, '', 'Ambil Dompet', '2024-05-13 15:45:13', '2024-05-13 15:45:35'),
(27, 30, '', NULL, '2024-05-13 16:13:05', '2024-05-13 16:13:05'),
(28, 31, '', NULL, '2024-05-13 16:15:05', '2024-05-13 16:15:05'),
(29, 32, '', NULL, '2024-05-13 17:15:37', '2024-05-13 17:15:37'),
(30, 33, 'Rudi Salim', NULL, '2024-05-13 18:00:29', '2024-05-13 18:00:29'),
(31, 34, 'Mahendra Rahman', NULL, '2024-05-13 18:48:47', '2024-05-13 18:48:47'),
(32, 35, '', NULL, '2024-05-13 18:50:02', '2024-05-13 18:50:02'),
(33, 36, '', NULL, '2024-05-13 18:50:31', '2024-05-13 18:50:31'),
(34, 37, '', NULL, '2024-05-13 18:50:40', '2024-05-13 18:50:40'),
(35, 38, '', NULL, '2024-05-13 18:51:04', '2024-05-13 18:51:04'),
(36, 39, '', NULL, '2024-05-13 18:52:59', '2024-05-13 18:52:59'),
(37, 40, 'Mahendra Rahman', NULL, '2024-05-13 18:53:28', '2024-05-13 18:53:28'),
(38, 41, '', NULL, '2024-05-13 19:03:27', '2024-05-13 19:03:27'),
(39, 42, '', NULL, '2024-05-14 02:08:23', '2024-05-14 02:08:23'),
(40, 43, '', NULL, '2024-05-14 02:08:52', '2024-05-14 02:08:52'),
(41, 44, '', 'Nanti Balik Lagi', '2024-05-14 02:10:42', '2024-05-14 03:24:08'),
(42, 45, '', NULL, '2024-05-14 03:24:49', '2024-05-14 03:25:16'),
(43, 46, 'Rudi Irwansyah', NULL, '2024-05-14 03:35:49', '2024-05-14 03:35:49'),
(44, 47, '', NULL, '2024-05-14 04:20:27', '2024-05-14 04:20:27'),
(45, 48, '', NULL, '2024-05-14 04:21:16', '2024-05-14 04:21:16'),
(46, 49, '', NULL, '2024-05-14 04:21:49', '2024-05-14 04:21:49'),
(47, 50, '', NULL, '2024-05-14 04:22:21', '2024-05-14 04:22:21'),
(48, 51, '', NULL, '2024-05-14 04:33:33', '2024-05-14 04:33:33'),
(49, 52, '', NULL, '2024-05-14 04:35:15', '2024-05-14 04:35:15'),
(50, 53, 'Doni Sulaiman', NULL, '2024-05-14 04:53:53', '2024-05-14 04:53:53'),
(51, 54, '', NULL, '2024-05-14 07:55:11', '2024-05-14 07:55:11'),
(52, 55, '', NULL, '2024-05-14 18:21:38', '2024-05-14 18:21:38'),
(53, 56, '', NULL, '2024-05-15 05:56:21', '2024-05-15 05:56:21'),
(54, 57, '', NULL, '2024-05-15 06:01:00', '2024-05-15 06:01:00'),
(55, 58, 'Yuli Indri', NULL, '2024-05-15 06:06:01', '2024-05-15 06:06:01'),
(56, 59, '', NULL, '2024-05-15 06:15:45', '2024-05-15 06:15:45'),
(57, 60, '', NULL, '2024-05-15 06:16:05', '2024-05-15 06:16:42'),
(58, 61, 'Fina Safitri', NULL, '2024-05-15 07:22:52', '2024-05-15 07:22:52'),
(59, 62, '', NULL, '2024-05-15 07:25:29', '2024-05-15 07:25:29'),
(60, 63, '', NULL, '2024-05-15 07:25:30', '2024-05-15 07:25:30'),
(61, 64, '', NULL, '2024-05-15 07:37:05', '2024-05-15 07:37:27');

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
(26, 8, '', NULL, NULL, NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_kasirs`
--

CREATE TABLE `detail_kasirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `no_ktp` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_kasirs`
--

INSERT INTO `detail_kasirs` (`id`, `id_kasir`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(2, '2', 'indiraputri456@gmail.com', '8776567656765434', 'Surabaya', '1998-05-04', 'Perempuan', 'Jl. Ahmad Yani No. 45 Surabaya', NULL, '2024-05-13 05:55:09', '2024-05-13 05:55:09'),
(3, '3', 'syahputrarahman@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-14 06:01:10', '2024-05-14 06:01:10'),
(4, '4', 'rahmanbudiindra@gmail.com', '3456765676567654', 'Surabaya', '1996-05-15', 'Laki-laki', 'Surabaya', NULL, '2024-05-15 04:06:33', '2024-05-15 04:06:33');

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
(1, 1, '3326160107400474', 'Sidoarjo', '2001-06-12', 'Perempuan', 'Jl. Brigjend Katamso No. 45 Janti Waru Sidoarjo', '-1715195262.jpg', '2024-05-08 19:03:07', '2024-05-08 19:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penarikans`
--

CREATE TABLE `detail_penarikans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_penarikan` bigint(20) DEFAULT NULL,
  `nominal_penarikan` varchar(255) DEFAULT NULL,
  `nominal_bersih_penarikan` varchar(255) DEFAULT NULL,
  `total_biaya_admin` varchar(255) DEFAULT NULL,
  `biaya_nobu` varchar(255) DEFAULT NULL,
  `biaya_mitra` varchar(255) DEFAULT NULL,
  `biaya_admin_su` varchar(255) DEFAULT NULL,
  `biaya_agregate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_penarikans`
--

INSERT INTO `detail_penarikans` (`id`, `id_penarikan`, `nominal_penarikan`, `nominal_bersih_penarikan`, `total_biaya_admin`, `biaya_nobu`, `biaya_mitra`, `biaya_admin_su`, `biaya_agregate`, `created_at`, `updated_at`) VALUES
(1, 9, '11500', '10000', '1500', '300', '500', '350', '350', '2024-05-16 05:46:04', '2024-05-16 05:46:04'),
(2, 10, '11500', '10000', '1500', '300', '500', '350', '350', '2024-05-16 06:56:23', '2024-05-16 06:56:23'),
(3, 11, '11500', '10000', '1500', '300', '500', '350', '350', '2024-05-16 07:46:25', '2024-05-16 07:46:25'),
(4, 12, '11500', '10000', '1500', '300', '500', '350', '350', '2024-05-16 09:16:21', '2024-05-16 09:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `detail_tenants`
--

CREATE TABLE `detail_tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `no_ktp` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_tenants`
--

INSERT INTO `detail_tenants` (`id`, `id_tenant`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(2, '2', 'asukaloid.blog@gmail.com', '8767876765654567', 'Surabaya', '1998-02-12', 'Laki-laki', 'Jl Pemuda Surabaya Blok A11 No 34, Surabaya', '-1715578936.jpg', '2024-05-13 05:35:57', '2024-05-13 05:42:16'),
(3, '3', 'amarwibianto@gmail.com', '4345676567654323', 'Sidoarjo', '2000-02-15', 'Laki-laki', 'Surabaya', NULL, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, '4', 'apriyambodo487@gmail.com', '9876567876545678', 'Surabaya', '2000-01-08', 'Laki-laki', 'Surabaya', NULL, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `min_harga` int(11) DEFAULT NULL,
  `diskon` int(11) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `store_identifier`, `min_harga`, `diskon`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 100, 2, '2024-05-13', '2024-06-08', 1, '2024-05-13 05:35:57', '2024-05-13 08:37:37'),
(3, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', NULL, 0, NULL, NULL, 0, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, 'DPpU35sGVTUiVpYsj4p1B9MRVdQghS', NULL, 0, NULL, NULL, 0, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

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
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `lokasi_anda` varchar(255) DEFAULT NULL,
  `deteksi_ip` varchar(255) DEFAULT NULL,
  `log` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Array to string conversion in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:723\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#1 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(723): PDOStatement->bindValue(6, Array, 2)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(583): Illuminate\\Database\\Connection->bindValues(Object(PDOStatement), Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(816): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}(\'insert into `hi...\', Array)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#29 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#70 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#71 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#72 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#73 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#74 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#75 {main}\n\nNext Illuminate\\Database\\QueryException: Array to string conversion (Connection: mysql, SQL: insert into `histories` (`id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `updated_at`, `created_at`) values (2, asukaloid.blog@gmail.com, Change profile information, Lokasi : (Lat : -7.2484, Long : 112.7419), 125.164.244.223, ?, 1, 2024-05-15 10:02:40, 2024-05-15 10:02:40)) in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:829\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#15 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#70 {main}', 0, '2024-05-15 03:02:40', '2024-05-15 03:02:40');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Array to string conversion in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:723\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#1 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(723): PDOStatement->bindValue(6, Array, 2)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(583): Illuminate\\Database\\Connection->bindValues(Object(PDOStatement), Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(816): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}(\'insert into `hi...\', Array)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#29 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#70 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#71 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#72 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#73 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#74 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#75 {main}\n\nNext Illuminate\\Database\\QueryException: Array to string conversion (Connection: mysql, SQL: insert into `histories` (`id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `updated_at`, `created_at`) values (2, asukaloid.blog@gmail.com, Change profile information, Lokasi : (Lat : -7.2484, Long : 112.7419), 125.164.244.223, ?, 1, 2024-05-15 10:03:34, 2024-05-15 10:03:34)) in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:829\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#15 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#70 {main}', 0, '2024-05-15 03:03:34', '2024-05-15 03:03:34'),
(3, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', NULL, 1, '2024-05-15 03:05:52', '2024-05-15 03:05:52'),
(4, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', NULL, 1, '2024-05-15 03:06:05', '2024-05-15 03:06:05');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(5, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Array to string conversion in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:723\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#1 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Array to string...\', \'D:\\\\Projects\\\\Web...\', 723)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(723): PDOStatement->bindValue(6, Array, 2)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(583): Illuminate\\Database\\Connection->bindValues(Object(PDOStatement), Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(816): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}(\'insert into `hi...\', Array)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#29 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#70 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#71 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#72 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#73 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#74 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#75 {main}\n\nNext Illuminate\\Database\\QueryException: Array to string conversion (Connection: mysql, SQL: insert into `histories` (`id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `updated_at`, `created_at`) values (2, asukaloid.blog@gmail.com, Change profile information, Lokasi : (Lat : -7.2484, Long : 112.7419), 125.164.244.223, ?, 1, 2024-05-15 10:08:23, 2024-05-15 10:08:23)) in D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php:829\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(783): Illuminate\\Database\\Connection->runQueryCallback(\'insert into `hi...\', Array, Object(Closure))\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(576): Illuminate\\Database\\Connection->run(\'insert into `hi...\', Array, Object(Closure))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Connection.php(540): Illuminate\\Database\\Connection->statement(\'insert into `hi...\', Array)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Processors\\Processor.php(32): Illuminate\\Database\\Connection->insert(\'insert into `hi...\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Query\\Builder.php(3507): Illuminate\\Database\\Query\\Processors\\Processor->processInsertGetId(Object(Illuminate\\Database\\Query\\Builder), \'insert into `hi...\', Array, \'id\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1982): Illuminate\\Database\\Query\\Builder->insertGetId(Array, \'id\')\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1333): Illuminate\\Database\\Eloquent\\Builder->__call(\'insertGetId\', Array)\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1298): Illuminate\\Database\\Eloquent\\Model->insertAndSetId(Object(Illuminate\\Database\\Eloquent\\Builder), Array)\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(1137): Illuminate\\Database\\Eloquent\\Model->performInsert(Object(Illuminate\\Database\\Eloquent\\Builder))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1025): Illuminate\\Database\\Eloquent\\Model->save()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\helpers.php(307): Illuminate\\Database\\Eloquent\\Builder->Illuminate\\Database\\Eloquent\\{closure}(Object(App\\Models\\History))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php(1024): tap(Object(App\\Models\\History), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create(Array)\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2334): Illuminate\\Database\\Eloquent\\Model->forwardCallTo(Object(Illuminate\\Database\\Eloquent\\Builder), \'create\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Model.php(2346): Illuminate\\Database\\Eloquent\\Model->__call(\'create\', Array)\n#15 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(137): Illuminate\\Database\\Eloquent\\Model::__callStatic(\'create\', Array)\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->profileInfoUpdate(Object(Illuminate\\Http\\Request))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'profileInfoUpda...\', Array)\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'profileInfoUpda...\')\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#67 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#69 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#70 {main}', 0, '2024-05-15 03:08:23', '2024-05-15 03:08:23'),
(6, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', NULL, 1, '2024-05-15 03:10:22', '2024-05-15 03:10:22'),
(7, 2, 'asukaloid.blog@gmail.com', 'Change profile information', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_tenants` where `detail_tenants`.`id_tenant` = ? and `detail_tenants`.`id_tenant` is not null limit 1\",\"bindings\":[2],\"time\":0.49},{\"query\":\"select * from `detail_tenants` where `id_tenant` = ? and `email` = ? and `detail_tenants`.`id` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",2],\"time\":0.35},{\"query\":\"select * from `tenants` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.34},{\"query\":\"update `tenants` set `name` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Anrdiansyah Indra Putrqaa\",\"2024-05-15 10:13:08\",2],\"time\":3.13}]', 1, '2024-05-15 03:13:08', '2024-05-15 03:13:08'),
(8, 2, 'asukaloid.blog@gmail.com', 'Change Password : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"107904\"],\"time\":0.64},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-15 10:23:00\",24],\"time\":3.47},{\"query\":\"update `tenants` set `password` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"$2y$12$WORIOl3L9E.5MdEYVAq2Ou9MPRJTQlrupMR0YVBv84C9Z0M6D6pqa\",\"2024-05-15 10:23:01\",2],\"time\":2.05}]', 1, '2024-05-15 03:23:01', '2024-05-15 03:23:01'),
(9, 2, 'asukaloid.blog@gmail.com', 'Change Password : OTP Fail doesn\'t match', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '{\"status\":false,\"message\":\"OTP does not exist\"}', 0, '2024-05-15 03:25:48', '2024-05-15 03:25:48'),
(10, 2, 'asukaloid.blog@gmail.com', 'Change Password : Error', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Undefined property: Illuminate\\Auth\\AuthManager::$user in D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php:191\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Undefined prope...\', \'D:\\\\Projects\\\\Web...\', 191)\n#1 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(191): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Undefined prope...\', \'D:\\\\Projects\\\\Web...\', 191)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->passwordUpdate(Object(Illuminate\\Http\\Request))\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'passwordUpdate\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'passwordUpdate\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#8 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#10 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#56 {main}', 1, '2024-05-15 03:26:38', '2024-05-15 03:26:38'),
(11, 2, 'asukaloid.blog@gmail.com', 'Update Store Profile : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.48},{\"query\":\"update `store_details` set `name` = ?, `store_details`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Toko Komputer Surabayaaaa\",\"2024-05-15 10:35:20\",2],\"time\":2.98}]', 1, '2024-05-15 03:35:20', '2024-05-15 03:35:20'),
(12, 2, 'asukaloid.blog@gmail.com', 'Update Store Profile : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.74},{\"query\":\"update `store_details` set `name` = ?, `store_details`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Toko Komputer Surabaya\",\"2024-05-15 10:35:28\",2],\"time\":2.97}]', 1, '2024-05-15 03:35:28', '2024-05-15 03:35:28'),
(13, 2, 'asukaloid.blog@gmail.com', 'Whatsapp Number Verification : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"780799\"],\"time\":0.5},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-15 10:51:07\",26],\"time\":2.88},{\"query\":\"select * from `tenants` where `tenants`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.44},{\"query\":\"update `tenants` set `phone_number_verified_at` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"2024-05-15T03:51:07.525260Z\",\"2024-05-15 10:51:07\",2],\"time\":1.28}]', 1, '2024-05-15 03:51:07', '2024-05-15 03:51:07');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(14, 2, 'asukaloid.blog@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_tenants` where `detail_tenants`.`id_tenant` = ? and `detail_tenants`.`id_tenant` is not null limit 1\",\"bindings\":[2],\"time\":0.83},{\"query\":\"select * from `detail_tenants` where `id_tenant` = ? and `email` = ? and `detail_tenants`.`id` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",2],\"time\":0.64},{\"query\":\"select * from `tenants` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.63},{\"query\":\"update `tenants` set `name` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Anrdiansyah Indra Putrqa\",\"2024-05-15 10:51:16\",2],\"time\":3.28}]', 1, '2024-05-15 03:51:16', '2024-05-15 03:51:16'),
(15, 2, 'asukaloid.blog@gmail.com', 'Tambah Kasir Baru : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.55},{\"query\":\"insert into `kasirs` (`name`, `email`, `phone`, `password`, `id_store`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"Budi Rahman\",\"rahmanbudiindra@gmail.com\",\"087667766778\",\"$2y$12$\\/KvWExLmAvFrdFSOZvGGZuCPlkqf.x6pF7cFLZQ9Xvch\\/kyQSIS7C\",\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"2024-05-15 11:06:33\",\"2024-05-15 11:06:33\"],\"time\":3.48},{\"query\":\"insert into `detail_kasirs` (`id_kasir`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[4,\"rahmanbudiindra@gmail.com\",\"3456765676567654\",\"Surabaya\",\"1996-05-15\",\"Laki-laki\",\"Surabaya\",\"2024-05-15 11:06:33\",\"2024-05-15 11:06:33\"],\"time\":1.9}]', 1, '2024-05-15 04:06:33', '2024-05-15 04:06:33'),
(16, 2, 'asukaloid.blog@gmail.com', 'Add Supplier : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.48},{\"query\":\"insert into `suppliers` (`store_identifier`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"PT Sumber Tekno\",\"sumbertekno@gmail.com\",\"08767655567876\",\"Surabaya\",\"Supplier Sparepart Laptop\",\"2024-05-15 11:11:07\",\"2024-05-15 11:11:07\"],\"time\":2.97}]', 1, '2024-05-15 04:11:07', '2024-05-15 04:11:07'),
(17, 2, 'asukaloid.blog@gmail.com', 'Update Supplier : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.42},{\"query\":\"select * from `suppliers` where `store_identifier` = ? and `suppliers`.`id` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"9\"],\"time\":0.3},{\"query\":\"update `suppliers` set `nama_supplier` = ?, `suppliers`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"PT Sumber Tekno Indotama\",\"2024-05-15 11:18:34\",9],\"time\":2.98}]', 1, '2024-05-15 04:18:34', '2024-05-15 04:18:34'),
(18, 2, 'asukaloid.blog@gmail.com', 'Add Batch Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.59},{\"query\":\"insert into `batches` (`store_identifier`, `batch_code`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"PTR\",\"Printer Product\",\"2024-05-15 11:36:43\",\"2024-05-15 11:36:43\"],\"time\":3.01}]', 1, '2024-05-15 04:36:43', '2024-05-15 04:36:43'),
(19, 2, 'asukaloid.blog@gmail.com', 'Add Data Batch Product : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.6},{\"query\":\"select max(`index_number`) as aggregate from `products` where `store_identifier` = ? and `id_batch` = ?\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"10\"],\"time\":0.55},{\"query\":\"select * from `batches` where `batches`.`id` = ? limit 1\",\"bindings\":[\"10\"],\"time\":0.44},{\"query\":\"insert into `products` (`store_identifier`, `id_batch`, `id_category`, `product_name`, `id_supplier`, `photo`, `nomor_gudang`, `nomor_rak`, `harga_jual`, `index_number`, `product_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"10\",\"9\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"9\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB-1715748935.jpg\",\"1\",\"1\",100,1,\"ACS-000001\",\"2024-05-15 11:55:35\",\"2024-05-15 11:55:35\"],\"time\":1.6}]', 1, '2024-05-15 04:55:35', '2024-05-15 04:55:35'),
(20, 2, 'asukaloid.blog@gmail.com', 'Add Data Product Stock : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.51},{\"query\":\"insert into `product_stocks` (`store_identifier`, `id_batch_product`, `barcode`, `tanggal_beli`, `tanggal_expired`, `harga_beli`, `stok`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"10\",\"32434324243\",\"2024-04-29\",null,\"80\",\"400\",\"2024-05-15 12:14:05\",\"2024-05-15 12:14:05\"],\"time\":3.93}]', 1, '2024-05-15 05:14:05', '2024-05-15 05:14:05'),
(21, NULL, 'asukaloid.blog@gmail.com', 'Login : Error', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Attempt to read property \"id\" on null in D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\LoginController.php:80\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Attempt to read...\', \'D:\\\\Projects\\\\Web...\', 80)\n#1 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\LoginController.php(80): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Attempt to read...\', \'D:\\\\Projects\\\\Web...\', 80)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\LoginController->store(Object(Illuminate\\Http\\Request))\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'store\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\LoginController), \'store\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#8 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\RedirectIfAuthenticated.php(45): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\RedirectIfAuthenticated->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#52 {main}', 0, '2024-05-15 05:28:24', '2024-05-15 05:28:24'),
(22, NULL, 'asukaloid.blog@gmail.com', 'Login : Error', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'ErrorException: Attempt to read property \"id\" on null in D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\LoginController.php:80\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Attempt to read...\', \'D:\\\\Projects\\\\Web...\', 80)\n#1 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\LoginController.php(80): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Attempt to read...\', \'D:\\\\Projects\\\\Web...\', 80)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\LoginController->store(Object(Illuminate\\Http\\Request))\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'store\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\LoginController), \'store\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#8 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\RedirectIfAuthenticated.php(45): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\RedirectIfAuthenticated->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#52 {main}', 0, '2024-05-15 05:28:55', '2024-05-15 05:28:55'),
(23, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":14.11}]', 1, '2024-05-15 05:31:18', '2024-05-15 05:31:18'),
(24, NULL, 'asukaloid.blog@gmnnail.com', 'Login : Login Gagal (Username atau Password salah!)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmnnail.com\"],\"time\":24.24}]', 0, '2024-05-15 05:31:59', '2024-05-15 05:31:59'),
(26, NULL, 'asukaloid.blog@gmail.scom', 'Login : Login Gagal (Username atau Password salah!)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.scom\"],\"time\":2.31}]', 0, '2024-05-15 05:33:29', '2024-05-15 05:33:29'),
(27, NULL, 'asukaloid.blog@gmail.scom', 'Login : Login Gagal (Username atau Password salah!)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.scom\"],\"time\":2}]', 0, '2024-05-15 05:34:05', '2024-05-15 05:34:05'),
(28, NULL, 'asukaloid.blog@gmail.scom', 'Login : Login Gagal (Username atau Password salah!)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.scom\"],\"time\":24.53}]', 0, '2024-05-15 05:35:22', '2024-05-15 05:35:22'),
(29, NULL, 'apriyambodo487@gmail.com', 'Register Tenant : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select count(*) as aggregate from `admins` where `email` = ?\",\"bindings\":[\"apriyambodo487@gmail.com\"],\"time\":3.22},{\"query\":\"select count(*) as aggregate from `marketings` where `email` = ?\",\"bindings\":[\"apriyambodo487@gmail.com\"],\"time\":1.36},{\"query\":\"select count(*) as aggregate from `tenants` where `email` = ?\",\"bindings\":[\"apriyambodo487@gmail.com\"],\"time\":0.31},{\"query\":\"select count(*) as aggregate from `kasirs` where `email` = ?\",\"bindings\":[\"apriyambodo487@gmail.com\"],\"time\":0.27},{\"query\":\"select count(*) as aggregate from `detail_admins` where `no_ktp` = ?\",\"bindings\":[\"9876567876545678\"],\"time\":1.23},{\"query\":\"select count(*) as aggregate from `detail_marketings` where `no_ktp` = ?\",\"bindings\":[\"9876567876545678\"],\"time\":0.56},{\"query\":\"select count(*) as aggregate from `detail_tenants` where `no_ktp` = ?\",\"bindings\":[\"9876567876545678\"],\"time\":0.8},{\"query\":\"select count(*) as aggregate from `detail_kasirs` where `no_ktp` = ?\",\"bindings\":[\"9876567876545678\"],\"time\":0.34},{\"query\":\"select count(*) as aggregate from `admins` where `phone` = ?\",\"bindings\":[\"087677677373338\"],\"time\":0.56},{\"query\":\"select count(*) as aggregate from `marketings` where `phone` = ?\",\"bindings\":[\"087677677373338\"],\"time\":0.58},{\"query\":\"select count(*) as aggregate from `tenants` where `phone` = ?\",\"bindings\":[\"087677677373338\"],\"time\":0.19},{\"query\":\"select count(*) as aggregate from `kasirs` where `phone` = ?\",\"bindings\":[\"087677677373338\"],\"time\":0.2},{\"query\":\"select count(*) as aggregate from `invitation_codes` where `inv_code` = ? and (`inv_code` = ?)\",\"bindings\":[\"XANT6\",\"XANT6\"],\"time\":0.41},{\"query\":\"select * from `invitation_codes` where `inv_code` = ? limit 1\",\"bindings\":[\"XANT6\"],\"time\":0.57},{\"query\":\"insert into `tenants` (`name`, `email`, `phone`, `password`, `id_inv_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"Indra Syahputra\",\"apriyambodo487@gmail.com\",\"087677677373338\",\"$2y$12$UbjO17qgswec2TIzlt0OIucmP9zSm3X3oMH5HOD59zR74HkW5zNaO\",2,\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":3.57},{\"query\":\"insert into `detail_tenants` (`id_tenant`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[4,\"apriyambodo487@gmail.com\",\"9876567876545678\",\"Surabaya\",\"2000-01-08\",\"Laki-laki\",\"Surabaya\",\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.32},{\"query\":\"insert into `tenant_fields` (`store_identifier`, `baris1`, `baris2`, `baris3`, `baris4`, `baris5`, `baris_1_activation`, `baris_2_activation`, `baris_3_activation`, `baris_4_activation`, `baris_5_activation`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"DPpU35sGVTUiVpYsj4p1B9MRVdQghS\",\"Nama Pelanggan\",\"Kota Asal\",\"Alamat Pelanggan\",\"Email Pelanggan\",\"No. Telp.\\/WA\",1,1,1,1,1,\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":3.13},{\"query\":\"insert into `store_details` (`store_identifier`, `id_tenant`, `email`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"DPpU35sGVTUiVpYsj4p1B9MRVdQghS\",4,\"apriyambodo487@gmail.com\",\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.17},{\"query\":\"insert into `taxes` (`store_identifier`, `updated_at`, `created_at`) values (?, ?, ?)\",\"bindings\":[\"DPpU35sGVTUiVpYsj4p1B9MRVdQghS\",\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.9},{\"query\":\"insert into `discounts` (`store_identifier`, `updated_at`, `created_at`) values (?, ?, ?)\",\"bindings\":[\"DPpU35sGVTUiVpYsj4p1B9MRVdQghS\",\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.35},{\"query\":\"insert into `tunai_wallets` (`id_tenant`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[4,\"apriyambodo487@gmail.com\",0,\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.09},{\"query\":\"insert into `rekenings` (`id_user`, `email`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[4,\"apriyambodo487@gmail.com\",\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":2.64},{\"query\":\"insert into `qris_wallets` (`id_user`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[4,\"apriyambodo487@gmail.com\",0,\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":1.47},{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"apriyambodo487@gmail.com\",true],\"time\":0.53},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"apriyambodo487@gmail.com\",\"084240\",30,\"2024-05-15 12:46:48\",\"2024-05-15 12:46:48\"],\"time\":3.09}]', 1, '2024-05-15 05:46:53', '2024-05-15 05:46:53'),
(30, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":2.73}]', 1, '2024-05-15 05:56:03', '2024-05-15 05:56:03'),
(31, 2, 'asukaloid.blog@gmail.com', 'Create Transaction Success : VP15052024125621000000056', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.43},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.29},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `jenis_pembayaran`, `nominal_bayar`, `kembalian`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `tanggal_pelunasan`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"asukaloid.blog@gmail.com\",2,null,\"Tunai\",\"110\",3,1,\"98.00\",\"9.80\",\"2.00\",\"2024-05-15T05:56:21.722506Z\",\"2024-05-15T05:56:21.722515Z\",\"VP15052024125621000000056\",\"2024-05-15 12:56:21\",\"2024-05-15 12:56:21\"],\"time\":3.49},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[56,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 12:56:21\",\"2024-05-15 12:56:21\"],\"time\":1.7},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.43},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[399,\"2024-05-15 12:56:21\",11],\"time\":1.19},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[56,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 12:56:21\",\"2024-05-15 12:56:21\"],\"time\":2.03},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[56],\"time\":0.88},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[56,\"\",\"2024-05-15 12:56:21\",\"2024-05-15 12:56:21\"],\"time\":1.17},{\"query\":\"select * from `tunai_wallets` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.41},{\"query\":\"update `tunai_wallets` set `saldo` = ?, `tunai_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[2257.4,\"2024-05-15 12:56:21\",2],\"time\":1.09}]', 1, '2024-05-15 05:56:21', '2024-05-15 05:56:21'),
(32, 2, 'asukaloid.blog@gmail.com', 'Create Transaction Success : VP15052024130059000000057', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.42},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.34},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `jenis_pembayaran`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `nominal_bayar`, `tanggal_transaksi`, `nomor_invoice`, `qris_data`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"asukaloid.blog@gmail.com\",2,null,\"Qris\",0,\"98.00\",\"9.80\",\"2.00\",\"107.80\",\"2024-05-15T06:00:59.552231Z\",\"VP15052024130059000000057\",\"00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054031075802ID5908VISIONER6008SURABAYA61056125662610114051506753390730625VP150520241300590000000570702VP0804POSP6304B500\",\"2024-05-15 13:01:00\",\"2024-05-15 13:01:00\"],\"time\":2.92},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[57,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 13:01:00\",\"2024-05-15 13:01:00\"],\"time\":1.14},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.4},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[398,\"2024-05-15 13:01:00\",11],\"time\":1.03},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[57,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 13:01:00\",\"2024-05-15 13:01:00\"],\"time\":1.02},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[57],\"time\":0.3},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[57,\"\",\"2024-05-15 13:01:00\",\"2024-05-15 13:01:00\"],\"time\":1.28}]', 1, '2024-05-15 06:01:00', '2024-05-15 06:01:00'),
(33, 2, 'asukaloid.blog@gmail.com', 'Change Payment For Transaction : VP15052024130059000000057', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.61},{\"query\":\"select * from `invoices` where `store_identifier` = ? and `invoices`.`id` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"57\"],\"time\":1.26},{\"query\":\"update `invoices` set `tanggal_pelunasan` = ?, `jenis_pembayaran` = ?, `qris_data` = ?, `status_pembayaran` = ?, `nominal_bayar` = ?, `kembalian` = ?, `invoices`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"2024-05-15T06:01:20.921892Z\",\"Tunai\",null,1,\"110\",3,\"2024-05-15 13:01:20\",57],\"time\":1.42}]', 1, '2024-05-15 06:01:20', '2024-05-15 06:01:20'),
(34, 2, 'asukaloid.blog@gmail.com', 'Create Transaction Save : VP15052024130601000000058', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":1.45},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":1.26},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"asukaloid.blog@gmail.com\",2,null,\"2024-05-15T06:06:01.194065Z\",\"VP15052024130601000000058\",\"2024-05-15 13:06:01\",\"2024-05-15 13:06:01\"],\"time\":4.38},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[58,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 13:06:01\",\"2024-05-15 13:06:01\"],\"time\":2.84},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":1.31},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[397,\"2024-05-15 13:06:01\",11],\"time\":2.05},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `description`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[58,\"Yuli Indri\",null,\"2024-05-15 13:06:01\",\"2024-05-15 13:06:01\"],\"time\":1.94}]', 1, '2024-05-15 06:06:01', '2024-05-15 06:06:01'),
(35, 2, 'asukaloid.blog@gmail.com', 'Delete Pending Transaction : VP15052024130601000000058', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.53},{\"query\":\"select * from `invoices` where `store_identifier` = ? and `jenis_pembayaran` is null and `invoices`.`id` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"58\"],\"time\":0.64},{\"query\":\"select * from `shopping_carts` where `id_invoice` = ?\",\"bindings\":[58],\"time\":1.37},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[11],\"time\":0.68},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[398,\"2024-05-15 13:09:41\",11],\"time\":3.26},{\"query\":\"delete from `shopping_carts` where `id` = ?\",\"bindings\":[64],\"time\":1.76},{\"query\":\"delete from `invoices` where `id` = ?\",\"bindings\":[58],\"time\":1.73}]', 1, '2024-05-15 06:09:41', '2024-05-15 06:09:41'),
(36, 2, 'asukaloid.blog@gmail.com', 'Create Transaction Success : VP15052024131545000000058', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.6},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.4},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `jenis_pembayaran`, `nominal_bayar`, `kembalian`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `tanggal_pelunasan`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"asukaloid.blog@gmail.com\",2,null,\"Tunai\",\"110\",3,1,\"98.00\",\"9.80\",\"2.00\",\"2024-05-15T06:15:45.974419Z\",\"2024-05-15T06:15:45.974428Z\",\"VP15052024131545000000058\",\"2024-05-15 13:15:45\",\"2024-05-15 13:15:45\"],\"time\":3.03},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[59,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 13:15:45\",\"2024-05-15 13:15:45\"],\"time\":1.3},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.53},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[397,\"2024-05-15 13:15:45\",11],\"time\":1.35},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[59,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 13:15:45\",\"2024-05-15 13:15:45\"],\"time\":1.51},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[59],\"time\":2.5},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[59,\"\",\"2024-05-15 13:15:45\",\"2024-05-15 13:15:45\"],\"time\":1.35},{\"query\":\"select * from `tunai_wallets` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":1.92},{\"query\":\"update `tunai_wallets` set `saldo` = ?, `tunai_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[2365.2000000000003,\"2024-05-15 13:15:45\",2],\"time\":1.34}]', 1, '2024-05-15 06:15:45', '2024-05-15 06:15:45');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(37, 2, 'asukaloid.blog@gmail.com', 'Create Transaction Save : VP15052024131605000000060', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.49},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.31},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"asukaloid.blog@gmail.com\",2,null,\"2024-05-15T06:16:05.738782Z\",\"VP15052024131605000000060\",\"2024-05-15 13:16:05\",\"2024-05-15 13:16:05\"],\"time\":1.22},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[60,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 13:16:05\",\"2024-05-15 13:16:05\"],\"time\":1.07},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.33},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[396,\"2024-05-15 13:16:05\",11],\"time\":0.96},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `description`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[60,\"Mega Kurnia\",null,\"2024-05-15 13:16:05\",\"2024-05-15 13:16:05\"],\"time\":0.87}]', 1, '2024-05-15 06:16:05', '2024-05-15 06:16:05'),
(38, 2, 'asukaloid.blog@gmail.com', 'Transaction Pending Process : VP15052024131605000000060', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.97},{\"query\":\"select * from `invoices` where `store_identifier` = ? and `invoices`.`id` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"60\"],\"time\":1.08},{\"query\":\"update `invoices` set `tanggal_pelunasan` = ?, `jenis_pembayaran` = ?, `status_pembayaran` = ?, `sub_total` = ?, `pajak` = ?, `diskon` = ?, `nominal_bayar` = ?, `kembalian` = ?, `invoices`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"2024-05-15T06:16:42.118667Z\",\"Tunai\",1,\"98\",\"9.8\",\"2\",\"110\",3,\"2024-05-15 13:16:42\",60],\"time\":3.82},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[60,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 13:16:42\",\"2024-05-15 13:16:42\"],\"time\":1.92},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[60],\"time\":0.96},{\"query\":\"update `customer_identifiers` set `customer_info` = ?, `customer_identifiers`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"\",\"2024-05-15 13:16:42\",57],\"time\":2.02},{\"query\":\"select * from `tunai_wallets` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.98},{\"query\":\"update `tunai_wallets` set `saldo` = ?, `tunai_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[2473,\"2024-05-15 13:16:42\",2],\"time\":1.55}]', 1, '2024-05-15 06:16:42', '2024-05-15 06:16:42'),
(39, NULL, 'indiraputri456@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `kasirs` where `email` = ? limit 1\",\"bindings\":[\"indiraputri456@gmail.com\"],\"time\":4.2}]', 1, '2024-05-15 06:25:02', '2024-05-15 06:25:02'),
(40, 2, 'indiraputri456@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_kasirs` where `detail_kasirs`.`id_kasir` = ? and `detail_kasirs`.`id_kasir` is not null limit 1\",\"bindings\":[2],\"time\":0.61},{\"query\":\"select * from `detail_kasirs` where `email` = ? and `detail_kasirs`.`id` = ? limit 1\",\"bindings\":[\"indiraputri456@gmail.com\",2],\"time\":0.44},{\"query\":\"select * from `kasirs` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"indiraputri456@gmail.com\"],\"time\":0.43},{\"query\":\"update `kasirs` set `name` = ?, `kasirs`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Inayah Indah Putri\",\"2024-05-15 13:47:03\",2],\"time\":3.25}]', 1, '2024-05-15 06:47:03', '2024-05-15 06:47:03'),
(41, 2, 'indiraputri456@gmail.com', 'Change Password : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"update `kasirs` set `password` = ?, `kasirs`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"$2y$12$Vrpz6Kj2qQNl6kQ.d16R8.Mm4GdBYlVpdUpsctS47Ojl19\\/e9tiH6\",\"2024-05-15 13:52:57\",2],\"time\":3.39}]', 1, '2024-05-15 06:52:57', '2024-05-15 06:52:57'),
(42, 2, 'indiraputri456@gmail.com', 'Create Transaction Save : VP15052024142252000000061', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `store_details`.`store_identifier` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\"],\"time\":3.15},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.47},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"indiraputri456@gmail.com\",\"2\",2,\"2024-05-15T07:22:52.634195Z\",\"VP15052024142252000000061\",\"2024-05-15 14:22:52\",\"2024-05-15 14:22:52\"],\"time\":1.88},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[61,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 14:22:52\",\"2024-05-15 14:22:52\"],\"time\":1.38},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.89},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[395,\"2024-05-15 14:22:52\",11],\"time\":1.08},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `description`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[61,\"Fina Safitri\",null,\"2024-05-15 14:22:52\",\"2024-05-15 14:22:52\"],\"time\":1.24}]', 1, '2024-05-15 07:22:52', '2024-05-15 07:22:52'),
(43, 2, 'indiraputri456@gmail.com', 'Create Transaction Success : VP15052024142529000000062', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `store_details`.`store_identifier` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\"],\"time\":0.47},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":2.17},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `jenis_pembayaran`, `nominal_bayar`, `kembalian`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `tanggal_pelunasan`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"indiraputri456@gmail.com\",\"2\",2,\"Tunai\",\"110\",3,1,\"98.00\",\"9.80\",\"2.00\",\"2024-05-15T07:25:29.126974Z\",\"2024-05-15T07:25:29.126983Z\",\"VP15052024142529000000062\",\"2024-05-15 14:25:29\",\"2024-05-15 14:25:29\"],\"time\":1.17},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[62,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 14:25:29\",\"2024-05-15 14:25:29\"],\"time\":1.11},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.41},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[394,\"2024-05-15 14:25:29\",11],\"time\":1.17},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[62,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 14:25:29\",\"2024-05-15 14:25:29\"],\"time\":1.8},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[62],\"time\":0.33},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[62,\"\",\"2024-05-15 14:25:29\",\"2024-05-15 14:25:29\"],\"time\":1.05},{\"query\":\"select * from `tunai_wallets` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[\"2\",\"asukaloid.blog@gmail.com\"],\"time\":0.57},{\"query\":\"update `tunai_wallets` set `saldo` = ?, `tunai_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[2580.8,\"2024-05-15 14:25:29\",2],\"time\":1.1}]', 1, '2024-05-15 07:25:29', '2024-05-15 07:25:29'),
(44, 2, 'indiraputri456@gmail.com', 'Create Transaction Success : VP15052024142530000000063', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `store_details`.`store_identifier` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\"],\"time\":0.57},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.29},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `jenis_pembayaran`, `nominal_bayar`, `kembalian`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `tanggal_pelunasan`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"indiraputri456@gmail.com\",\"2\",2,\"Tunai\",\"110\",3,1,\"0.00\",\"0.00\",\"0.00\",\"2024-05-15T07:25:30.324288Z\",\"2024-05-15T07:25:30.324299Z\",\"VP15052024142530000000063\",\"2024-05-15 14:25:30\",\"2024-05-15 14:25:30\"],\"time\":2.9},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[63,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 14:25:30\",\"2024-05-15 14:25:30\"],\"time\":1.15},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[63],\"time\":0.33},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[63,\"\",\"2024-05-15 14:25:30\",\"2024-05-15 14:25:30\"],\"time\":1.02},{\"query\":\"select * from `tunai_wallets` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[\"2\",\"asukaloid.blog@gmail.com\"],\"time\":0.34}]', 1, '2024-05-15 07:25:30', '2024-05-15 07:25:30'),
(45, 2, 'indiraputri456@gmail.com', 'Create Transaction Save : VP15052024143705000000064', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `store_details`.`store_identifier` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\"],\"time\":0.77},{\"query\":\"select max(`id`) as aggregate from `invoices`\",\"bindings\":[],\"time\":0.51},{\"query\":\"insert into `invoices` (`store_identifier`, `email`, `id_tenant`, `id_kasir`, `tanggal_transaksi`, `nomor_invoice`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",\"indiraputri456@gmail.com\",\"2\",2,\"2024-05-15T07:37:05.453284Z\",\"VP15052024143705000000064\",\"2024-05-15 14:37:05\",\"2024-05-15 14:37:05\"],\"time\":3.08},{\"query\":\"insert into `shopping_carts` (`id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[64,\"11\",\"Flashdisk Sandisk Cruzer Blade 128GBBBBB\",\"1\",100,100,\"2024-05-15 14:37:05\",\"2024-05-15 14:37:05\"],\"time\":1.46},{\"query\":\"select * from `product_stocks` where `product_stocks`.`id` = ? limit 1\",\"bindings\":[\"11\"],\"time\":0.56},{\"query\":\"update `product_stocks` set `stok` = ?, `product_stocks`.`updated_at` = ? where `id` = ?\",\"bindings\":[393,\"2024-05-15 14:37:05\",11],\"time\":13.26},{\"query\":\"insert into `customer_identifiers` (`id_invoice`, `customer_info`, `description`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[64,\"Budi\",null,\"2024-05-15 14:37:05\",\"2024-05-15 14:37:05\"],\"time\":4.26}]', 1, '2024-05-15 07:37:05', '2024-05-15 07:37:05'),
(46, 2, 'indiraputri456@gmail.com', 'Transaction Pending Process : VP15052024143705000000064', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `store_details`.`store_identifier` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\"],\"time\":0.56},{\"query\":\"select * from `invoices` where `store_identifier` = ? and `id_kasir` = ? and `id_tenant` = ? and `email` = ? and `invoices`.`id` = ? limit 1\",\"bindings\":[\"SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb\",2,\"2\",\"indiraputri456@gmail.com\",\"64\"],\"time\":0.43},{\"query\":\"update `invoices` set `tanggal_pelunasan` = ?, `jenis_pembayaran` = ?, `qris_data` = ?, `sub_total` = ?, `pajak` = ?, `diskon` = ?, `nominal_bayar` = ?, `invoices`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"2024-05-15T07:37:27.530873Z\",\"Qris\",\"00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054031075802ID5908VISIONER6008SURABAYA61056125662610114051506756194020625VP150520241437050000000640702VP0804POSP6304D845\",\"98\",\"9.8\",\"2\",107,\"2024-05-15 14:37:27\",64],\"time\":3.31},{\"query\":\"insert into `invoice_fields` (`id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[64,\"\",\"\",\"\",\"\",\"\",\"2024-05-15 14:37:27\",\"2024-05-15 14:37:27\"],\"time\":1.34},{\"query\":\"select * from `customer_identifiers` where `id_invoice` = ? limit 1\",\"bindings\":[64],\"time\":0.37},{\"query\":\"update `customer_identifiers` set `customer_info` = ?, `customer_identifiers`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"\",\"2024-05-15 14:37:27\",61],\"time\":1.13}]', 1, '2024-05-15 07:37:27', '2024-05-15 07:37:27'),
(47, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":21.54}]', 1, '2024-05-15 07:37:58', '2024-05-15 07:37:58'),
(48, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":2.42}]', 1, '2024-05-15 08:49:07', '2024-05-15 08:49:07'),
(49, NULL, 'asukaloid.blog@gmail.com', 'Login : Login Gagal (Username atau Password salah!)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":4.69}]', 0, '2024-05-15 09:05:30', '2024-05-15 09:05:30'),
(50, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":24.62}]', 1, '2024-05-15 09:05:39', '2024-05-15 09:05:39'),
(51, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":25.64}]', 1, '2024-05-16 01:32:11', '2024-05-16 01:32:11'),
(52, 2, 'asukaloid.blog@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_tenants` where `detail_tenants`.`id_tenant` = ? and `detail_tenants`.`id_tenant` is not null limit 1\",\"bindings\":[2],\"time\":0.49},{\"query\":\"select * from `detail_tenants` where `id_tenant` = ? and `email` = ? and `detail_tenants`.`id` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",2],\"time\":0.32},{\"query\":\"select * from `tenants` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.38},{\"query\":\"update `tenants` set `name` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Anrdiansyah Indra Putra\",\"2024-05-16 08:33:13\",2],\"time\":1.54}]', 1, '2024-05-16 01:33:13', '2024-05-16 01:33:13'),
(53, 2, 'asukaloid.blog@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_tenants` where `detail_tenants`.`id_tenant` = ? and `detail_tenants`.`id_tenant` is not null limit 1\",\"bindings\":[2],\"time\":0.41},{\"query\":\"select * from `detail_tenants` where `id_tenant` = ? and `email` = ? and `detail_tenants`.`id` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",2],\"time\":0.26},{\"query\":\"select * from `tenants` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.25},{\"query\":\"update `tenants` set `name` = ?, `tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Anrdiansyah Indra\",\"2024-05-16 09:08:51\",2],\"time\":1}]', 1, '2024-05-16 02:08:51', '2024-05-16 02:08:51'),
(54, 2, 'asukaloid.blog@gmail.com', 'Tarik dana Qris : OTP Fail doesn\'t match', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '{\"status\":false,\"message\":\"OTP is not valid\"}', 0, '2024-05-16 04:48:01', '2024-05-16 04:48:01'),
(55, 2, 'asukaloid.blog@gmail.com', 'Tarik dana Qris : OTP Fail doesn\'t match', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '{\"status\":false,\"message\":\"OTP is not valid\"}', 0, '2024-05-16 04:48:11', '2024-05-16 04:48:11'),
(56, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.4},{\"query\":\"select `saldo` from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.33},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.28},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.28},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.25},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.38},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.22},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.29},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"799514\"],\"time\":0.3},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 11:58:25\",36],\"time\":1.12},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T04:58:27.661371Z\",\"10000\",1500,\"2024-05-16T04:58:27.661383Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 11:58:27\",\"2024-05-16 11:58:27\"],\"time\":4.22},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` is null\",\"bindings\":[88500,\"2024-05-16 11:58:27\"],\"time\":0.51},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[350,\"2024-05-16 11:58:27\",6],\"time\":2.33}]', 0, '2024-05-16 04:58:27', '2024-05-16 04:58:27'),
(57, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.54},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.4},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.33},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.34},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.36},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.46},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.25},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.34},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"908796\"],\"time\":0.49},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:14:39\",43],\"time\":2.77},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T05:14:42.063942Z\",\"10000\",1500,\"2024-05-16T05:14:42.063955Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 12:14:42\",\"2024-05-16 12:14:42\"],\"time\":1.75},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[88500,\"2024-05-16 12:14:42\",3],\"time\":1.7},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[350,\"2024-05-16 12:14:42\",6],\"time\":1.46}]', 0, '2024-05-16 05:14:42', '2024-05-16 05:14:42'),
(58, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.43},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.33},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":2.37},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.4},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":1.04},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":1.09},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.32},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.35},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"117356\"],\"time\":0.4},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:19:41\",44],\"time\":1.2}]', 0, '2024-05-16 05:19:41', '2024-05-16 05:19:41'),
(59, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Fail (Saldo tidak mencukupi)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.46},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.33},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.27},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.28},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.28},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.4},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.25},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.3},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"186517\"],\"time\":0.28},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:20:54\",45],\"time\":2.65}]', 0, '2024-05-16 05:20:54', '2024-05-16 05:20:54'),
(60, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":1.28},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":1.12},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":1.1},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.98},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.89},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":1.13},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.93},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":1.16},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"857795\"],\"time\":1.13},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:21:26\",46],\"time\":4.31}]', 0, '2024-05-16 05:21:26', '2024-05-16 05:21:26'),
(61, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.45},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.32},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.26},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.34},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.35},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.38},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.3},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.34},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"458399\"],\"time\":0.34},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:22:16\",47],\"time\":2.89}]', 0, '2024-05-16 05:22:16', '2024-05-16 05:22:16'),
(62, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.49},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.46},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.36},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.29},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.35},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.67},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.38},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.67},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"329119\"],\"time\":0.69},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:23:11\",48],\"time\":1.17}]', 0, '2024-05-16 05:23:11', '2024-05-16 05:23:11'),
(63, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.43},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.28},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.27},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.28},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.26},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.43},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.26},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.31},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"164091\"],\"time\":0.42},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:24:21\",49],\"time\":3.23}]', 0, '2024-05-16 05:24:21', '2024-05-16 05:24:21'),
(64, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error (HTTP API Error)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.4},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.29},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.29},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.26},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.29},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.37},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.25},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.35},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"077904\"],\"time\":0.34},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:40:38\",58],\"time\":1.49},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T05:40:41.362548Z\",\"10000\",1500,\"2024-05-16T05:40:41.362579Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 12:40:41\",\"2024-05-16 12:40:41\"],\"time\":4.12},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[54000,\"2024-05-16 12:40:41\",3],\"time\":2.02},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1050,\"2024-05-16 12:40:41\",6],\"time\":2.15},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1000,\"2024-05-16 12:40:41\",1],\"time\":2.16},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[350,\"2024-05-16 12:40:41\",1],\"time\":1.87}]', 0, '2024-05-16 05:40:41', '2024-05-16 05:40:41'),
(65, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.59},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.29},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.24},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.29},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.26},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.41},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.26},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.29},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"475216\"],\"time\":0.36},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:42:22\",59],\"time\":3.14},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T05:42:24.547378Z\",\"10000\",1500,\"2024-05-16T05:42:24.547388Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 12:42:24\",\"2024-05-16 12:42:24\"],\"time\":2.66},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[42500,\"2024-05-16 12:42:24\",3],\"time\":2.63},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1400,\"2024-05-16 12:42:24\",6],\"time\":0.94},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1500,\"2024-05-16 12:42:24\",1],\"time\":0.97},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[700,\"2024-05-16 12:42:24\",1],\"time\":0.94}]', 1, '2024-05-16 05:42:24', '2024-05-16 05:42:24'),
(66, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.52},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.33},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.3},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.31},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":2.41},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":1.05},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.35},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.39},{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"025659\"],\"time\":0.33},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-16 12:45:59\",60],\"time\":1.1},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T05:46:04.288466Z\",\"10000\",1500,\"2024-05-16T05:46:04.288482Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 12:46:04\",\"2024-05-16 12:46:04\"],\"time\":3.43},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[88500,\"2024-05-16 12:46:04\",3],\"time\":1.71},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[350,\"2024-05-16 12:46:04\",6],\"time\":1.79},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[500,\"2024-05-16 12:46:04\",1],\"time\":1.7},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[350,\"2024-05-16 12:46:04\",1],\"time\":1.62},{\"query\":\"insert into `detail_penarikans` (`id_penarikan`, `nominal_penarikan`, `nominal_bersih_penarikan`, `total_biaya_admin`, `biaya_nobu`, `biaya_mitra`, `biaya_admin_su`, `biaya_agregate`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[9,11500,\"10000\",1500,300,500,350,350,\"2024-05-16 12:46:04\",\"2024-05-16 12:46:04\"],\"time\":1.71},{\"query\":\"insert into `nobu_withdraw_fee_histories` (`id_penarikan`, `nominal`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[9,300,\"2024-05-16 12:46:04\",\"2024-05-16 12:46:04\"],\"time\":1.12}]', 1, '2024-05-16 05:46:04', '2024-05-16 05:46:04'),
(67, 2, 'asukaloid.blog@gmail.com', 'Tarik dana Qris : OTP Fail doesn\'t match', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '{\"status\":false,\"message\":\"OTP is not valid\"}', 0, '2024-05-16 06:34:40', '2024-05-16 06:34:40');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(68, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Error', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', 'ErrorException: Undefined variable ${\"id\":3,\"id_user\":2,\"email\":\"asukaloid.blog@gmail.com\",\"saldo\":\"88500\",\"created_at\":\"2024-05-13T05:35:57.000000Z\",\"updated_at\":\"2024-05-16T05:46:04.000000Z\"} in D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php:713\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(255): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Undefined varia...\', \'D:\\\\Projects\\\\Web...\', 713)\n#1 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(713): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Undefined varia...\', \'D:\\\\Projects\\\\Web...\', 713)\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->tarikDanaQris(Object(Illuminate\\Http\\Request))\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'tarikDanaQris\', Array)\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'tarikDanaQris\')\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#8 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#10 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#11 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#20 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#56 {main}', 0, '2024-05-16 06:38:38', '2024-05-16 06:38:38'),
(69, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Fail (Saldo tidak mencukupi)', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[]', 0, '2024-05-16 06:39:40', '2024-05-16 06:39:40'),
(70, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.74},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.52},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.67},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.49},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.65},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.71},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.33},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.44},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T06:56:23.860896Z\",\"10000\",\"1500\",\"2024-05-16T06:56:23.860904Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 13:56:23\",\"2024-05-16 13:56:23\"],\"time\":3.03},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[77000,\"2024-05-16 13:56:23\",3],\"time\":2.39},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[700,\"2024-05-16 13:56:23\",6],\"time\":0.92},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1000,\"2024-05-16 13:56:23\",1],\"time\":0.95},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[700,\"2024-05-16 13:56:23\",1],\"time\":0.92},{\"query\":\"insert into `detail_penarikans` (`id_penarikan`, `nominal_penarikan`, `nominal_bersih_penarikan`, `total_biaya_admin`, `biaya_nobu`, `biaya_mitra`, `biaya_admin_su`, `biaya_agregate`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[10,\"11500\",\"10000\",\"1500\",300,500,350,350,\"2024-05-16 13:56:23\",\"2024-05-16 13:56:23\"],\"time\":1.54},{\"query\":\"insert into `nobu_withdraw_fee_histories` (`id_penarikan`, `nominal`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[10,300,\"2024-05-16 13:56:23\",\"2024-05-16 13:56:23\"],\"time\":1.99}]', 1, '2024-05-16 06:56:23', '2024-05-16 06:56:23'),
(71, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.93},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.85},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":3.01},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.74},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":1.41},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":2.27},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.73},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.76},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T07:46:25.575913Z\",\"10000\",\"1500\",\"2024-05-16T07:46:25.575922Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 14:46:25\",\"2024-05-16 14:46:25\"],\"time\":3.06},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[65500,\"2024-05-16 14:46:25\",3],\"time\":1.18},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1050,\"2024-05-16 14:46:25\",6],\"time\":1.01},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1500,\"2024-05-16 14:46:25\",1],\"time\":1},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1050,\"2024-05-16 14:46:25\",1],\"time\":1.15},{\"query\":\"insert into `detail_penarikans` (`id_penarikan`, `nominal_penarikan`, `nominal_bersih_penarikan`, `total_biaya_admin`, `biaya_nobu`, `biaya_mitra`, `biaya_admin_su`, `biaya_agregate`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[11,\"11500\",\"10000\",\"1500\",300,500,350,350,\"2024-05-16 14:46:25\",\"2024-05-16 14:46:25\"],\"time\":1.08},{\"query\":\"insert into `nobu_withdraw_fee_histories` (`id_penarikan`, `nominal`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[11,300,\"2024-05-16 14:46:25\",\"2024-05-16 14:46:25\"],\"time\":1.12}]', 1, '2024-05-16 07:46:25', '2024-05-16 07:46:25'),
(72, NULL, 'asukaloid.blog@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"asukaloid.blog@gmail.com\"],\"time\":4.5}]', 1, '2024-05-16 09:04:36', '2024-05-16 09:04:36'),
(73, 2, 'asukaloid.blog@gmail.com', 'Withdraw Process : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[{\"query\":\"select `swift_code`, `no_rekening` from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.48},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[2,\"asukaloid.blog@gmail.com\"],\"time\":0.34},{\"query\":\"select * from `agregate_wallets` where `agregate_wallets`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.32},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? and `qris_wallets`.`id` = ? limit 1\",\"bindings\":[8,\"adminsu@vpos.my.id.com\",6],\"time\":0.27},{\"query\":\"select `invitation_codes`.`id`, `invitation_codes`.`id_marketing` from `invitation_codes` where `invitation_codes`.`id` = ? limit 1\",\"bindings\":[2],\"time\":0.27},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.47},{\"query\":\"select `marketings`.`id`, `marketings`.`email` from `marketings` where `marketings`.`id` in (1)\",\"bindings\":[],\"time\":0.27},{\"query\":\"select * from `qris_wallets` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"ouka.dev@gmail.com\"],\"time\":0.44},{\"query\":\"insert into `withdrawals` (`id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"asukaloid.blog@gmail.com\",\"2024-05-16T09:16:21.825975Z\",\"10000\",\"1500\",\"2024-05-16T09:16:21.826001Z\",\"125.164.243.227\",\"Lokasi : (Lat : -7.2484, Long : 112.7419)\",1,\"2024-05-16 16:16:21\",\"2024-05-16 16:16:21\"],\"time\":3.57},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[54000,\"2024-05-16 16:16:21\",3],\"time\":4.36},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1400,\"2024-05-16 16:16:21\",6],\"time\":1.76},{\"query\":\"update `qris_wallets` set `saldo` = ?, `qris_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[2000,\"2024-05-16 16:16:21\",1],\"time\":1.84},{\"query\":\"update `agregate_wallets` set `saldo` = ?, `agregate_wallets`.`updated_at` = ? where `id` = ?\",\"bindings\":[1400,\"2024-05-16 16:16:21\",1],\"time\":1.29},{\"query\":\"insert into `detail_penarikans` (`id_penarikan`, `nominal_penarikan`, `nominal_bersih_penarikan`, `total_biaya_admin`, `biaya_nobu`, `biaya_mitra`, `biaya_admin_su`, `biaya_agregate`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[12,\"11500\",\"10000\",\"1500\",300,500,350,350,\"2024-05-16 16:16:21\",\"2024-05-16 16:16:21\"],\"time\":1.92},{\"query\":\"insert into `nobu_withdraw_fee_histories` (`id_penarikan`, `nominal`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[12,300,\"2024-05-16 16:16:21\",\"2024-05-16 16:16:21\"],\"time\":1.27}]', 1, '2024-05-16 09:16:21', '2024-05-16 09:16:21');

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
(1, 1, 'INDR1', 'Indira', 0, 1, '2024-05-08 19:08:59', '2024-05-08 19:08:59'),
(2, 1, 'XANT6', 'Susanto', 0, 1, '2024-05-08 19:09:16', '2024-05-08 19:09:16'),
(3, 1, 'GHJ78', 'Budi Rahman', 0, 1, '2024-05-08 19:09:36', '2024-05-08 19:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `id_kasir` bigint(20) DEFAULT NULL,
  `nomor_invoice` varchar(255) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `tanggal_pelunasan` date DEFAULT NULL,
  `jenis_pembayaran` varchar(255) DEFAULT NULL,
  `qris_data` text DEFAULT NULL,
  `status_pembayaran` int(11) NOT NULL DEFAULT 0,
  `sub_total` varchar(255) DEFAULT NULL,
  `pajak` varchar(255) DEFAULT NULL,
  `diskon` varchar(255) DEFAULT NULL,
  `nominal_bayar` varchar(255) DEFAULT NULL,
  `kembalian` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `store_identifier`, `email`, `id_tenant`, `id_kasir`, `nomor_invoice`, `tanggal_transaksi`, `tanggal_pelunasan`, `jenis_pembayaran`, `qris_data`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `nominal_bayar`, `kembalian`, `created_at`, `updated_at`) VALUES
(31, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP13052024231505000000001', '2024-05-13', '2024-05-13', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 16:15:05', '2024-05-13 16:15:05'),
(32, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP14052024001537000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 17:15:37', '2024-05-13 17:15:37'),
(34, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024014847000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:48:47', '2024-05-13 18:48:47'),
(35, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015002000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:50:02', '2024-05-13 18:50:02'),
(36, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015031000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:50:31', '2024-05-13 18:50:31'),
(37, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015040000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:50:40', '2024-05-13 18:50:40'),
(38, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015104000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:51:04', '2024-05-13 18:51:04'),
(39, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015259000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:52:59', '2024-05-13 18:52:59'),
(40, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024015328000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-13 18:53:28', '2024-05-13 18:53:28'),
(41, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024020325000000001', '2024-05-14', '2024-05-14', 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054031075802ID5908VISIONER6008SURABAYA61056125662610114051406702445460625VP140520240203250000000010702VP0804POSP6304D9D2', 1, '98.00', '9.80', '2.00', '107.80', NULL, '2024-05-13 19:03:27', '2024-05-13 19:03:27'),
(42, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024090823000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 02:08:23', '2024-05-14 02:08:23'),
(43, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024090849000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 02:08:52', '2024-05-14 02:10:11'),
(44, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024091042000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98', '9.8', '2', '110', '3', '2024-05-14 02:10:42', '2024-05-14 03:24:07'),
(45, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024102449000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '196', '19.6', '4', '300', '85', '2024-05-14 03:24:49', '2024-05-14 03:25:30'),
(47, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024112027000000046', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 04:20:27', '2024-05-14 04:20:27'),
(48, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024112116000000048', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 04:21:16', '2024-05-14 04:21:16'),
(49, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024112149000000049', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 04:21:49', '2024-05-14 04:21:49'),
(50, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024112221000000050', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 04:22:21', '2024-05-14 04:22:21'),
(51, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'amarwibianto@gmail.com', 3, NULL, 'VP14052024113333000000001', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '100.00', '0.00', '0.00', '100', '0', '2024-05-14 04:33:33', '2024-05-14 04:33:33'),
(52, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'amarwibianto@gmail.com', 3, NULL, 'VP14052024113515000000052', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '100.00', '0.00', '0.00', '100', '0', '2024-05-14 04:35:15', '2024-05-14 04:35:15'),
(53, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP14052024115352000000053', '2024-05-14', '2024-05-14', 'Tunai', NULL, 1, '490.00', '49.00', '10.00', '539.00', NULL, '2024-05-14 04:53:53', '2024-05-14 09:08:50'),
(55, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP15052024012138000000054', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-14 18:21:38', '2024-05-14 18:21:38'),
(56, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP15052024125621000000056', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-15 05:56:21', '2024-05-15 05:56:21'),
(57, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP15052024130059000000057', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-15 06:01:00', '2024-05-15 06:01:20'),
(59, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP15052024131545000000058', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-15 06:15:45', '2024-05-15 06:15:45'),
(60, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'asukaloid.blog@gmail.com', 2, NULL, 'VP15052024131605000000060', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98', '9.8', '2', '110', '3', '2024-05-15 06:16:05', '2024-05-15 06:16:42'),
(61, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP15052024142252000000061', '2024-05-15', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2024-05-15 07:22:52', '2024-05-15 07:22:52'),
(62, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP15052024142529000000062', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '98.00', '9.80', '2.00', '110', '3', '2024-05-15 07:25:29', '2024-05-15 07:25:29'),
(63, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP15052024142530000000063', '2024-05-15', '2024-05-15', 'Tunai', NULL, 1, '0.00', '0.00', '0.00', '110', '3', '2024-05-15 07:25:30', '2024-05-15 07:25:30'),
(64, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'indiraputri456@gmail.com', 2, 2, 'VP15052024143705000000064', '2024-05-15', '2024-05-15', 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054031075802ID5908VISIONER6008SURABAYA61056125662610114051506756194020625VP150520241437050000000640702VP0804POSP6304D845', 0, '98', '9.8', '2', '107', NULL, '2024-05-15 07:37:05', '2024-05-15 07:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_fields`
--

CREATE TABLE `invoice_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `content1` varchar(255) DEFAULT NULL,
  `content2` varchar(255) DEFAULT NULL,
  `content3` varchar(255) DEFAULT NULL,
  `content4` varchar(255) DEFAULT NULL,
  `content5` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_fields`
--

INSERT INTO `invoice_fields` (`id`, `id_invoice`, `content1`, `content2`, `content3`, `content4`, `content5`, `created_at`, `updated_at`) VALUES
(26, 31, '', '', '', '', '', '2024-05-13 16:15:05', '2024-05-13 16:15:05'),
(27, 32, '', '', '', '', '', '2024-05-13 17:15:37', '2024-05-13 17:15:37'),
(28, 34, 'Mahendra Rahman', 'Sidoarjo', 'Janti Waru', 'mahendra@gmail.com', '087738749342', '2024-05-13 18:48:47', '2024-05-13 18:48:47'),
(29, 35, '', '', '', '', '', '2024-05-13 18:50:02', '2024-05-13 18:50:02'),
(30, 36, '', '', '', '', '', '2024-05-13 18:50:31', '2024-05-13 18:50:31'),
(31, 37, '', '', '', '', '', '2024-05-13 18:50:40', '2024-05-13 18:50:40'),
(32, 38, '', '', '', '', '', '2024-05-13 18:51:04', '2024-05-13 18:51:04'),
(33, 39, '', '', '', '', '', '2024-05-13 18:52:59', '2024-05-13 18:52:59'),
(34, 40, 'Mahendra Rahman', 'Sidoarjo', 'Janti Waru', 'mahendra@gmail.com', '087738749342', '2024-05-13 18:53:28', '2024-05-13 18:53:28'),
(35, 41, '', '', '', '', '', '2024-05-13 19:03:27', '2024-05-13 19:03:27'),
(36, 42, '', '', '', '', '', '2024-05-14 02:08:23', '2024-05-14 02:08:23'),
(37, 43, '', '', '', '', '', '2024-05-14 02:08:52', '2024-05-14 02:08:52'),
(38, 44, '', '', '', '', '', '2024-05-14 03:24:07', '2024-05-14 03:24:07'),
(39, 45, '', '', '', '', '', '2024-05-14 03:25:16', '2024-05-14 03:25:16'),
(40, 47, '', '', '', '', '', '2024-05-14 04:20:27', '2024-05-14 04:20:27'),
(41, 48, '', '', '', '', '', '2024-05-14 04:21:16', '2024-05-14 04:21:16'),
(42, 49, '', '', '', '', '', '2024-05-14 04:21:49', '2024-05-14 04:21:49'),
(43, 50, '', '', '', '', '', '2024-05-14 04:22:21', '2024-05-14 04:22:21'),
(44, 51, '', '', '', '', '', '2024-05-14 04:33:33', '2024-05-14 04:33:33'),
(45, 52, '', '', '', '', '', '2024-05-14 04:35:15', '2024-05-14 04:35:15'),
(46, 53, 'Doni Sulaiman', 'Surabaya', 'Janti', 'sulaiman@gmail.com', '0877283743232', '2024-05-14 04:53:53', '2024-05-14 04:53:53'),
(47, 54, '', '', '', '', '', '2024-05-14 07:55:11', '2024-05-14 07:55:11'),
(48, 55, '', '', '', '', '', '2024-05-14 18:21:38', '2024-05-14 18:21:38'),
(49, 56, '', '', '', '', '', '2024-05-15 05:56:21', '2024-05-15 05:56:21'),
(50, 57, '', '', '', '', '', '2024-05-15 06:01:00', '2024-05-15 06:01:00'),
(51, 59, '', '', '', '', '', '2024-05-15 06:15:45', '2024-05-15 06:15:45'),
(52, 60, '', '', '', '', '', '2024-05-15 06:16:42', '2024-05-15 06:16:42'),
(53, 62, '', '', '', '', '', '2024-05-15 07:25:29', '2024-05-15 07:25:29'),
(54, 63, '', '', '', '', '', '2024-05-15 07:25:30', '2024-05-15 07:25:30'),
(55, 64, '', '', '', '', '', '2024-05-15 07:37:27', '2024-05-15 07:37:27');

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
  `id_store` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kasirs`
--

INSERT INTO `kasirs` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `id_store`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Inayah Indah Putri', 'indiraputri456@gmail.com', NULL, '0876566552522', '$2y$12$Vrpz6Kj2qQNl6kQ.d16R8.Mm4GdBYlVpdUpsctS47Ojl19/e9tiH6', 1, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', NULL, '2024-05-13 05:55:09', '2024-05-15 06:52:57'),
(3, 'Rafi Rahman Syahputra', 'syahputrarahman@gmail.com', NULL, '087673847684234', '$2y$12$eDZ74umTopMSr0zkodI48.LTG2ydvBmZz3QxfzlsMr9qK6d.qXE7q', 1, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', NULL, '2024-05-14 06:01:10', '2024-05-14 06:01:10'),
(4, 'Budi Rahman', 'rahmanbudiindra@gmail.com', NULL, '087667766778', '$2y$12$/KvWExLmAvFrdFSOZvGGZuCPlkqf.x6pF7cFLZQ9Xvch/kyQSIS7C', 1, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', NULL, '2024-05-15 04:06:33', '2024-05-15 04:06:33');

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
  `phone_number_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketings`
--

INSERT INTO `marketings` (`id`, `name`, `email`, `email_verified_at`, `phone`, `phone_number_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Inayah Indah Putri', 'ouka.dev@gmail.com', '2024-05-08 19:03:45', '087739882723', '2024-05-08 19:07:05', '$2y$12$LY3Xl6JKgxJ6O3qNKToKeeBuBqiv4wBYq8FYAriT9ljYb9qDnvXFG', 1, NULL, '2024-05-08 19:03:07', '2024-05-08 19:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` bigint(20) NOT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(46, '2024_02_20_074646_add_id_tenant_field_to_table_product', 19),
(47, '2024_02_21_015021_drop_column_batch_code_from_table_products_and_add_column_batcgh_id', 20),
(48, '2024_02_21_020109_add_column_number_to_table_product', 21),
(50, '2024_02_21_023859_add_table_stok_to_table_product', 22),
(51, '2024_02_22_011138_drop_table_categories_product', 23),
(52, '2024_02_22_011353_add_id_category_field_to_table_prooduct', 24),
(53, '2024_02_22_021344_create_product_stocks_table', 25),
(54, '2024_02_22_022113_add_tenant_id_to_table_product_stocks', 26),
(55, '2024_02_22_023547_add_stok_field_to_table_product_stocks', 27),
(56, '2024_02_22_032926_drop_some_column_from_table_products', 28),
(57, '2024_02_22_033438_add_some_fields_to_table_product_stocks', 29),
(64, '2024_02_27_054027_create_invoices_table', 30),
(65, '2024_02_27_082544_create_shopping_carts_table', 31),
(68, '2024_02_29_025448_create_taxes_table', 33),
(69, '2024_02_29_043031_create_discounts_table', 34),
(70, '2024_02_29_045459_add_is_active_field_to_table_discounts', 35),
(71, '2024_03_03_160143_create_tenant_fields_table', 36),
(72, '2024_03_03_160619_add_id_tenant_field_to_table', 37),
(73, '2024_03_04_011326_create_invoice_fields_table', 38),
(74, '2024_03_04_070118_add_subtotal_diskon_pajak_field_to_table_invoice', 39),
(75, '2024_03_09_034434_drop_column_stok_from_table_product', 40),
(76, '2024_03_14_065437_add_activation_field_to_table_custom_field', 41),
(77, '2024_03_15_063234_add_qris_data_column_to_table_invoice', 42),
(79, '2024_03_18_033835_add_id_kasir_to_table_shopping_cart', 43),
(80, '2024_03_22_011959_create_tunai_wallets_table', 44),
(81, '2024_03_22_012009_create_qris_wallets_table', 44),
(82, '2024_03_22_035517_create_marketing_wallets_table', 45),
(83, '2024_04_01_014752_create_messages_table', 46),
(85, '2024_04_17_034556_create_rekening_tenants_table', 47),
(86, '2024_04_17_034601_create_rekening_marketings_table', 47),
(87, '2024_04_17_040402_add_some_field_to_store_detail_table', 48),
(89, '2024_04_22_024017_create_customer_identifiers_table', 49),
(90, '2024_04_22_033305_change_nomor_invoice_column_to_nullable_to_table_invoice', 50),
(91, '2024_04_23_092612_create_umi_requests_table', 51),
(92, '2024_04_23_093805_add_kode_pos_to_table_store_detail', 52),
(93, '2024_04_23_101610_add_kabupaten_to_table_store_details', 53),
(94, '2024_04_23_113300_add_filename_to_umi_requests', 54),
(95, '2024_04_23_121442_add_note_to_table_umi_requests', 55),
(96, '2024_04_23_124726_add_tanggal_approval_to_table_umi_requests', 56),
(97, '2024_04_24_100732_set_nulable_for_no_ktp_and_alamat_for_detail_kasir', 57),
(98, '2019_05_11_000000_create_otps_table', 58),
(99, '2024_05_03_101950_add_wa_otp_status_to_table_user_marketing', 59),
(100, '2024_05_03_102817_create_wa_otps_table', 60),
(101, '2024_05_03_151615_add_bank_swift_code_to_table_rekening_marketing', 61),
(102, '2024_05_03_151633_add_bank_swift_code_to_table_rekening_tenant', 61),
(103, '2024_05_04_113645_add_wa_otp_status_to_table_user_tenant', 62),
(105, '2024_05_08_104622_create_tenant_qris_accounts_table', 63),
(106, '2024_05_08_113901_add_mdr_field_to_qris_account_table', 64),
(107, '2024_05_08_135237_change_nullable_to_invoice_table', 65),
(108, '2024_05_09_012531_create_rekenings_table', 66),
(109, '2024_05_09_014241_create_qris_wallets_table', 67),
(110, '2024_05_10_083432_change_unique_and_add_email_field_to_table_detail_tenant', 68),
(111, '2024_05_10_090411_change_unique_and_add_email_field_to_table_store_details', 69),
(112, '2024_05_10_095237_add_email_field_to_table_suppliers', 70),
(113, '2024_05_10_101437_add_email_field_to_table_batches', 71),
(114, '2024_05_10_102718_add_email_field_to_table_product_categories', 72),
(115, '2024_05_10_104213_add_email_field_to_table_products', 73),
(116, '2024_05_10_105437_add_email_field_to_table_product_stocks', 74),
(117, '2024_05_10_132623_add_email_field_to_table_invoices', 75),
(118, '2024_05_10_133948_drop_column_id_tenant_to_table_kasirs_and_create_store_id', 76),
(120, '2024_05_10_160701_drop_table_discount', 77),
(121, '2024_05_10_160715_drop_table_taxes', 77),
(122, '2024_05_10_161026_taxes', 78),
(123, '2024_05_10_161044_discounts', 78),
(124, '2024_05_11_022235_add_email_to_tenant_customfields', 79),
(125, '2024_05_11_023351_drop_table_tunai_eallet', 80),
(126, '2024_05_11_023604_add_new_tenant_tunai_table', 81),
(128, '2024_05_11_082437_add_email_field_to_table_shopping_carts', 82),
(129, '2024_05_11_082808_add_email_field_to_table_invoice_fields', 83),
(130, '2024_05_11_082924_add_email_field_to_table_customer_identifier', 84),
(132, '2024_05_11_094815_change_nullable_to_table_customer_identifier', 85),
(133, '2024_05_13_092246_modify_table_detail_kasirs', 86),
(134, '2024_05_13_121717_add_store_identifier_to_table_store_details', 87),
(140, '2024_05_13_130452_add_store_identifier_to_supplier', 88),
(141, '2024_05_13_130759_add_store_identifier_to_batch_codes', 88),
(142, '2024_05_13_130822_add_store_identifier_to_product_categories', 88),
(143, '2024_05_13_130839_add_store_identifier_to_products', 88),
(144, '2024_05_13_130855_add_store_identifier_to_stocks', 88),
(145, '2024_05_15_085529_create_withdrawals_table', 89),
(146, '2024_05_15_092808_create_histories_table', 90),
(147, '2024_05_16_104352_create_nobu_withdraw_fee_histories_table', 91),
(148, '2024_05_16_104423_create_agregate_wallets_table', 91),
(149, '2024_05_16_104642_create_detail_penarikans_table', 91),
(150, '2024_05_16_111738_add_admin_to_table_withdrawals', 92);

-- --------------------------------------------------------

--
-- Table structure for table `nobu_withdraw_fee_histories`
--

CREATE TABLE `nobu_withdraw_fee_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_penarikan` bigint(20) DEFAULT NULL,
  `nominal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nobu_withdraw_fee_histories`
--

INSERT INTO `nobu_withdraw_fee_histories` (`id`, `id_penarikan`, `nominal`, `created_at`, `updated_at`) VALUES
(1, 9, '300', '2024-05-16 05:46:04', '2024-05-16 05:46:04'),
(2, 10, '300', '2024-05-16 06:56:23', '2024-05-16 06:56:23'),
(3, 11, '300', '2024-05-16 07:46:25', '2024-05-16 07:46:25'),
(4, 12, '300', '2024-05-16 09:16:21', '2024-05-16 09:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` int(10) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validity` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `identifier`, `token`, `validity`, `valid`, `created_at`, `updated_at`) VALUES
(1, 'ouka.dev@gmail.com', '087422', 30, 0, '2024-05-08 19:03:08', '2024-05-08 19:03:45'),
(3, '087739882723', '470785', 5, 0, '2024-05-08 19:05:46', '2024-05-08 19:06:10'),
(4, '087739882723', '266252', 5, 0, '2024-05-08 19:06:47', '2024-05-08 19:07:05'),
(5, '087739882723', '323248', 5, 0, '2024-05-08 19:07:59', '2024-05-08 19:08:27'),
(6, 'asukaloid.blog@gmail.com', '672503', 30, 0, '2024-05-08 19:16:08', '2024-05-08 19:17:11'),
(11, '087739882723', '796592', 5, 0, '2024-05-09 04:59:07', '2024-05-09 05:00:06'),
(13, '087739882723', '562700', 5, 0, '2024-05-09 05:01:02', '2024-05-09 05:01:55'),
(15, '087739882723', '648940', 5, 0, '2024-05-09 05:02:27', '2024-05-09 05:02:54'),
(16, '087739882723', '117107', 5, 0, '2024-05-09 05:03:11', '2024-05-09 05:03:26'),
(18, '087739882723', '737231', 5, 0, '2024-05-09 05:03:48', '2024-05-09 05:04:02'),
(19, '085156719832', '783849', 5, 0, '2024-05-10 01:19:28', '2024-05-10 01:19:53'),
(20, '085156719832', '546118', 5, 0, '2024-05-10 01:26:19', '2024-05-10 01:27:05'),
(21, 'asukaloid.blog@gmail.com', '943370', 30, 0, '2024-05-13 05:35:57', '2024-05-13 05:36:37'),
(22, '085156719832', '962797', 5, 0, '2024-05-13 05:37:04', '2024-05-13 05:37:23'),
(23, 'amarwibianto@gmail.com', '780421', 30, 1, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(24, '085156719832', '107904', 5, 0, '2024-05-15 03:22:10', '2024-05-15 03:23:00'),
(26, '085156719832', '780799', 5, 0, '2024-05-15 03:50:46', '2024-05-15 03:51:07'),
(27, 'apriyambodo487@gmail.com', '084240', 30, 1, '2024-05-15 05:46:48', '2024-05-15 05:46:48'),
(28, '085156719832', '196716', 5, 0, '2024-05-16 03:14:11', '2024-05-16 03:14:41'),
(29, '085156719832', '374989', 5, 0, '2024-05-16 03:29:45', '2024-05-16 03:30:05'),
(30, '085156719832', '852147', 5, 0, '2024-05-16 03:31:02', '2024-05-16 03:31:28'),
(31, '085156719832', '480532', 5, 0, '2024-05-16 03:32:25', '2024-05-16 03:32:47'),
(32, '085156719832', '673204', 5, 0, '2024-05-16 03:38:39', '2024-05-16 04:48:11'),
(33, '085156719832', '633455', 5, 0, '2024-05-16 04:02:13', '2024-05-16 04:48:01'),
(34, '085156719832', '314651', 5, 0, '2024-05-16 04:09:28', '2024-05-16 04:09:51'),
(36, '085156719832', '799514', 5, 0, '2024-05-16 04:57:55', '2024-05-16 04:58:25'),
(38, '085156719832', '824093', 5, 0, '2024-05-16 05:03:11', '2024-05-16 05:03:33'),
(39, '085156719832', '613526', 5, 0, '2024-05-16 05:04:23', '2024-05-16 05:04:48'),
(40, '085156719832', '694442', 5, 0, '2024-05-16 05:09:45', '2024-05-16 05:10:28'),
(41, '085156719832', '579692', 5, 0, '2024-05-16 05:11:40', '2024-05-16 05:12:03'),
(42, '085156719832', '205351', 5, 0, '2024-05-16 05:12:47', '2024-05-16 05:13:15'),
(43, '085156719832', '908796', 5, 0, '2024-05-16 05:14:17', '2024-05-16 05:14:39'),
(44, '085156719832', '117356', 5, 0, '2024-05-16 05:18:49', '2024-05-16 05:19:41'),
(45, '085156719832', '186517', 5, 0, '2024-05-16 05:20:31', '2024-05-16 05:20:54'),
(46, '085156719832', '857795', 5, 0, '2024-05-16 05:21:04', '2024-05-16 05:21:26'),
(47, '085156719832', '458399', 5, 0, '2024-05-16 05:21:52', '2024-05-16 05:22:16'),
(48, '085156719832', '329119', 5, 0, '2024-05-16 05:22:50', '2024-05-16 05:23:11'),
(49, '085156719832', '164091', 5, 0, '2024-05-16 05:23:57', '2024-05-16 05:24:21'),
(51, '085156719832', '969290', 5, 0, '2024-05-16 05:26:26', '2024-05-16 05:26:46'),
(52, '085156719832', '740447', 5, 0, '2024-05-16 05:27:16', '2024-05-16 05:27:40'),
(53, '085156719832', '390940', 5, 0, '2024-05-16 05:28:51', '2024-05-16 05:29:18'),
(54, '085156719832', '944960', 5, 0, '2024-05-16 05:29:50', '2024-05-16 05:30:14'),
(55, '085156719832', '239065', 5, 0, '2024-05-16 05:30:59', '2024-05-16 05:31:22'),
(56, '085156719832', '374746', 5, 0, '2024-05-16 05:32:31', '2024-05-16 05:32:56'),
(57, '085156719832', '528781', 5, 0, '2024-05-16 05:34:10', '2024-05-16 05:34:50'),
(58, '085156719832', '077904', 5, 0, '2024-05-16 05:40:07', '2024-05-16 05:40:38'),
(59, '085156719832', '475216', 5, 0, '2024-05-16 05:41:57', '2024-05-16 05:42:22'),
(60, '085156719832', '025659', 5, 0, '2024-05-16 05:45:31', '2024-05-16 05:45:59'),
(61, '085156719832', '272674', 5, 0, '2024-05-16 06:11:29', '2024-05-16 06:11:59'),
(62, '085156719832', '627516', 5, 0, '2024-05-16 06:28:49', '2024-05-16 06:29:21'),
(63, '085156719832', '410650', 5, 0, '2024-05-16 06:30:53', '2024-05-16 06:31:15'),
(64, '085156719832', '576724', 5, 0, '2024-05-16 06:32:19', '2024-05-16 06:34:40'),
(65, '085156719832', '719431', 5, 0, '2024-05-16 06:38:16', '2024-05-16 06:38:38'),
(66, '085156719832', '792819', 5, 0, '2024-05-16 06:39:16', '2024-05-16 06:39:40'),
(67, '085156719832', '297838', 5, 0, '2024-05-16 06:39:55', '2024-05-16 06:40:20'),
(68, '085156719832', '951724', 5, 0, '2024-05-16 06:43:39', '2024-05-16 06:44:01'),
(69, '085156719832', '528267', 5, 0, '2024-05-16 06:54:11', '2024-05-16 06:54:33'),
(70, '085156719832', '491878', 5, 0, '2024-05-16 06:55:53', '2024-05-16 06:56:14'),
(71, '085156719832', '020756', 5, 0, '2024-05-16 07:45:52', '2024-05-16 07:46:15'),
(72, '085156719832', '403753', 5, 0, '2024-05-16 09:14:25', '2024-05-16 09:15:00');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(9, 'App\\Models\\Admin', 26, 'auth_token', '6bbeee3f9adae0668e4dd6423cf72e2fb771c5fa7bdc4775f2ed8384d3e1e560', '[\"*\"]', NULL, NULL, '2024-03-12 19:41:19', '2024-03-12 19:41:19'),
(10, 'App\\Models\\Admin', 27, 'auth_token', '66768b268aa689d710d91f292c5daaf58838b57b299c1bef0e344c8a0dbd9485', '[\"*\"]', NULL, NULL, '2024-03-12 19:44:42', '2024-03-12 19:44:42'),
(11, 'App\\Models\\Admin', 30, 'auth_token', '06d5228f5ad7a5560080db708052ca935f1103c92b561d69f94dc11e4592a463', '[\"*\"]', NULL, NULL, '2024-03-12 20:27:19', '2024-03-12 20:27:19'),
(12, 'App\\Models\\Admin', 31, 'auth_token', '32d5b091af52ce8f3071c05a92d1d558c292a177c8b1f11a8a3b49cf6d150f11', '[\"*\"]', NULL, NULL, '2024-03-12 20:29:08', '2024-03-12 20:29:08'),
(16, 'App\\Models\\Tenant', 12, 'auth_token', 'de6440d15da4332ed74b34b2ebf943c0195e4065148e7ca5b1e5a887b928da2c', '[\"*\"]', NULL, NULL, '2024-03-12 21:37:18', '2024-03-12 21:37:18'),
(21, 'App\\Models\\Admin', 8, 'auth_token', '014d298161029cdb88329e715ce35cbe99681c99e42f47a662ac9dd864cb0f34', '[\"*\"]', NULL, NULL, '2024-03-15 17:46:32', '2024-03-15 17:46:32'),
(22, 'App\\Models\\Admin', 8, 'auth_token', '8bcceaf2af4ecaecc74b076f2a91224bc7c09a9246f868b5594a5b428bead1ac', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:49', '2024-03-15 17:48:49'),
(23, 'App\\Models\\Admin', 8, 'auth_token', 'aad4a6a5e0d2ddbfed600953fff7a7d21da864eb4298dbbd38c0218d09e1b566', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:51', '2024-03-15 17:48:51'),
(24, 'App\\Models\\Admin', 8, 'auth_token', '2b26bb9b7eb201ea438eb1ebce5e136259c201d8a0f3f0e7ee2ea44947653963', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:52', '2024-03-15 17:48:52'),
(25, 'App\\Models\\Admin', 8, 'auth_token', '73d2f31fcccd5cc5411db78f7cf78a0fccad9d73511b1cb3ea71aede9f1c5383', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:54', '2024-03-15 17:48:54'),
(26, 'App\\Models\\Admin', 8, 'auth_token', 'cb3814a750ee09d7f533adc60a2ce50f5490119027d238d87ca305907501f18d', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:56', '2024-03-15 17:48:56'),
(27, 'App\\Models\\Admin', 8, 'auth_token', '7eddf177cc16040493bc47ac73980b515cb04823740e64aa01fe15dfe5fec05f', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:57', '2024-03-15 17:48:57'),
(28, 'App\\Models\\Admin', 8, 'auth_token', 'be7d99f92dd3e09552b6fbb37ed9c4eaa7446e63eae6e8ca1ce5fa43b24707f4', '[\"*\"]', NULL, NULL, '2024-03-15 17:48:59', '2024-03-15 17:48:59'),
(29, 'App\\Models\\Admin', 8, 'auth_token', '9b6ff730ebe92cc0f60a4756df4c130f9c3ea6d01f6a0197bf30ec46365f7c09', '[\"*\"]', NULL, NULL, '2024-03-15 17:49:02', '2024-03-15 17:49:02'),
(30, 'App\\Models\\Admin', 8, 'auth_token', '6d31bb6ad9448e7542a5e869613c6de180219d749c5fd7ad9bd788c6ed5145aa', '[\"*\"]', NULL, NULL, '2024-03-15 17:49:05', '2024-03-15 17:49:05'),
(31, 'App\\Models\\Admin', 8, 'auth_token', 'ee584d6644f0f85d5eff56d1a12cbb734a7855c2ae26a986cd99a535b9c446ac', '[\"*\"]', NULL, NULL, '2024-03-15 17:49:06', '2024-03-15 17:49:06'),
(32, 'App\\Models\\Admin', 8, 'auth_token', 'bd9d80a293dc27ccd3d466ab3b6871013d7ef686e85a77e06b4d5891715387e7', '[\"*\"]', NULL, NULL, '2024-03-15 17:51:54', '2024-03-15 17:51:54'),
(38, 'App\\Models\\Tenant', 14, 'auth_token', 'ad6856bb54e52f6698e054abff53f2cc7c0b382f1f0da200413606dace4da0b7', '[\"*\"]', NULL, NULL, '2024-03-17 17:53:42', '2024-03-17 17:53:42'),
(39, 'App\\Models\\Kasir', 4, 'auth_token', '83344aa161c4bd25a0833e3bfc7e9d4870c8f1d1edc1be002624daa15fabbcd1', '[\"*\"]', '2024-03-17 22:06:51', NULL, '2024-03-17 18:10:13', '2024-03-17 22:06:51'),
(40, 'App\\Models\\Kasir', 4, 'auth_token', 'e94893649d6228072cdef17e0dbf32f7cd1fac453a333a148be89be481fe9f03', '[\"*\"]', '2024-03-17 23:48:12', NULL, '2024-03-17 23:31:17', '2024-03-17 23:48:12'),
(41, 'App\\Models\\Kasir', 4, 'auth_token', 'dff1c606157f690f7778737521f6d2f3d1abd0eed8a3a9b8b07808dc76d1fb97', '[\"*\"]', '2024-03-18 19:20:17', NULL, '2024-03-18 18:52:34', '2024-03-18 19:20:17'),
(42, 'App\\Models\\Kasir', 4, 'auth_token', '87302e76f3456b0ab1db5f5c32e174b704d56d1d04dcef21784cd3bfe5b738cc', '[\"*\"]', '2024-03-18 22:01:34', NULL, '2024-03-18 19:40:40', '2024-03-18 22:01:34'),
(43, 'App\\Models\\Kasir', 4, 'auth_token', 'e6c8056c78da7d2be6a105c60a7dc41855436d28fe585e1b182d25bc7e0ebb51', '[\"*\"]', '2024-03-31 18:32:37', NULL, '2024-03-31 18:31:05', '2024-03-31 18:32:37'),
(44, 'App\\Models\\Kasir', 4, 'auth_token', '4110317114f2c12faf20dc22626e1b5eb10ac267f36c290b98a19131a3707e5c', '[\"*\"]', '2024-04-03 00:48:35', NULL, '2024-04-02 19:33:33', '2024-04-03 00:48:35'),
(45, 'App\\Models\\Kasir', 4, 'auth_token', '9ef2f1e706f604f5af05f5c99d5c605ac5ababa049ff9ebe0e8053248c21df8d', '[\"*\"]', '2024-04-16 01:43:29', NULL, '2024-04-16 01:42:48', '2024-04-16 01:43:29'),
(46, 'App\\Models\\Tenant', 7, 'auth_token', '878bc05b4d9403f640e9a62fdb690b4c579a271e2824db8cbb85ab80d154ff85', '[\"*\"]', '2024-04-16 23:03:09', NULL, '2024-04-16 21:41:09', '2024-04-16 23:03:09'),
(47, 'App\\Models\\Kasir', 4, 'auth_token', '88071698548b7d74394e36a4029067c3bf299aa7331bf232ac58cd8f043562c0', '[\"*\"]', '2024-04-16 23:51:21', NULL, '2024-04-16 23:50:11', '2024-04-16 23:51:21'),
(48, 'App\\Models\\Tenant', 7, 'auth_token', 'afd6e9423ccaeb20ad051618434a193b3194e03c3d046a517a03eced629819f5', '[\"*\"]', NULL, NULL, '2024-04-24 02:40:36', '2024-04-24 02:40:36'),
(49, 'App\\Models\\Tenant', 7, 'auth_token', 'cfef60f61e2059fea2d29620fb0b6c25a5072e6951dacce59196f21a7b4ac28d', '[\"*\"]', '2024-04-24 03:47:48', NULL, '2024-04-24 02:41:19', '2024-04-24 03:47:48'),
(50, 'App\\Models\\Kasir', 5, 'auth_token', 'b85eaba4f85b5ba45ca87d8ac6fbec391b44474eea20cad8c82365a0e74c4830', '[\"*\"]', '2024-04-24 06:35:09', NULL, '2024-04-24 04:48:59', '2024-04-24 06:35:09'),
(51, 'App\\Models\\Kasir', 4, 'auth_token', '4086485a0938e4c2bd4d6056d720fcb9b21d31c12800cd8b9a83ec6065ecc461', '[\"*\"]', '2024-04-25 06:46:29', NULL, '2024-04-25 06:44:37', '2024-04-25 06:46:29'),
(52, 'App\\Models\\Tenant', 7, 'auth_token', 'bfd3642cb72a50c87695d2bdcb6d29a8c0eda2eed4a34bb7de4ba25c0f847982', '[\"*\"]', '2024-04-25 06:49:09', NULL, '2024-04-25 06:47:12', '2024-04-25 06:49:09'),
(53, 'App\\Models\\Tenant', 18, 'auth_token', '3c8cdfa0ef160843583a358d218c5f7bea68410e624eb56de564753c7868f6f0', '[\"*\"]', NULL, NULL, '2024-05-04 03:24:23', '2024-05-04 03:24:23'),
(54, 'App\\Models\\Tenant', 18, 'auth_token', '395ae3643737caebe80d3d82a27d76eb771e225a0cbb33385c33f4b5eaf0da1b', '[\"*\"]', NULL, NULL, '2024-05-04 03:38:08', '2024-05-04 03:38:08'),
(55, 'App\\Models\\Tenant', 18, 'auth_token', '2dc645af1a5c4096d2ca9ea210531acec8757e419c2fe71d94925189c42bc730', '[\"*\"]', NULL, NULL, '2024-05-04 03:41:14', '2024-05-04 03:41:14'),
(56, 'App\\Models\\Tenant', 18, 'auth_token', '9811439a44299b2d9e27cc4168496c8eab5730def9d50243e1efabb363d2cd72', '[\"*\"]', NULL, NULL, '2024-05-04 03:54:16', '2024-05-04 03:54:16'),
(57, 'App\\Models\\Tenant', 18, 'auth_token', 'ef9ed4d0c6651ee7470e9478b3a4efd54050519b239e425eba37d3c48b73baa4', '[\"*\"]', '2024-05-04 04:38:21', NULL, '2024-05-04 03:55:43', '2024-05-04 04:38:21'),
(58, 'App\\Models\\Tenant', 7, 'auth_token', 'e4c35eb3d1b733858ecce1556176da68ccb744a4a34eb584d2744824dc7e0de2', '[\"*\"]', '2024-05-06 02:39:10', NULL, '2024-05-06 01:33:53', '2024-05-06 02:39:10'),
(59, 'App\\Models\\Tenant', 2, 'auth_token', 'e069baeeb7b3015086b531d784bebb182c3edaf501d829c8927c91849ab9a586', '[\"*\"]', NULL, NULL, '2024-05-14 05:30:01', '2024-05-14 05:30:01'),
(60, 'App\\Models\\Tenant', 2, 'auth_token', 'b8b3d28efd741f502abb5b625ce23d2217e21800206f5a965618df44a57568a8', '[\"*\"]', '2024-05-14 06:22:26', NULL, '2024-05-14 05:30:57', '2024-05-14 06:22:26'),
(61, 'App\\Models\\Kasir', 2, 'auth_token', '4c9abe7533ae1d422da007b40f1de9a48d9b6927a3054b3d64ced87b2ee12dfd', '[\"*\"]', '2024-05-14 09:19:11', NULL, '2024-05-14 06:26:46', '2024-05-14 09:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `id_batch` bigint(20) NOT NULL,
  `id_category` int(11) DEFAULT NULL,
  `index_number` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nomor_gudang` varchar(255) DEFAULT NULL,
  `nomor_rak` varchar(255) DEFAULT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `store_identifier`, `id_batch`, `id_category`, `index_number`, `product_code`, `product_name`, `id_supplier`, `photo`, `nomor_gudang`, `nomor_rak`, `harga_jual`, `created_at`, `updated_at`) VALUES
(7, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 6, 6, 1, 'DP-000001', 'ROG Strix RTX 4080 Super', 6, 'ROG Strix RTX 4080 Super-1715585886.png', '2', '1', '100', '2024-05-13 07:38:06', '2024-05-13 07:48:46'),
(9, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 12, 12, 1, 'LP-000001', 'Axioo Pongo 760', 8, 'Axioo Pongo 760-1715661137.jpg', '1', '1', '100', '2024-05-14 04:32:17', '2024-05-14 04:32:17'),
(10, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 10, 9, 1, 'ACS-000001', 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 9, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB-1715748935.jpg', '1', '1', '100', '2024-05-15 04:55:35', '2024-05-15 04:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `store_identifier`, `name`, `created_at`, `updated_at`) VALUES
(6, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'Desktop', '2024-05-13 07:11:54', '2024-05-13 07:11:54'),
(7, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'PC Rakitan', '2024-05-13 07:11:59', '2024-05-13 07:11:59'),
(8, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'Laptop', '2024-05-13 07:12:05', '2024-05-13 07:12:05'),
(9, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'Aksesoris', '2024-05-13 07:12:10', '2024-05-13 07:12:10'),
(10, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'HP & Android', '2024-05-13 07:12:16', '2024-05-13 07:12:16'),
(12, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'Laptop', '2024-05-14 04:30:20', '2024-05-14 04:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `id_batch_product` int(11) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `tanggal_beli` date DEFAULT NULL,
  `tanggal_expired` date DEFAULT NULL,
  `harga_beli` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `store_identifier`, `id_batch_product`, `barcode`, `tanggal_beli`, `tanggal_expired`, `harga_beli`, `stok`, `created_at`, `updated_at`) VALUES
(8, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 7, '322123123', '2024-04-30', NULL, '100', 59, '2024-05-13 08:14:15', '2024-05-14 18:21:38'),
(10, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 9, '223333442313', '2024-04-29', NULL, '80', 98, '2024-05-14 04:32:51', '2024-05-14 04:35:15'),
(11, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 10, '32434324243', '2024-04-29', NULL, '80', 393, '2024-05-15 05:14:05', '2024-05-15 07:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `qris_wallets`
--

CREATE TABLE `qris_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `saldo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qris_wallets`
--

INSERT INTO `qris_wallets` (`id`, `id_user`, `email`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 1, 'ouka.dev@gmail.com', '2000', '2024-05-08 19:03:07', '2024-05-16 09:16:21'),
(3, 2, 'asukaloid.blog@gmail.com', '54000', '2024-05-13 05:35:57', '2024-05-16 09:16:21'),
(4, 3, 'amarwibianto@gmail.com', '0', '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(5, 4, 'apriyambodo487@gmail.com', '0', '2024-05-15 05:46:48', '2024-05-15 05:46:48'),
(6, 8, 'adminsu@vpos.my.id.com', '1400', NULL, '2024-05-16 09:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `rekenings`
--

CREATE TABLE `rekenings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekenings`
--

INSERT INTO `rekenings` (`id`, `id_user`, `email`, `nama_bank`, `swift_code`, `no_rekening`, `created_at`, `updated_at`) VALUES
(1, 1, 'ouka.dev@gmail.com', NULL, 'BNINIDJA', '1283497501', '2024-05-08 19:03:07', '2024-05-09 05:02:54'),
(3, 2, 'asukaloid.blog@gmail.com', NULL, 'CENAIDJA', '5065205758', '2024-05-13 05:35:57', '2024-05-13 05:35:57'),
(4, 3, 'amarwibianto@gmail.com', NULL, NULL, NULL, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(5, 4, 'apriyambodo487@gmail.com', NULL, NULL, NULL, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `id_product` bigint(20) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `id_kasir` bigint(20) DEFAULT NULL,
  `id_tenant` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `id_kasir`, `id_tenant`, `created_at`, `updated_at`) VALUES
(33, 31, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 16:15:05', '2024-05-13 16:15:05'),
(34, 32, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 17:15:37', '2024-05-13 17:15:37'),
(36, 34, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:48:47', '2024-05-13 18:48:47'),
(37, 35, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:50:02', '2024-05-13 18:50:02'),
(38, 36, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:50:31', '2024-05-13 18:50:31'),
(39, 37, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:50:40', '2024-05-13 18:50:40'),
(40, 38, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:51:04', '2024-05-13 18:51:04'),
(41, 39, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:52:59', '2024-05-13 18:52:59'),
(42, 40, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 18:53:28', '2024-05-13 18:53:28'),
(43, 41, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-13 19:03:27', '2024-05-13 19:03:27'),
(44, 42, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 02:08:23', '2024-05-14 02:08:23'),
(45, 43, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 02:08:52', '2024-05-14 02:08:52'),
(48, 44, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 03:21:09', '2024-05-14 03:21:09'),
(49, 45, 8, 'ROG Strix RTX 4080 Super', 2, '100', '200', 0, NULL, '2024-05-14 03:24:49', '2024-05-14 03:24:49'),
(51, 47, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 04:20:27', '2024-05-14 04:20:27'),
(52, 48, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 04:21:16', '2024-05-14 04:21:16'),
(53, 49, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 04:21:49', '2024-05-14 04:21:49'),
(54, 50, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', 0, NULL, '2024-05-14 04:22:21', '2024-05-14 04:22:21'),
(55, 51, 10, 'Axioo Pongo 760', 1, '100', '100', 0, NULL, '2024-05-14 04:33:33', '2024-05-14 04:33:33'),
(56, 52, 10, 'Axioo Pongo 760', 1, '100', '100', 0, NULL, '2024-05-14 04:35:15', '2024-05-14 04:35:15'),
(61, 55, 8, 'ROG Strix RTX 4080 Super', 1, '100', '100', NULL, NULL, '2024-05-14 18:21:38', '2024-05-14 18:21:38'),
(62, 56, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 05:56:21', '2024-05-15 05:56:21'),
(63, 57, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 06:01:00', '2024-05-15 06:01:00'),
(65, 59, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 06:15:45', '2024-05-15 06:15:45'),
(66, 60, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 06:16:05', '2024-05-15 06:16:05'),
(67, 61, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 07:22:52', '2024-05-15 07:22:52'),
(68, 62, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 07:25:29', '2024-05-15 07:25:29'),
(69, 64, 11, 'Flashdisk Sandisk Cruzer Blade 128GBBBBB', 1, '100', '100', NULL, NULL, '2024-05-15 07:37:05', '2024-05-15 07:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `store_details`
--

CREATE TABLE `store_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `id_tenant` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `no_telp_toko` varchar(255) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `status_umi` int(11) DEFAULT NULL,
  `catatan_kaki` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_details`
--

INSERT INTO `store_details` (`id`, `store_identifier`, `id_tenant`, `email`, `name`, `alamat`, `kabupaten`, `kode_pos`, `no_telp_toko`, `jenis_usaha`, `status_umi`, `catatan_kaki`, `photo`, `created_at`, `updated_at`) VALUES
(2, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', '2', 'asukaloid.blog@gmail.com', 'Toko Komputer Surabaya', 'Jl. Pemuda No.60-70, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271', 'Surabaya', '60271', '0856765456778', '5045 - COMPUTERS & COMPUTER PERIPHERAL EQUIPMENT & SERVICES', NULL, 'Terima Kasih telah berkunjung ke toko kami!', '-1715579352.png', '2024-05-13 05:35:57', '2024-05-15 03:35:28'),
(3, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', '3', 'amarwibianto@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, 'DPpU35sGVTUiVpYsj4p1B9MRVdQghS', '4', 'apriyambodo487@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) NOT NULL,
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

INSERT INTO `suppliers` (`id`, `store_identifier`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'PT Galah', 'Galah@gmail.com', '08767655567876', 'Surabaya', 'Supplier Sparepart Laptop', '2024-05-13 06:49:00', '2024-05-13 06:50:25'),
(8, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'PT Galah', 'asukaloid.blog@gmail.com', '08767655567876', 'Testing', 'Testing', '2024-05-14 04:26:57', '2024-05-14 04:26:57'),
(9, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'PT Sumber Tekno Indotama', 'sumbertekno@gmail.com', '08767655567876', 'Surabaya', 'Supplier Sparepart Laptop', '2024-05-15 04:11:07', '2024-05-15 04:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `pajak` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `store_identifier`, `pajak`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 10, 1, '2024-05-13 05:35:57', '2024-05-13 08:39:28'),
(3, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 0, 0, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, 'DPpU35sGVTUiVpYsj4p1B9MRVdQghS', 0, 0, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

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
  `phone_number_verified_at` timestamp NULL DEFAULT NULL,
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

INSERT INTO `tenants` (`id`, `name`, `email`, `email_verified_at`, `phone`, `phone_number_verified_at`, `password`, `is_active`, `id_inv_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Anrdiansyah Indra', 'asukaloid.blog@gmail.com', '2024-05-13 05:36:37', '085156719832', '2024-05-01 02:35:09', '$2y$12$WORIOl3L9E.5MdEYVAq2Ou9MPRJTQlrupMR0YVBv84C9Z0M6D6pqa', 1, 2, NULL, '2024-05-13 05:35:57', '2024-05-16 02:08:51'),
(3, 'Mahendra Syahputro', 'amarwibianto@gmail.com', '2024-05-01 04:25:52', '0878887733933', '2024-05-01 03:50:26', '$2y$12$I/.Eiz1fkTXz/Ar6j/cfKOnEkKV8QTs9Rzk/XZBKEHTNlVnQ2Ie7S', 1, 1, NULL, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, 'Indra Syahputra', 'apriyambodo487@gmail.com', '2024-05-15 05:47:38', '087677677373338', '2024-05-15 05:47:44', '$2y$12$UbjO17qgswec2TIzlt0OIucmP9zSm3X3oMH5HOD59zR74HkW5zNaO', 1, 2, NULL, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_fields`
--

CREATE TABLE `tenant_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `baris1` varchar(255) DEFAULT NULL,
  `baris2` varchar(255) DEFAULT NULL,
  `baris3` varchar(255) DEFAULT NULL,
  `baris4` varchar(255) DEFAULT NULL,
  `baris5` varchar(255) DEFAULT NULL,
  `baris_1_activation` int(11) NOT NULL DEFAULT 0,
  `baris_2_activation` int(11) NOT NULL DEFAULT 0,
  `baris_3_activation` int(11) NOT NULL DEFAULT 0,
  `baris_4_activation` int(11) NOT NULL DEFAULT 0,
  `baris_5_activation` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenant_fields`
--

INSERT INTO `tenant_fields` (`id`, `store_identifier`, `baris1`, `baris2`, `baris3`, `baris4`, `baris5`, `baris_1_activation`, `baris_2_activation`, `baris_3_activation`, `baris_4_activation`, `baris_5_activation`, `created_at`, `updated_at`) VALUES
(2, 'SQrd9ZXHMI7BsSNGQTdJxSatSZcIKb', 'Nama Lengkap Pelanggan', 'Kota Asal Pelanggan', 'Alamat Pelanggan', 'Email Pelanggan', 'No. Telp./WA', 1, 1, 1, 1, 1, '2024-05-13 05:35:57', '2024-05-14 06:10:40'),
(3, 'jjX5bBVABMHesvxxioUa7rDdkQX7cn', 'Nama Pelanggan', 'Kota Asal', 'Alamat Pelanggan', 'Email Pelanggan', 'No. Telp./WA', 1, 1, 1, 1, 1, '2024-05-14 04:25:38', '2024-05-14 04:25:38'),
(4, 'DPpU35sGVTUiVpYsj4p1B9MRVdQghS', 'Nama Pelanggan', 'Kota Asal', 'Alamat Pelanggan', 'Email Pelanggan', 'No. Telp./WA', 1, 1, 1, 1, 1, '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_qris_accounts`
--

CREATE TABLE `tenant_qris_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `qris_login_user` varchar(255) NOT NULL,
  `qris_password` varchar(255) NOT NULL,
  `qris_merchant_id` varchar(255) NOT NULL,
  `qris_store_id` varchar(255) NOT NULL,
  `mdr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tunai_wallets`
--

CREATE TABLE `tunai_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `saldo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tunai_wallets`
--

INSERT INTO `tunai_wallets` (`id`, `id_tenant`, `email`, `saldo`, `created_at`, `updated_at`) VALUES
(2, 2, 'asukaloid.blog@gmail.com', '2580.8', '2024-05-13 05:35:57', '2024-05-15 07:25:29'),
(3, 3, 'amarwibianto@gmail.com', '200', '2024-05-14 04:25:38', '2024-05-14 04:35:15'),
(4, 4, 'apriyambodo487@gmail.com', '0', '2024-05-15 05:46:48', '2024-05-15 05:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `umi_requests`
--

CREATE TABLE `umi_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_approval` date DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `wa_otps`
--

CREATE TABLE `wa_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `validity` int(11) NOT NULL DEFAULT 15,
  `valid` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tanggal_penarikan` date NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `biaya_admin` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `deteksi_ip_address` varchar(255) DEFAULT NULL,
  `deteksi_lokasi_penarikan` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `id_user`, `email`, `tanggal_penarikan`, `nominal`, `biaya_admin`, `tanggal_masuk`, `deteksi_ip_address`, `deteksi_lokasi_penarikan`, `status`, `created_at`, `updated_at`) VALUES
(9, 2, 'asukaloid.blog@gmail.com', '2024-05-16', '10000', '1500', '2024-05-16', '125.164.243.227', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', 1, '2024-05-16 05:46:04', '2024-05-16 05:46:04'),
(10, 2, 'asukaloid.blog@gmail.com', '2024-05-16', '10000', '1500', '2024-05-16', '125.164.243.227', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', 1, '2024-05-16 06:56:23', '2024-05-16 06:56:23'),
(11, 2, 'asukaloid.blog@gmail.com', '2024-05-16', '10000', '1500', '2024-05-16', '125.164.243.227', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', 1, '2024-05-16 07:46:25', '2024-05-16 07:46:25'),
(12, 2, 'asukaloid.blog@gmail.com', '2024-05-16', '10000', '1500', '2024-05-16', '125.164.243.227', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', 1, '2024-05-16 09:16:21', '2024-05-16 09:16:21');

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
-- Indexes for table `agregate_wallets`
--
ALTER TABLE `agregate_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_identifiers`
--
ALTER TABLE `customer_identifiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_identifiers_id_invoice_unique` (`id_invoice`);

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
  ADD UNIQUE KEY `detail_kasirs_email_unique` (`email`),
  ADD UNIQUE KEY `detail_kasirs_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_marketings_id_marketing_unique` (`id_marketing`),
  ADD UNIQUE KEY `detail_marketings_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `detail_penarikans`
--
ALTER TABLE `detail_penarikans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_penarikans_id_penarikan_unique` (`id_penarikan`);

--
-- Indexes for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_tenants_email_unique` (`email`),
  ADD UNIQUE KEY `detail_tenants_no_ktp_unique` (`no_ktp`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_identifier` (`store_identifier`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitation_codes`
--
ALTER TABLE `invitation_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invitation_codes_inv_code_unique` (`inv_code`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_nomor_invoice_unique` (`nomor_invoice`);

--
-- Indexes for table `invoice_fields`
--
ALTER TABLE `invoice_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_fields_id_invoice_unique` (`id_invoice`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nobu_withdraw_fee_histories`
--
ALTER TABLE `nobu_withdraw_fee_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nobu_withdraw_fee_histories_id_penarikan_unique` (`id_penarikan`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_id_index` (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `qris_wallets`
--
ALTER TABLE `qris_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qris_wallets_email_unique` (`email`);

--
-- Indexes for table `rekenings`
--
ALTER TABLE `rekenings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rekenings_email_unique` (`email`);

--
-- Indexes for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_details`
--
ALTER TABLE `store_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_details_email_unique` (`email`),
  ADD UNIQUE KEY `store_details_store_identifier_unique` (`store_identifier`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_identifier` (`store_identifier`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`);

--
-- Indexes for table `tenant_fields`
--
ALTER TABLE `tenant_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_identifier` (`store_identifier`);

--
-- Indexes for table `tenant_qris_accounts`
--
ALTER TABLE `tenant_qris_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenant_qris_accounts_email_unique` (`email`);

--
-- Indexes for table `tunai_wallets`
--
ALTER TABLE `tunai_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tunai_wallets_email_unique` (`email`);

--
-- Indexes for table `umi_requests`
--
ALTER TABLE `umi_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `umi_requests_id_tenant_unique` (`id_tenant`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wa_otps`
--
ALTER TABLE `wa_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `agregate_wallets`
--
ALTER TABLE `agregate_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer_identifiers`
--
ALTER TABLE `customer_identifiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `detail_admins`
--
ALTER TABLE `detail_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_penarikans`
--
ALTER TABLE `detail_penarikans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `invitation_codes`
--
ALTER TABLE `invitation_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `invoice_fields`
--
ALTER TABLE `invoice_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `kasirs`
--
ALTER TABLE `kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `nobu_withdraw_fee_histories`
--
ALTER TABLE `nobu_withdraw_fee_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `qris_wallets`
--
ALTER TABLE `qris_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rekenings`
--
ALTER TABLE `rekenings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `store_details`
--
ALTER TABLE `store_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenant_fields`
--
ALTER TABLE `tenant_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenant_qris_accounts`
--
ALTER TABLE `tenant_qris_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tunai_wallets`
--
ALTER TABLE `tunai_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `umi_requests`
--
ALTER TABLE `umi_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wa_otps`
--
ALTER TABLE `wa_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
