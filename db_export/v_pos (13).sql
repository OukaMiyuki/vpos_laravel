-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 05:01 AM
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
(8, 'Super User', 'adminsu@gmail.com', '2024-02-19 20:54:15', '0851567198324', '$2y$12$xbXT3d9pauKRe9YgtUWs6O0wCU254Ig0ivVlovTey8vyWqSlEV1ve', 1, NULL, '2024-02-16 12:19:05', '2024-02-16 15:42:27'),
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
(5, 7, 'ASCLP', 'Accessories Laptop', '2024-02-20 00:54:16', '2024-02-20 01:04:46'),
(7, 7, 'DSP', 'Desktop Sparepart', '2024-02-20 19:57:04', '2024-02-20 19:57:04');

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
(3, 4, '7654345654342567', 'Sidoarjo', '2001-02-06', 'Perempuan', 'Jl. Wiyung Surabaya No. 45', '-1710224033.jpg', '2024-02-20 01:39:07', '2024-03-11 23:13:53');

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
(4, 7, '8987654565434567', 'Surabaya', '2024-02-01', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:18:50', '2024-02-19 21:18:50'),
(5, 8, '9876545676543234', 'Sidoarjo', '2007-02-06', 'Laki-laki', 'Surabaya', NULL, '2024-03-06 01:09:45', '2024-03-06 01:09:45'),
(6, 9, '9876543672345678', 'Sidoarjo', '1999-01-20', 'Laki-laki', 'Jl. Brigjend Katamso No. 45 Janti Waru Sidoarjo', NULL, '2024-03-21 18:36:18', '2024-03-21 18:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `detail_tenants`
--

CREATE TABLE `detail_tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
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

INSERT INTO `detail_tenants` (`id`, `id_tenant`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `photo`, `created_at`, `updated_at`) VALUES
(1, 3, '9876545676545432', 'Sidoarjo', '2024-01-30', 'Laki-laki', 'Waru, Sidoarjo', NULL, '2024-02-16 12:46:11', '2024-02-16 12:46:11'),
(3, 5, '6754345676545678', 'Sidoarjooo', '2024-02-01', 'Laki-laki', 'Surabaya', '-1708323229.jpg', '2024-02-18 21:23:52', '2024-02-18 23:13:49'),
(4, 6, '8765654567654345', 'Sidoarjo', '2024-01-31', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:53:18', '2024-02-19 21:53:18'),
(5, 7, '7654345654323456', 'Sidoarjo', '2024-01-31', 'Laki-laki', 'Surabaya', NULL, '2024-02-19 21:55:33', '2024-03-11 23:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `min_harga` int(11) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `id_tenant`, `min_harga`, `diskon`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 7, 100000, 2, '2024-02-29', '2024-03-07', 1, '2024-02-28 22:13:24', '2024-02-28 22:13:24');

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `id_kasir` bigint(20) NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
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

INSERT INTO `invoices` (`id`, `id_tenant`, `id_kasir`, `nomor_invoice`, `tanggal_transaksi`, `tanggal_pelunasan`, `jenis_pembayaran`, `qris_data`, `status_pembayaran`, `sub_total`, `pajak`, `diskon`, `nominal_bayar`, `kembalian`, `created_at`, `updated_at`) VALUES
(97, 7, 4, '36L070171550762', '2024-03-19', '2024-03-19', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-03-18 19:33:13', '2024-03-18 19:33:13'),
(98, 7, 4, 'M02503388807536', '2024-03-19', '2024-03-19', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-03-18 19:33:43', '2024-03-18 19:33:43'),
(102, 7, 4, '452117472C19302', '2024-03-19', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214083000006931040303UME51440014ID.CO.QRIS.WWW0215ID20232843944750303UME52045499530336054065821205802ID5912BEST PARKING6008Sidoarjo61056125662530114031904237371260615452117472C193020704IN010804POSP6304C1EF', 0, '529200', '52920', '10800', '582120', NULL, '2024-03-18 21:51:33', '2024-03-18 22:01:35'),
(103, 7, 4, '5767451135273U1', '2024-03-21', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214083000006931040303UME51440014ID.CO.QRIS.WWW0215ID20232843944750303UME52045499530336054061940405802ID5912BEST PARKING6008Sidoarjo610561256625301140321042870972406155767451135273U10704IN010804POSP6304A443', 0, '176400', '17640', '3600', '194040', NULL, '2024-03-20 18:13:13', '2024-03-20 18:13:13'),
(104, 7, 4, '38155E569360742', '2024-03-21', '2024-03-21', 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214083000006931040303UME51440014ID.CO.QRIS.WWW0215ID20232843944750303UME52045499530336054061940405802ID5912BEST PARKING6008Sidoarjo6105612566253011403210428713159061538155E5693607420704IN010804POSP63041F96', 0, '176400', '17640', '3600', '194040', NULL, '2024-03-20 18:13:41', '2024-03-20 18:19:04'),
(105, 7, 4, '14290J311888872', '2024-03-21', '2024-03-21', 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214083000006931040303UME51440014ID.CO.QRIS.WWW0215ID20232843944750303UME52045499530336054061940405802ID5912BEST PARKING6008Sidoarjo6105612566253011403210428714741061514290J3118888720704IN010804POSP6304FA1E', 0, '176400', '17640', '3600', '194040', NULL, '2024-03-20 18:21:33', '2024-03-20 18:21:57'),
(106, 7, 4, 'A89374979750896', '2024-03-21', '2024-03-21', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-03-20 18:22:34', '2024-03-20 19:11:47'),
(107, 7, 4, '70V341711602065', '2024-03-21', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214083000006931040303UME51440014ID.CO.QRIS.WWW0215ID20232843944750303UME52045499530336054061940405802ID5912BEST PARKING6008Sidoarjo6105612566253011403210428763222061570V3417116020650704IN010804POSP6304F36B', 0, '176400', '17640', '3600', '194040', NULL, '2024-03-20 19:33:21', '2024-03-20 19:33:21'),
(110, 7, 4, '69664439652Z919', '2024-03-22', '2024-03-22', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-03-21 20:41:53', '2024-03-21 20:41:53'),
(111, 7, 4, '983726I29885048', '2024-03-22', '2024-03-22', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-03-21 20:43:08', '2024-03-21 20:43:08'),
(112, 7, 4, '8229227G2614554', '2024-04-03', '2024-04-03', 'Tunai', NULL, 1, '176400', '17640', '3600', '200000', '5960', '2024-04-02 18:56:15', '2024-04-02 18:56:15'),
(113, 7, 4, '0246602844451P6', '2024-04-03', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE5204549953033605405970205802ID5908VISIONER6008SURABAYA610561256625301140403047222499706150246602844451P60704IN010804POSP63047093', 0, '88200', '8820', '1800', '97020', NULL, '2024-04-03 00:46:06', '2024-04-03 00:46:08'),
(114, 7, 4, '16905W876108417', '2024-04-03', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054061940405802ID5908VISIONER6008SURABAYA6105612566253011404030472232044061516905W8761084170704IN010804POSP630450EC', 0, '176400', '17640', '3600', '194040', NULL, '2024-04-03 00:48:35', '2024-04-03 00:48:36'),
(115, 7, 4, '386003W57416175', '2024-04-04', NULL, 'Qris', '00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214950488392022540303UBE51440014ID.CO.QRIS.WWW0215ID20232944469430303UBE52045499530336054061940405802ID5908VISIONER6008SURABAYA61056125662530114040404757668010615386003W574161750704IN010804POSP630480DA', 0, '176400', '17640', '3600', '194040', NULL, '2024-04-03 19:14:02', '2024-04-03 19:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_fields`
--

CREATE TABLE `invoice_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` bigint(20) DEFAULT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `id_custom_field` bigint(20) DEFAULT NULL,
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

INSERT INTO `invoice_fields` (`id`, `id_kasir`, `id_invoice`, `id_custom_field`, `content1`, `content2`, `content3`, `content4`, `content5`, `created_at`, `updated_at`) VALUES
(66, 4, 97, 2, '', '', '', '', '', '2024-03-18 19:33:13', '2024-03-18 19:33:13'),
(67, 4, 98, 2, '', '', '', '', '', '2024-03-18 19:33:43', '2024-03-18 19:33:43'),
(68, 4, 103, 2, '', '', '', '', '', '2024-03-20 18:13:13', '2024-03-20 18:13:13'),
(69, 4, 104, 2, '', '', '', '', '', '2024-03-20 18:19:04', '2024-03-20 18:19:04'),
(70, 4, 105, 2, '', '', '', '', '', '2024-03-20 18:21:57', '2024-03-20 18:21:57'),
(71, 4, 106, 2, '', '', '', '', '', '2024-03-20 18:24:13', '2024-03-20 18:24:13'),
(72, 4, 107, 2, 'Amar Wibianto', '', '', '', '', '2024-03-20 19:33:21', '2024-03-20 19:33:21'),
(73, 4, 109, 2, '', '', '', '', '', '2024-03-21 20:39:21', '2024-03-21 20:39:21'),
(74, 4, 110, 2, 'Amar Wibi', 'Surabaya', 'Janti', 'a@a.com', '02109381203912', '2024-03-21 20:41:53', '2024-03-21 20:41:53'),
(75, 4, 111, 2, '', '', '', '', '', '2024-03-21 20:43:08', '2024-03-21 20:43:08'),
(76, 4, 112, 2, '', '', '', '', '', '2024-04-02 18:56:15', '2024-04-02 18:56:15'),
(77, 4, 115, 2, '', '', '', '', '', '2024-04-03 19:14:02', '2024-04-03 19:14:02');

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
(4, 'Indira Putri Hanifah', 'indiraputri456@gmail.com', NULL, '0813456786345', '$2y$12$m/16EM72YhLcsr2xGMo9Ce7jhrvgIzmUzb/06kkHPYIQavqToOO9C', 1, 7, NULL, '2024-02-20 01:39:07', '2024-03-11 23:17:09');

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
(5, 'Inayah Indah Putri', 'inay_98767@gmail.com', '2024-02-19 21:19:32', '0815625337232', '$2y$12$hnUwP.UcO/Pq80rmshFPseJU0xebXQ2eJfU1gOOsoKo5zmBQhbpJu', 1, NULL, '2024-02-16 12:47:50', '2024-02-16 20:37:59'),
(7, 'Angga Priyambodo', 'apriyambodo487@gmail.com', '2024-02-19 21:19:32', '087654434567', '$2y$12$iiuX1DSrtWA7.NOdMzqqoePa8sr8jq6MIMzuBbd98U4Vx66Th9ghG', 0, NULL, '2024-02-19 21:18:50', '2024-02-19 21:19:32'),
(8, 'Jaka Pratama', 'ficationfoxi@gmail.com', NULL, '087656778765', '$2y$12$GLXq9Zrp6bVOqkQ3d/FxD.1iHhdY2SbSPDce7F3pn/33hxNE8Zwb2', 0, NULL, '2024-03-06 01:09:45', '2024-03-06 01:09:45'),
(9, 'Dzati Amar Wibianto', 'amarwibianto@gmail.com', '2024-03-21 18:37:00', '087456736654', '$2y$12$sqeVHbCXACjLOcQ14L9psuZES2W.c4cIS2FcCID2KRQ0pRlFVIqme', 0, NULL, '2024-03-21 18:36:18', '2024-03-21 18:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_wallets`
--

CREATE TABLE `marketing_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_marketing` bigint(20) NOT NULL,
  `saldo` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketing_wallets`
--

INSERT INTO `marketing_wallets` (`id`, `id_marketing`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 5, '0', NULL, NULL);

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
(83, '2024_04_01_014752_create_messages_table', 46);

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
(44, 'App\\Models\\Kasir', 4, 'auth_token', '4110317114f2c12faf20dc22626e1b5eb10ac267f36c290b98a19131a3707e5c', '[\"*\"]', '2024-04-03 00:48:35', NULL, '2024-04-02 19:33:33', '2024-04-03 00:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
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

INSERT INTO `products` (`id`, `id_tenant`, `id_batch`, `id_category`, `index_number`, `product_code`, `product_name`, `id_supplier`, `photo`, `nomor_gudang`, `nomor_rak`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 7, 7, 10, 1, 'DSP-000001', 'Team T-Force Delta 2400 2x4 DDR4', 4, 'Team T-Force Delta 2400 2x4 DDR4-1708484401.jpg', '1', '1', '800000', '2024-02-20 20:00:01', '2024-02-25 23:55:36'),
(2, 7, 7, 10, 2, 'DSP-000002', 'Samsung EVO 256 SSD', 4, 'Samsung EVO 256 SSD-1708484708.jpg', '1', '1', '800000', '2024-02-20 20:05:08', '2024-02-21 18:44:21'),
(3, 7, 7, 10, 3, 'DSP-000003', 'Vodirk Combo Gaming Keyboard Mouse Rgb Led Mechanical Feel Gt100 - Putih', 4, 'Vodirk Combo Gaming Keyboard Mouse Rgb Led Mechanical Feel Gt100 - Putih-1708484825.webp', '1', '1', '86000', '2024-02-20 20:07:05', '2024-02-21 18:43:43'),
(4, 7, 7, 2, 4, 'DSP-000004', 'AMD Ryzen 5 5600G 3.9 GHz Six-Core AM4 Processor', 4, 'AMD Ryzen 5 5600G 3.9 GHz Six-Core AM4 Processor-1708485160.webp', '1', '2', '2885000', '2024-02-20 20:12:40', '2024-02-21 22:47:19'),
(5, 7, 1, 1, 1, 'LSP-000001', 'Keyboard Laptop Notebook Asus X200 X200C X200CA X200M X200MA', 4, 'Keyboard Laptop Notebook Asus X200 X200C X200CA X200M X200MA-1708485296.jpg', '1', '2', '90000', '2024-02-20 20:14:56', '2024-02-25 23:52:45'),
(6, 7, 3, 11, 1, 'LP-000001', 'Asus ZenBook Pro Duo UX-8402VU Intel® Core™ i9-13900H Tech Black 1set', 4, '-1708489873.avif', '1', '1', '48000000', '2024-02-20 20:16:52', '2024-02-21 18:42:34'),
(8, 7, 5, 10, 1, 'ASCLP-000001', 'Flashdisk Sandisk Cruzer Blade 128GB', 4, 'Flashdisk Sandisk Cruzer Blade 128GB-1708572764.webp', '1', '1', '180000', '2024-02-21 20:32:44', '2024-02-21 23:04:32');

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
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
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

INSERT INTO `product_stocks` (`id`, `id_tenant`, `id_batch_product`, `barcode`, `tanggal_beli`, `tanggal_expired`, `harga_beli`, `stok`, `created_at`, `updated_at`) VALUES
(2, 7, 8, '09839287432932', '2024-02-15', '2024-04-05', '180000', 92, '2024-02-21 21:43:03', '2024-04-03 00:48:15'),
(4, 7, 4, '293879237432', '2024-01-31', NULL, '2200000', 200, '2024-02-21 22:47:19', '2024-02-21 22:47:19'),
(5, 7, 5, '298039183010', '2024-02-07', NULL, '180000', 26, '2024-02-25 23:52:21', '2024-04-03 00:45:48'),
(6, 7, 5, '47324982473472', '2024-01-31', NULL, '180000', 28, '2024-02-25 23:52:45', '2024-03-13 01:09:49'),
(7, 7, 1, '213232132132', '2024-01-31', NULL, '750000', 177, '2024-02-25 23:55:36', '2024-03-18 21:32:54'),
(8, 7, 8, '4454334434234', '2024-03-12', NULL, '50000', 8, '2024-03-14 00:35:40', '2024-04-03 19:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `qris_wallets`
--

CREATE TABLE `qris_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `saldo` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qris_wallets`
--

INSERT INTO `qris_wallets` (`id`, `id_tenant`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 9, '0', '2024-03-21 18:36:18', '2024-03-21 18:36:18'),
(2, 3, '0', NULL, NULL),
(3, 5, '0', NULL, NULL),
(4, 7, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kasir` bigint(20) DEFAULT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `id_product` bigint(20) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `id_kasir`, `id_invoice`, `id_product`, `product_name`, `qty`, `harga`, `sub_total`, `created_at`, `updated_at`) VALUES
(111, NULL, 97, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-18 19:33:13', '2024-03-18 19:33:13'),
(112, NULL, 98, 2, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-18 19:33:43', '2024-03-18 19:33:43'),
(126, 4, 102, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 3, '180000', '540000', '2024-03-18 21:49:44', '2024-03-18 21:54:03'),
(127, NULL, 103, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:13:13', '2024-03-20 18:13:13'),
(128, NULL, 104, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:13:41', '2024-03-20 18:13:41'),
(129, NULL, 104, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:19:04', '2024-03-20 18:19:04'),
(130, NULL, 105, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:21:33', '2024-03-20 18:21:33'),
(131, NULL, 105, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:21:57', '2024-03-20 18:21:57'),
(132, NULL, 106, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 18:22:34', '2024-03-20 18:22:34'),
(133, NULL, 107, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-20 19:33:21', '2024-03-20 19:33:21'),
(136, NULL, 110, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-21 20:41:53', '2024-03-21 20:41:53'),
(137, NULL, 111, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-03-21 20:43:08', '2024-03-21 20:43:08'),
(142, 4, 113, 5, 'Keyboard Laptop Notebook Asus X200 X200C X200CA X200M X200MA', 1, '90000', '90000', '2024-04-03 00:45:48', '2024-04-03 00:46:06'),
(143, 4, 114, 2, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-04-03 00:48:15', '2024-04-03 00:48:35'),
(144, NULL, 115, 8, 'Flashdisk Sandisk Cruzer Blade 128GB', 1, '180000', '180000', '2024-04-03 19:14:02', '2024-04-03 19:14:02');

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
(3, 7, 'Toko Komputer Surabaya', 'Jl. Brigjend Katamso No. 45', 'Penjualan Alat dan Aksesoris Komputer', 1, '-1708406926.jpg', '2024-02-19 21:55:33', '2024-02-19 22:28:46'),
(4, 8, NULL, NULL, NULL, NULL, NULL, '2024-03-12 19:49:43', '2024-03-12 19:49:43'),
(5, 9, NULL, NULL, NULL, NULL, NULL, '2024-03-12 19:56:39', '2024-03-12 19:56:39'),
(6, 10, NULL, NULL, NULL, NULL, NULL, '2024-03-12 20:17:53', '2024-03-12 20:17:53'),
(7, 11, NULL, NULL, NULL, NULL, NULL, '2024-03-12 20:54:25', '2024-03-12 20:54:25'),
(8, 12, NULL, NULL, NULL, NULL, NULL, '2024-03-12 21:37:15', '2024-03-12 21:37:15'),
(9, 14, NULL, NULL, NULL, NULL, NULL, '2024-03-17 17:53:32', '2024-03-17 17:53:32');

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
(8, 7, 'PT. Sparepart Iphone', 'iphoneofficialsparepart@gmailc.com', '087637323383', 'Jl. Pemuda Surabaya Merdeka No. 45 Wiyung Surabaya, 61254', 'Suppier penyedia untuk sparepart iphone', '2024-02-19 23:26:53', '2024-02-19 23:26:53'),
(10, 7, 'PT Galah', 'A@w.com', '09304203948', 'Janti', 'Waru', '2024-03-05 23:05:25', '2024-03-05 23:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `pajak` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `id_tenant`, `pajak`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 7, 10, 1, '2024-02-28 20:21:47', '2024-02-28 20:28:55');

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
(7, 'Anrdiansyah Indra Syahputra', 'solutionmanunggal@gmail.com', '2024-02-19 21:55:58', '087654322434', '$2y$12$P5XligLGwUlOur3nKi8Mxen15puedI8QCs/TOUIhl3e6wD0YgxVyO', 1, 2, NULL, '2024-02-19 21:55:33', '2024-03-11 23:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_fields`
--

CREATE TABLE `tenant_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
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

INSERT INTO `tenant_fields` (`id`, `id_tenant`, `baris1`, `baris2`, `baris3`, `baris4`, `baris5`, `baris_1_activation`, `baris_2_activation`, `baris_3_activation`, `baris_4_activation`, `baris_5_activation`, `created_at`, `updated_at`) VALUES
(2, 7, 'Nama', 'Kota', 'Alamat', 'Email', 'No. Telp/WA', 1, 1, 1, 1, 1, '2024-03-14 17:17:44', '2024-03-14 18:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `tunai_wallets`
--

CREATE TABLE `tunai_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) NOT NULL,
  `saldo` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tunai_wallets`
--

INSERT INTO `tunai_wallets` (`id`, `id_tenant`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 3, '0', NULL, NULL),
(2, 5, '0', NULL, NULL),
(3, 7, '1164240', NULL, '2024-04-02 18:56:15');

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
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_id_tenant_unique` (`id_tenant`);

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
-- Indexes for table `marketing_wallets`
--
ALTER TABLE `marketing_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marketing_wallets_id_marketing_unique` (`id_marketing`);

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
  ADD UNIQUE KEY `id_user` (`id_tenant`),
  ADD UNIQUE KEY `id_tenant` (`id_tenant`);

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
  ADD UNIQUE KEY `store_details_id_tenant_unique` (`id_tenant`);

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
  ADD UNIQUE KEY `id_tenant` (`id_tenant`);

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
  ADD UNIQUE KEY `id_tenant` (`id_tenant`);

--
-- Indexes for table `tunai_wallets`
--
ALTER TABLE `tunai_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_tenant` (`id_tenant`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_admins`
--
ALTER TABLE `detail_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `invoice_fields`
--
ALTER TABLE `invoice_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `kasirs`
--
ALTER TABLE `kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `marketing_wallets`
--
ALTER TABLE `marketing_wallets`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `qris_wallets`
--
ALTER TABLE `qris_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `store_details`
--
ALTER TABLE `store_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tenant_fields`
--
ALTER TABLE `tenant_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tunai_wallets`
--
ALTER TABLE `tunai_wallets`
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
