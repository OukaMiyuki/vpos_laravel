-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 09:30 PM
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
  `access_level` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `phone`, `password`, `is_active`, `access_level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Super User', 'adminsu@vipos.id', '2024-05-22 23:00:48', '0', '$2y$12$xbXT3d9pauKRe9YgtUWs6O0wCU254Ig0ivVlovTey8vyWqSlEV1ve', 1, 1, NULL, NULL, NULL);

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
(1, '0', NULL, '2024-05-16 09:16:21');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'LP', 'Laptop', '2024-05-23 19:03:25', '2024-05-23 19:03:25'),
(2, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'DP', 'Desktop', '2024-05-23 19:03:36', '2024-05-23 19:03:36'),
(3, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'PTR', 'Printer', '2024-05-23 19:03:46', '2024-05-23 19:03:46');

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
(1, 1, '1234567890123456', 'Surabaya', '2015-05-01', 'Laki-laki', 'Surabaya', NULL, NULL, NULL);

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
(1, 1, '7676545676545678', 'Surabaya', '2003-01-23', 'Laki-laki', 'Jl. Brigjend Katamso No. 45', '-1716436664.jpg', '2024-05-23 03:07:39', '2024-05-23 03:57:44');

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
  `biaya_tenant` varchar(255) DEFAULT NULL,
  `biaya_admin_su` varchar(255) DEFAULT NULL,
  `biaya_agregate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '1', 'jackronald118899@gmail.com', '0987654321234567', 'Surabaya', '1990-01-08', 'Laki-laki', 'Jl. Brigjend Katamso No. 45', NULL, '2024-05-23 01:59:31', '2024-05-23 01:59:31'),
(2, '2', 'ficationfoxy@gmail.com', '7564736473647364', 'Surabaya', '2000-05-08', 'Laki-laki', 'Jl. Pemuda SUrabaya No 45', '-1716471828.jpg', '2024-05-23 13:37:21', '2024-05-23 13:43:48');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', NULL, 0, NULL, NULL, 0, '2024-05-23 13:37:21', '2024-05-23 13:37:21');

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
(1, NULL, 'jackronald118899@gmail.com', 'Register Tenant : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select count(*) as aggregate from `admins` where `email` = ?\",\"bindings\":[\"jackronald118899@gmail.com\"],\"time\":4.84},{\"query\":\"select count(*) as aggregate from `marketings` where `email` = ?\",\"bindings\":[\"jackronald118899@gmail.com\"],\"time\":0.45},{\"query\":\"select count(*) as aggregate from `tenants` where `email` = ?\",\"bindings\":[\"jackronald118899@gmail.com\"],\"time\":0.84},{\"query\":\"select count(*) as aggregate from `kasirs` where `email` = ?\",\"bindings\":[\"jackronald118899@gmail.com\"],\"time\":0.44},{\"query\":\"select count(*) as aggregate from `detail_admins` where `no_ktp` = ?\",\"bindings\":[\"0987654321234567\"],\"time\":0.7},{\"query\":\"select count(*) as aggregate from `detail_marketings` where `no_ktp` = ?\",\"bindings\":[\"0987654321234567\"],\"time\":0.81},{\"query\":\"select count(*) as aggregate from `detail_tenants` where `no_ktp` = ?\",\"bindings\":[\"0987654321234567\"],\"time\":0.55},{\"query\":\"select count(*) as aggregate from `detail_kasirs` where `no_ktp` = ?\",\"bindings\":[\"0987654321234567\"],\"time\":0.71},{\"query\":\"select count(*) as aggregate from `admins` where `phone` = ?\",\"bindings\":[\"087739882723\"],\"time\":0.39},{\"query\":\"select count(*) as aggregate from `marketings` where `phone` = ?\",\"bindings\":[\"087739882723\"],\"time\":0.34},{\"query\":\"select count(*) as aggregate from `tenants` where `phone` = ?\",\"bindings\":[\"087739882723\"],\"time\":0.55},{\"query\":\"select count(*) as aggregate from `kasirs` where `phone` = ?\",\"bindings\":[\"087739882723\"],\"time\":0.33},{\"query\":\"insert into `tenants` (`name`, `email`, `phone`, `password`, `id_inv_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"Rico Robert\",\"jackronald118899@gmail.com\",\"087739882723\",\"$2y$12$bUThobihB.WZjt5tJYnueOkxCgSAKv7war2XaJslKmW5Wp6TxXnTe\",0,\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":3.96},{\"query\":\"insert into `detail_tenants` (`id_tenant`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[1,\"jackronald118899@gmail.com\",\"0987654321234567\",\"Surabaya\",\"1990-01-08\",\"Laki-laki\",\"Jl. Brigjend Katamso No. 45\",\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":1.48},{\"query\":\"insert into `tunai_wallets` (`id_tenant`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[1,\"jackronald118899@gmail.com\",0,\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":2.04},{\"query\":\"insert into `rekenings` (`id_user`, `email`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[1,\"jackronald118899@gmail.com\",\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":1.05},{\"query\":\"insert into `qris_wallet_pendings` (`id_user`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[1,\"jackronald118899@gmail.com\",0,\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":1.57},{\"query\":\"insert into `qris_wallets` (`id_user`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[1,\"jackronald118899@gmail.com\",0,\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":1.11},{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"jackronald118899@gmail.com\",true],\"time\":0.44},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"jackronald118899@gmail.com\",\"199312\",30,\"2024-05-23 08:59:31\",\"2024-05-23 08:59:31\"],\"time\":1.36}]', 1, '2024-05-23 01:59:35', '2024-05-23 01:59:35'),
(2, 1, 'abdellarentia@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_marketings` where `detail_marketings`.`id_marketing` = ? and `detail_marketings`.`id_marketing` is not null limit 1\",\"bindings\":[1],\"time\":0.74},{\"query\":\"select * from `detail_marketings` where `detail_marketings`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.51},{\"query\":\"select * from `marketings` where `marketings`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.55},{\"query\":\"update `marketings` set `name` = ?, `marketings`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Andin Indrianti\",\"2024-05-23 10:57:33\",1],\"time\":3.18}]', 1, '2024-05-23 03:57:33', '2024-05-23 03:57:33'),
(3, 1, 'abdellarentia@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_marketings` where `detail_marketings`.`id_marketing` = ? and `detail_marketings`.`id_marketing` is not null limit 1\",\"bindings\":[1],\"time\":0.69},{\"query\":\"select * from `detail_marketings` where `detail_marketings`.`id` = ? limit 1\",\"bindings\":[1],\"time\":1.52},{\"query\":\"select * from `marketings` where `marketings`.`id` = ? limit 1\",\"bindings\":[1],\"time\":0.39},{\"query\":\"update `detail_marketings` set `photo` = ?, `detail_marketings`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"-1716436664.jpg\",\"2024-05-23 10:57:44\",1],\"time\":3.61}]', 1, '2024-05-23 03:57:44', '2024-05-23 03:57:44'),
(4, NULL, 'abdellarentia@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `admins` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":80.23},{\"query\":\"select * from `marketings` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":2.98}]', 1, '2024-05-23 08:51:56', '2024-05-23 08:51:56'),
(5, 1, 'abdellarentia@gmail.com', 'Send OTP : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"085156719832\",true],\"time\":1.54},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"085156719832\",\"181764\",5,\"2024-05-23 16:27:58\",\"2024-05-23 16:27:58\"],\"time\":1.7}]', 1, '2024-05-23 09:28:16', '2024-05-23 09:28:16'),
(6, 1, 'abdellarentia@gmail.com', 'Change Rekening : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `otps` where `identifier` = ? and `token` = ? limit 1\",\"bindings\":[\"085156719832\",\"181764\"],\"time\":1.45},{\"query\":\"update `otps` set `valid` = ?, `otps`.`updated_at` = ? where `id` = ?\",\"bindings\":[false,\"2024-05-23 16:28:56\",5],\"time\":4.2},{\"query\":\"select * from `rekenings` where `id_user` = ? and `email` = ? limit 1\",\"bindings\":[1,\"abdellarentia@gmail.com\"],\"time\":1.3},{\"query\":\"update `rekenings` set `nama_bank` = ?, `swift_code` = ?, `no_rekening` = ?, `rekenings`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"PT. BANK DIGITAL BCA\",\"BBLUIDJA\",\"5065205758\",\"2024-05-23 16:28:57\",3],\"time\":2.73}]', 1, '2024-05-23 09:28:57', '2024-05-23 09:28:57'),
(7, 1, 'abdellarentia@gmail.com', 'Send OTP : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"085156719832\",true],\"time\":0.72},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"085156719832\",\"448885\",5,\"2024-05-23 16:52:11\",\"2024-05-23 16:52:11\"],\"time\":1.48}]', 1, '2024-05-23 09:52:13', '2024-05-23 09:52:13'),
(8, NULL, 'abdellarentia@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `admins` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":123.86},{\"query\":\"select * from `marketings` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":1.51}]', 1, '2024-05-23 12:12:54', '2024-05-23 12:12:54'),
(9, 1, 'abdellarentia@gmail.com', 'Create Invitation Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `invitation_codes` where `inv_code` = ? limit 1\",\"bindings\":[\"PUTR1\"],\"time\":1.59},{\"query\":\"insert into `invitation_codes` (`id_marketing`, `holder`, `inv_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[1,\"Putri Nirmala\",\"PUTR1\",\"2024-05-23 19:47:39\",\"2024-05-23 19:47:39\"],\"time\":1.78}]', 1, '2024-05-23 12:47:39', '2024-05-23 12:47:39'),
(10, 1, 'abdellarentia@gmail.com', 'Create Invitation Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `invitation_codes` where `inv_code` = ? limit 1\",\"bindings\":[\"ZRTY1\"],\"time\":0.82},{\"query\":\"insert into `invitation_codes` (`id_marketing`, `holder`, `inv_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[1,\"Budi Santoso\",\"ZRTY1\",\"2024-05-23 19:47:57\",\"2024-05-23 19:47:57\"],\"time\":3.4}]', 1, '2024-05-23 12:47:57', '2024-05-23 12:47:57'),
(11, NULL, 'ficationfoxy@gmail.com', 'Register Tenant : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select count(*) as aggregate from `admins` where `email` = ?\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":5.91},{\"query\":\"select count(*) as aggregate from `marketings` where `email` = ?\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":0.92},{\"query\":\"select count(*) as aggregate from `tenants` where `email` = ?\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":1.8},{\"query\":\"select count(*) as aggregate from `kasirs` where `email` = ?\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":2.15},{\"query\":\"select count(*) as aggregate from `detail_admins` where `no_ktp` = ?\",\"bindings\":[\"7564736473647364\"],\"time\":2.29},{\"query\":\"select count(*) as aggregate from `detail_marketings` where `no_ktp` = ?\",\"bindings\":[\"7564736473647364\"],\"time\":1.78},{\"query\":\"select count(*) as aggregate from `detail_tenants` where `no_ktp` = ?\",\"bindings\":[\"7564736473647364\"],\"time\":1.19},{\"query\":\"select count(*) as aggregate from `detail_kasirs` where `no_ktp` = ?\",\"bindings\":[\"7564736473647364\"],\"time\":1.95},{\"query\":\"select count(*) as aggregate from `admins` where `phone` = ?\",\"bindings\":[\"0876555445223\"],\"time\":1.48},{\"query\":\"select count(*) as aggregate from `marketings` where `phone` = ?\",\"bindings\":[\"0876555445223\"],\"time\":0.62},{\"query\":\"select count(*) as aggregate from `tenants` where `phone` = ?\",\"bindings\":[\"0876555445223\"],\"time\":0.48},{\"query\":\"select count(*) as aggregate from `kasirs` where `phone` = ?\",\"bindings\":[\"0876555445223\"],\"time\":1.44},{\"query\":\"select count(*) as aggregate from `invitation_codes` where `inv_code` = ? and (`inv_code` = ?)\",\"bindings\":[\"ZRTY1\",\"ZRTY1\"],\"time\":0.61},{\"query\":\"select * from `invitation_codes` where `inv_code` = ? limit 1\",\"bindings\":[\"ZRTY1\"],\"time\":0.55},{\"query\":\"insert into `tenants` (`name`, `email`, `phone`, `password`, `id_inv_code`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"Rico Hermawan Indra\",\"ficationfoxy@gmail.com\",\"0876555445223\",\"$2y$12$RPWIf4qCtarQQIeQsjl\\/ier\\/cA428HutHMAai2iNWDzgSsV.f0TsO\",2,\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":4.52},{\"query\":\"insert into `detail_tenants` (`id_tenant`, `email`, `no_ktp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[2,\"ficationfoxy@gmail.com\",\"7564736473647364\",\"Surabaya\",\"2000-05-08\",\"Laki-laki\",\"Jl. Pemuda SUrabaya No 45\",\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":5.57},{\"query\":\"insert into `tenant_fields` (`store_identifier`, `baris1`, `baris2`, `baris3`, `baris4`, `baris5`, `baris_1_activation`, `baris_2_activation`, `baris_3_activation`, `baris_4_activation`, `baris_5_activation`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"Nama Pelanggan\",\"Kota Asal\",\"Alamat Pelanggan\",\"Email Pelanggan\",\"No. Telp.\\/WA\",1,1,1,1,1,\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":3.14},{\"query\":\"insert into `store_details` (`store_identifier`, `id_tenant`, `email`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",2,\"ficationfoxy@gmail.com\",\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":2.61},{\"query\":\"insert into `taxes` (`store_identifier`, `updated_at`, `created_at`) values (?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":2.55},{\"query\":\"insert into `discounts` (`store_identifier`, `updated_at`, `created_at`) values (?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":2.59},{\"query\":\"insert into `tunai_wallets` (`id_tenant`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[2,\"ficationfoxy@gmail.com\",0,\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":2.64},{\"query\":\"insert into `rekenings` (`id_user`, `email`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[2,\"ficationfoxy@gmail.com\",\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":1.24},{\"query\":\"insert into `qris_wallet_pendings` (`id_user`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[2,\"ficationfoxy@gmail.com\",0,\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":2.15},{\"query\":\"insert into `qris_wallets` (`id_user`, `email`, `saldo`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[2,\"ficationfoxy@gmail.com\",0,\"2024-05-23 20:37:21\",\"2024-05-23 20:37:21\"],\"time\":1.28},{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"ficationfoxy@gmail.com\",true],\"time\":1.26},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"ficationfoxy@gmail.com\",\"759348\",30,\"2024-05-23 20:37:22\",\"2024-05-23 20:37:22\"],\"time\":1.54}]', 1, '2024-05-23 13:37:30', '2024-05-23 13:37:30'),
(12, 2, 'ficationfoxy@gmail.com', 'Change profile information : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `detail_tenants` where `detail_tenants`.`id_tenant` = ? and `detail_tenants`.`id_tenant` is not null limit 1\",\"bindings\":[2],\"time\":1.21},{\"query\":\"select * from `detail_tenants` where `id_tenant` = ? and `email` = ? and `detail_tenants`.`id` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\",2],\"time\":0.94},{\"query\":\"select * from `tenants` where `id` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.54},{\"query\":\"update `detail_tenants` set `photo` = ?, `detail_tenants`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"-1716471828.jpg\",\"2024-05-23 20:43:48\",2],\"time\":1.8}]', 1, '2024-05-23 13:43:48', '2024-05-23 13:43:48'),
(13, 2, 'ficationfoxy@gmail.com', 'Update Store Profile : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":1.36},{\"query\":\"update `store_details` set `name` = ?, `alamat` = ?, `kabupaten` = ?, `kode_pos` = ?, `no_telp_toko` = ?, `jenis_usaha` = ?, `catatan_kaki` = ?, `photo` = ?, `store_details`.`updated_at` = ? where `id` = ?\",\"bindings\":[\"Indotech Comp\",\"Jl. Pemuda Nusantara No. 56\",\"Surabaya\",\"61256\",\"087655654332\",\"5045 - COMPUTERS & COMPUTER PERIPHERAL EQUIPMENT & SERVICES\",\"Terima Kasih sudah berkunjung ke toko kami.\",\"-1716475579.avif\",\"2024-05-23 21:46:19\",1],\"time\":29.94}]', 1, '2024-05-23 14:46:19', '2024-05-23 14:46:19'),
(14, 2, 'ficationfoxy@gmail.com', 'Send OTP : Error!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'GuzzleHttp\\Exception\\ClientException: Client error: `POST https://waq.my.id/send-message` resulted in a `400 Bad Request` response:\n                                    {\"status\":false,\"msg\":\"Failed to send message!\"}\n in D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Exception\\RequestException.php:113\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create(Object(GuzzleHttp\\Psr7\\Request), Object(GuzzleHttp\\Psr7\\Response), NULL, Array, NULL)\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Response))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler(1, Object(GuzzleHttp\\Psr7\\Response), NULL)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run(true)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\ClientTrait.php(95): GuzzleHttp\\Client->request(\'POST\', \'https://waq.my....\', Array)\n#11 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(659): GuzzleHttp\\Client->post(\'https://waq.my....\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->whatsappNotification()\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'whatsappNotific...\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'whatsappNotific...\')\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'10\', \'1\')\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#69 {main}', 0, '2024-05-23 15:17:25', '2024-05-23 15:17:25'),
(15, 2, 'ficationfoxy@gmail.com', 'Send OTP : Error!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'GuzzleHttp\\Exception\\ClientException: Client error: `POST https://waq.my.id/send-message` resulted in a `400 Bad Request` response:\n                                    {\"status\":false,\"msg\":\"Failed to send message!\"}\n in D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Exception\\RequestException.php:113\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create(Object(GuzzleHttp\\Psr7\\Request), Object(GuzzleHttp\\Psr7\\Response), NULL, Array, NULL)\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Response))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler(1, Object(GuzzleHttp\\Psr7\\Response), NULL)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run(true)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\ClientTrait.php(95): GuzzleHttp\\Client->request(\'POST\', \'https://waq.my....\', Array)\n#11 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(659): GuzzleHttp\\Client->post(\'https://waq.my....\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->whatsappNotification()\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'whatsappNotific...\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'whatsappNotific...\')\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'10\', \'1\')\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#69 {main}', 0, '2024-05-23 15:17:37', '2024-05-23 15:17:37');
INSERT INTO `histories` (`id`, `id_user`, `email`, `action`, `lokasi_anda`, `deteksi_ip`, `log`, `status`, `created_at`, `updated_at`) VALUES
(16, 2, 'ficationfoxy@gmail.com', 'Send OTP : Error!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'GuzzleHttp\\Exception\\ClientException: Client error: `POST https://waq.my.id/send-message` resulted in a `400 Bad Request` response:\n                                    {\"status\":false,\"msg\":\"Failed to send message!\"}\n in D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Exception\\RequestException.php:113\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create(Object(GuzzleHttp\\Psr7\\Request), Object(GuzzleHttp\\Psr7\\Response), NULL, Array, NULL)\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Response))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler(1, Object(GuzzleHttp\\Psr7\\Response), NULL)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run(true)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\ClientTrait.php(95): GuzzleHttp\\Client->request(\'POST\', \'https://waq.my....\', Array)\n#11 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(659): GuzzleHttp\\Client->post(\'https://waq.my....\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->whatsappNotification()\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'whatsappNotific...\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'whatsappNotific...\')\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'10\', \'1\')\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#69 {main}', 0, '2024-05-23 15:18:22', '2024-05-23 15:18:22'),
(17, NULL, 'abdellarentia@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `admins` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":8.07},{\"query\":\"select * from `marketings` where `email` = ? limit 1\",\"bindings\":[\"abdellarentia@gmail.com\"],\"time\":4.89}]', 1, '2024-05-23 15:56:41', '2024-05-23 15:56:41'),
(18, 1, 'abdellarentia@gmail.com', 'Send OTP : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"085156719832\",true],\"time\":2.43},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"085156719832\",\"516493\",5,\"2024-05-23 22:56:59\",\"2024-05-23 22:56:59\"],\"time\":2.03}]', 1, '2024-05-23 15:57:02', '2024-05-23 15:57:02'),
(19, 1, 'abdellarentia@gmail.com', 'Send OTP : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"delete from `otps` where `identifier` = ? and `valid` = ?\",\"bindings\":[\"085156719832\",true],\"time\":2.32},{\"query\":\"insert into `otps` (`identifier`, `token`, `validity`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"085156719832\",\"431338\",5,\"2024-05-23 23:00:43\",\"2024-05-23 23:00:43\"],\"time\":1.88}]', 1, '2024-05-23 16:00:45', '2024-05-23 16:00:45'),
(20, 2, 'ficationfoxy@gmail.com', 'Send OTP : Error!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', 'GuzzleHttp\\Exception\\ClientException: Client error: `POST https://waq.my.id/send-message` resulted in a `400 Bad Request` response:\n                                    {\"status\":false,\"msg\":\"Failed to send message!\"}\n in D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Exception\\RequestException.php:113\nStack trace:\n#0 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create(Object(GuzzleHttp\\Psr7\\Request), Object(GuzzleHttp\\Psr7\\Response), NULL, Array, NULL)\n#1 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}(Object(GuzzleHttp\\Psr7\\Response))\n#2 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler(1, Object(GuzzleHttp\\Psr7\\Response), NULL)\n#3 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run(true)\n#5 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\promises\\src\\Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 D:\\Projects\\Websites\\vpos_laravel\\vendor\\guzzlehttp\\guzzle\\src\\ClientTrait.php(95): GuzzleHttp\\Client->request(\'POST\', \'https://waq.my....\', Array)\n#11 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Controllers\\Auth\\Tenant\\ProfileController.php(659): GuzzleHttp\\Client->post(\'https://waq.my....\', Array)\n#12 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\Auth\\Tenant\\ProfileController->whatsappNotification()\n#13 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction(\'whatsappNotific...\', Array)\n#14 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\Auth\\Tenant\\ProfileController), \'whatsappNotific...\')\n#15 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()\n#16 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(806): Illuminate\\Routing\\Route->run()\n#17 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#18 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\IsTenantActive.php(29): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#19 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\IsTenantActive->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#20 D:\\Projects\\Websites\\vpos_laravel\\app\\Http\\Middleware\\TenantEmailVerification.php(25): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#21 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): App\\Http\\Middleware\\TenantEmailVerification->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#22 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#23 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#24 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#25 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#26 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'10\', \'1\')\n#27 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(159): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(90): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)\n#29 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#30 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Auth\\Middleware\\Authenticate.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#31 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Auth\\Middleware\\Authenticate->handle(Object(Illuminate\\Http\\Request), Object(Closure), \'tenant\')\n#32 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#33 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#34 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Middleware\\ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#35 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(121): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Session\\Middleware\\StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#38 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#39 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#40 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#41 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Cookie\\Middleware\\EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#42 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#43 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#44 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(805): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#45 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#46 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(748): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#47 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#48 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#49 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#50 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#51 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#52 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#53 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#54 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#55 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#56 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#57 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#58 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#59 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#60 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#61 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#62 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#63 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#64 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#65 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#66 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#67 D:\\Projects\\Websites\\vpos_laravel\\public\\index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#68 D:\\Projects\\Websites\\vpos_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php(16): require_once(\'D:\\\\Projects\\\\Web...\')\n#69 {main}', 0, '2024-05-23 16:00:57', '2024-05-23 16:00:57'),
(21, NULL, 'ficationfoxy@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `admins` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":19.53},{\"query\":\"select * from `marketings` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":2.48},{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":11.69}]', 1, '2024-05-23 18:34:00', '2024-05-23 18:34:00'),
(22, 2, 'ficationfoxy@gmail.com', 'Umi Request : Success', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.243.227', '[]', 1, '2024-05-23 18:34:18', '2024-05-23 18:34:18'),
(23, 2, 'ficationfoxy@gmail.com', 'Add Supplier : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":1},{\"query\":\"insert into `suppliers` (`store_identifier`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"One Laptop Surabaya\",\"onelaptopsurabaya@gmail.com\",\"0866766678788\",\"Jl. Kusuma Bangsa, Tambaksari, Kec. Tambaksari, Surabaya, Jawa Timur 60136\",\"Supplier Unit Laptop\",\"2024-05-24 02:01:03\",\"2024-05-24 02:01:03\"],\"time\":2.88}]', 1, '2024-05-23 19:01:03', '2024-05-23 19:01:03'),
(24, 2, 'ficationfoxy@gmail.com', 'Add Supplier : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.52},{\"query\":\"insert into `suppliers` (`store_identifier`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"T-Rakitan\",\"t-rakitanindosby@gmail.com\",\"087678798990\",\"Depan Pom Bensin, Ruko Klampis Jaya, Jl. Klampis Jaya Square A-8, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117\",\"Supplier Sparepart PC Desktop\",\"2024-05-24 02:02:03\",\"2024-05-24 02:02:03\"],\"time\":3.17}]', 1, '2024-05-23 19:02:03', '2024-05-23 19:02:03'),
(25, 2, 'ficationfoxy@gmail.com', 'Add Supplier : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.73},{\"query\":\"insert into `suppliers` (`store_identifier`, `nama_supplier`, `email_supplier`, `phone_supplier`, `alamat_supplier`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"Gold Ink Marina\",\"goldinkmarinasurabaya@gmail.com\",\"0876787875558\",\"Jl. Margorejo Indah Utara No.97-99, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60238\",\"Supplier Printer\",\"2024-05-24 02:03:05\",\"2024-05-24 02:03:05\"],\"time\":2.16}]', 1, '2024-05-23 19:03:05', '2024-05-23 19:03:05'),
(26, 2, 'ficationfoxy@gmail.com', 'Add Batch Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.83},{\"query\":\"insert into `batches` (`store_identifier`, `batch_code`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"LP\",\"Laptop\",\"2024-05-24 02:03:25\",\"2024-05-24 02:03:25\"],\"time\":2.41}]', 1, '2024-05-23 19:03:25', '2024-05-23 19:03:25'),
(27, 2, 'ficationfoxy@gmail.com', 'Add Batch Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.5},{\"query\":\"insert into `batches` (`store_identifier`, `batch_code`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"DP\",\"Desktop\",\"2024-05-24 02:03:36\",\"2024-05-24 02:03:36\"],\"time\":3.32}]', 1, '2024-05-23 19:03:36', '2024-05-23 19:03:36'),
(28, 2, 'ficationfoxy@gmail.com', 'Add Batch Code : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.82},{\"query\":\"insert into `batches` (`store_identifier`, `batch_code`, `keterangan`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"PTR\",\"Printer\",\"2024-05-24 02:03:46\",\"2024-05-24 02:03:46\"],\"time\":4.68}]', 1, '2024-05-23 19:03:46', '2024-05-23 19:03:46'),
(29, 2, 'ficationfoxy@gmail.com', 'Add Category : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.44},{\"query\":\"insert into `product_categories` (`store_identifier`, `name`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"Desktop\",\"2024-05-24 02:04:01\",\"2024-05-24 02:04:01\"],\"time\":2.94}]', 1, '2024-05-23 19:04:01', '2024-05-23 19:04:01'),
(30, 2, 'ficationfoxy@gmail.com', 'Add Category : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.53},{\"query\":\"insert into `product_categories` (`store_identifier`, `name`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"Laptop\",\"2024-05-24 02:04:09\",\"2024-05-24 02:04:09\"],\"time\":2.69}]', 1, '2024-05-23 19:04:09', '2024-05-23 19:04:09'),
(31, 2, 'ficationfoxy@gmail.com', 'Add Category : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select `store_identifier` from `store_details` where `id_tenant` = ? and `email` = ? limit 1\",\"bindings\":[2,\"ficationfoxy@gmail.com\"],\"time\":0.6},{\"query\":\"insert into `product_categories` (`store_identifier`, `name`, `updated_at`, `created_at`) values (?, ?, ?, ?)\",\"bindings\":[\"yfPnAm8RW4wnA031i0XM1jVrjmpJA6\",\"Printer\",\"2024-05-24 02:04:18\",\"2024-05-24 02:04:18\"],\"time\":3.73}]', 1, '2024-05-23 19:04:18', '2024-05-23 19:04:18'),
(32, NULL, 'ficationfoxy@gmail.com', 'Login : Success!', 'Lokasi : (Lat : -7.2484, Long : 112.7419)', '125.164.244.223', '[{\"query\":\"select * from `admins` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":5.97},{\"query\":\"select * from `marketings` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":3.1},{\"query\":\"select * from `tenants` where `email` = ? limit 1\",\"bindings\":[\"ficationfoxy@gmail.com\"],\"time\":1.2}]', 1, '2024-05-23 19:24:31', '2024-05-23 19:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `history_cashback_admins`
--

CREATE TABLE `history_cashback_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_invoice` bigint(20) DEFAULT NULL,
  `nominal_terima_mdr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, 1, 'PUTR1', 'Putri Nirmala', 0, 1, '2024-05-23 12:47:39', '2024-05-23 12:47:39'),
(2, 1, 'ZRTY1', 'Budi Santoso', 0, 1, '2024-05-23 12:47:57', '2024-05-23 12:47:57');

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
  `mdr` varchar(20) NOT NULL DEFAULT '0.7',
  `nominal_mdr` varchar(255) DEFAULT NULL,
  `nominal_terima_bersih` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `jenis_usahas`
--

CREATE TABLE `jenis_usahas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_usahas`
--

INSERT INTO `jenis_usahas` (`id`, `jenis_usaha`, `created_at`, `updated_at`) VALUES
(1, '6399 - Asuransi (Insurance)', NULL, NULL),
(2, '7538 - Bengkel (Service Otomotif)', NULL, NULL),
(3, '7542 - Cuci Mobil (Car Washes)', NULL, NULL),
(4, '5311 - Departement Stores', NULL, NULL),
(5, '5732 - Elektronik', NULL, NULL),
(6, '5814 - Fast Food Restaurants', NULL, NULL),
(7, '4225 - Gudang Penyimpanan (Storage)', NULL, NULL),
(8, '7011 - Hotel dan Penginapan', NULL, NULL),
(9, '7349 - Iuran Pengelolan Kebersihan dan Keamanan Lingkungan', NULL, NULL),
(10, '8111 - Jasa Hukum dan Pengacara', NULL, NULL),
(11, '4899 - Jasa Internet', NULL, NULL),
(12, '7379 - Jasa Komputer (Maintenance', NULL, NULL),
(13, '1520 - Jasa Kontraktor', NULL, NULL),
(14, '8011 - Jasa Medis dan Praktisi Kesehatan', NULL, NULL),
(15, '4215 - Jasa Pengiriman (Courier Services)', NULL, NULL),
(16, '8999 - Jasa Profesional', NULL, NULL),
(17, '7999 - Jasa Rekreasi/Taman Bermain', NULL, NULL),
(18, '4814 - Jasa Telekomunikasi', NULL, NULL),
(19, '4789 - Jasa Transportasi', NULL, NULL),
(20, '7210 - Laundry', NULL, NULL),
(21, '9399 - Layanan Pemerintah', NULL, NULL),
(22, '4900 - Listrik', NULL, NULL),
(23, '5537 - Mini Market (Convenience Stores)', NULL, NULL),
(24, '8661 - Organisasi Keagamaan', NULL, NULL),
(25, '8651 - Organisasi Politik', NULL, NULL),
(26, '8398 - Organisasi Sosial Nirlaba dan Sumbangan', NULL, NULL),
(27, '9311 - P2G Tax Payments', NULL, NULL),
(28, '5137 - Pakaian dan Aksesoris', NULL, NULL),
(29, '6531 - Payment Service Provider', NULL, NULL),
(30, '2741 - Penerbit Buku', NULL, NULL),
(31, '5970 - Peralatan Kesenian dan Kerajinan Tangan', NULL, NULL),
(32, '7332 - Percetakan dan Fotocopy', NULL, NULL),
(33, '763 - Pertanian', NULL, NULL),
(34, '742 - Peternakan', NULL, NULL),
(35, '5812 - Restoran dan Tempat Makan', NULL, NULL),
(36, '8062 - Rumah Sakit (Hospitals)', NULL, NULL),
(37, '8299 - Sekolah dan Jasa Edukasi', NULL, NULL),
(38, '7512 - Sewa Kendaraan', NULL, NULL),
(39, '7394 - Sewa Peralatan', NULL, NULL),
(40, '5734 - Software/Perangkat Lunak Komputer', NULL, NULL),
(41, '5983 - SPBU', NULL, NULL),
(42, '5411 - Supermarket dan Toko Kelontong / Sembako', NULL, NULL),
(43, '7523 - Tempar Parkir (Parking Lots & Garages)', NULL, NULL),
(44, '7230 - Tempat Cukur dan Salon Kecantikan', NULL, NULL),
(45, '5943 - Toko Alat Tulis (Stationery Stores)', NULL, NULL),
(46, '5942 - Toko Buku (Book Stores)', NULL, NULL),
(47, '5992 - Toko Bunga (Florists)', NULL, NULL),
(48, '5995 - Toko Hewan Peliharaan (Pet Shops', NULL, NULL),
(49, '4812 - Toko HP', NULL, NULL),
(50, '7298 - Toko Kesehatan dan Kecantikan (Health & Beauty Shop)', NULL, NULL),
(51, '5462 - Toko Kue/Roti (Bakery)', NULL, NULL),
(52, '5945 - Toko Mainan', NULL, NULL),
(53, '5039 - Toko Material Bangunan', NULL, NULL),
(54, '5912 - Toko Obat dan Farmasi (Drug Stores & Pharmacies)', NULL, NULL),
(55, '5944 - Toko Perhiasan dan Jam', NULL, NULL),
(56, '6513 - Agen Properti', NULL, NULL),
(57, '5712 - Barang - Barang Furniture', NULL, NULL),
(58, '7299 - Personal Service', NULL, NULL),
(59, '5999 - Specialis Retail', NULL, NULL),
(60, '4119 - Pelayanan Ambulan', NULL, NULL),
(61, '4457 - Sewa Kapal', NULL, NULL),
(62, '5065 - Sparepart barang-barang Elektronik', NULL, NULL),
(63, '5532 - Toko Ban/Velg Mobil & Motor', NULL, NULL),
(64, '5571 - Toko Dealer Motor', NULL, NULL),
(65, '5661 - Toko Sepatu', NULL, NULL),
(66, '5940 - Toko Jual Beli Sepeda', NULL, NULL),
(67, '5946 - Toko Kamera dan Accessories', NULL, NULL),
(68, '5948 - Toko Koper', NULL, NULL),
(69, '5996 - Sewa Kolam Renang', NULL, NULL),
(70, '7261 - Layanan Pemakaman dan kremasi', NULL, NULL),
(71, '7296 - Layanan Sewa Pakaian/ kostum', NULL, NULL),
(72, '7311 - Layanan Iklan', NULL, NULL),
(73, '7322 - Lembaga Debt Collector/Pemungutan Hutang', NULL, NULL),
(74, '8699 - MEMBERSHIP ORGANIZATIONS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(75, '9703 - Bank Perkreditan Rakyat / BPR', NULL, NULL),
(76, '8044 - TOKO KACAMATA', NULL, NULL),
(77, '8602 - JENIS USAHA LAINNYA ( BADAN USAHA)', NULL, NULL),
(78, '0742 - VETERINARY SERVICES', NULL, NULL),
(79, '0763 - AGRICULTURAL CO-OPERATIVE', NULL, NULL),
(80, '0780 - LANDSCAPING & HORTICULTURAL SERVICES', NULL, NULL),
(81, '1520 - GENERAL CONTRACTORS - RESIDENTIAL & COMMERCIAL', NULL, NULL),
(82, '1711 - HEATING', NULL, NULL),
(83, '1731 - ELECTRICAL CONTRACTORS', NULL, NULL),
(84, '1740 - MASONRY', NULL, NULL),
(85, '1750 - CARPENTRY CONTRACTORS', NULL, NULL),
(86, '1761 - ROOFING', NULL, NULL),
(87, '1771 - CONTRACTORS-CONCRETE WORK', NULL, NULL),
(88, '1799 - SPECIAL TRADE CONTRACTORS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(89, '2222 - OTHERS-NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(90, '2741 - MISCELLANEOUS PUBLISHING & PRINTING', NULL, NULL),
(91, '2791 - TYPESETTING', NULL, NULL),
(92, '2842 - SPECIALTY CLEANING', NULL, NULL),
(93, '3103 - Garuda (Indonesia)--GARUDA', NULL, NULL),
(94, '3333 - OTHERS-NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(95, '3351 - AFFILIATED AUTO RENTAL', NULL, NULL),
(96, '3352 - AMERICAN INTL RENT-A-CAR', NULL, NULL),
(97, '3353 - BROOKS RENT-A-CAR', NULL, NULL),
(98, '3354 - ACTION AUTO RENTAL', NULL, NULL),
(99, '3355 - SIXT CAR RENTAL', NULL, NULL),
(100, '3357 - HERTZ', NULL, NULL),
(101, '3359 - PAYLESS CAR RENTAL', NULL, NULL),
(102, '3361 - AIRWAYS RENT-A-CAR', NULL, NULL),
(103, '3362 - ALTRA AUTO RENTAL', NULL, NULL),
(104, '3364 - AGENCY RENT-A-CAR', NULL, NULL),
(105, '3366 - BUDGET RENT-A-CAR', NULL, NULL),
(106, '3368 - HOLIDAY RENT-A-CAR', NULL, NULL),
(107, '3370 - RENT A WRECK', NULL, NULL),
(108, '3374 - ACCENT RENT-A-CAR', NULL, NULL),
(109, '3376 - AJAX RENT-A-CAR', NULL, NULL),
(110, '3380 - TRIANGLE RENT-A-CAR', NULL, NULL),
(111, '3381 - EUROP CAR', NULL, NULL),
(112, '3385 - TROPICAL RENT-A-CAR', NULL, NULL),
(113, '3386 - SHOWCASE RENTAL CARS', NULL, NULL),
(114, '3387 - ALAMO RENT-A-CAR', NULL, NULL),
(115, '3388 - MERCHANTS RENT-A-CAR', NULL, NULL),
(116, '3389 - AVIS RENT-A-CAR', NULL, NULL),
(117, '3390 - DOLLAR RENT-A-CAR', NULL, NULL),
(118, '3391 - EUROPE BY CAR', NULL, NULL),
(119, '3393 - NATIONAL CAR RENTAL', NULL, NULL),
(120, '3394 - KEMWELL GROUP RENT-A-CAR', NULL, NULL),
(121, '3395 - THRIFTY CAR RENTAL', NULL, NULL),
(122, '3396 - TILDEN RENT-A-CAR', NULL, NULL),
(123, '3398 - ECONO-CAR RENT-A-CAR', NULL, NULL),
(124, '3399 - AMEREX RENT-A-CAR', NULL, NULL),
(125, '3400 - AUTO HOST CAR RENTALS', NULL, NULL),
(126, '3405 - ENTERPRISE RENT-A-CAR', NULL, NULL),
(127, '3409 - GENERAL RENT-A-CAR', NULL, NULL),
(128, '3411 - ATLANTA RENT-A-CAR', NULL, NULL),
(129, '3412 - A1 RENT-A-CAR', NULL, NULL),
(130, '3414 - GODFREY NATL RENT-A-CAR', NULL, NULL),
(131, '3419 - ALPHA RENT-A-CAR', NULL, NULL),
(132, '3420 - ANSA INTL RENT-A-CAR', NULL, NULL),
(133, '3421 - ALLSTATE RENT-A-CAR', NULL, NULL),
(134, '3423 - AVCAR RENT-A-CAR', NULL, NULL),
(135, '3425 - AUTOMATE RENT-A-CAR', NULL, NULL),
(136, '3427 - AVON RENT-A-CAR', NULL, NULL),
(137, '3428 - CAREY RENT-A-CAR', NULL, NULL),
(138, '3429 - INSURANCE RENT-A-CAR', NULL, NULL),
(139, '3430 - MAJOR RENT-A-CAR', NULL, NULL),
(140, '3431 - REPLACEMENT RENT-A-CAR', NULL, NULL),
(141, '3432 - RESERVE RENT-A-CAR', NULL, NULL),
(142, '3433 - UGLY DUCKLING RENT-A-CAR', NULL, NULL),
(143, '3434 - USA RENT-A-CAR', NULL, NULL),
(144, '3435 - VALUE RENT-A-CAR', NULL, NULL),
(145, '3436 - AUTOHANSA RENT-A-CAR', NULL, NULL),
(146, '3437 - CITE RENT-A-CAR', NULL, NULL),
(147, '3438 - INTERENT RENT-A-CAR', NULL, NULL),
(148, '3439 - MILLEVILLE RENT-A-CAR', NULL, NULL),
(149, '3440 - VIA ROUTE', NULL, NULL),
(150, '3441 - ADVANTAGE RENT-A-CAR', NULL, NULL),
(151, '3501 - HOLIDAY INN EXPRESS # HOLIDAY INNS', NULL, NULL),
(152, '3502 - BEST WESTERN HOTELS', NULL, NULL),
(153, '3503 - SHERATON HOTELS', NULL, NULL),
(154, '3504 - HILTON HOTELS', NULL, NULL),
(155, '3505 - FORTE HOTELS', NULL, NULL),
(156, '3506 - GOLDEN TULIP HOTELS', NULL, NULL),
(157, '3507 - FRIENDSHIP INNS', NULL, NULL),
(158, '3508 - QUALITY INNS', NULL, NULL),
(159, '3509 - MARRIOTT', NULL, NULL),
(160, '3510 - DAYS INNS', NULL, NULL),
(161, '3511 - ARABELLA HOTELS', NULL, NULL),
(162, '3512 - INTER-CONTINENTAL HOTELS', NULL, NULL),
(163, '3513 - WESTIN (WESTIN HOTELS)', NULL, NULL),
(164, '3514 - AMERISUITES', NULL, NULL),
(165, '3515 - RODEWAY INNS', NULL, NULL),
(166, '3516 - LA QUINTA MOTOR INNS', NULL, NULL),
(167, '3517 - AMERICANA HOTELS', NULL, NULL),
(168, '3518 - SOL HOTELS', NULL, NULL),
(169, '3519 - PULLMAN INTERNATIONAL HOTELS', NULL, NULL),
(170, '3520 - MERIDIEN HOTELS', NULL, NULL),
(171, '3521 - ROYAL LAHAINA RESORTS', NULL, NULL),
(172, '3522 - TOKYO HOTEL', NULL, NULL),
(173, '3523 - PENINSULA HOTEL', NULL, NULL),
(174, '3524 - WELCOMGROUP HOTELS', NULL, NULL),
(175, '3525 - DUNFEY HOTELS', NULL, NULL),
(176, '3526 - PRINCE HOTELS', NULL, NULL),
(177, '3527 - DOWNTOWNER-PASSPORT HOTEL', NULL, NULL),
(178, '3529 - CP (CANADIAN PACIFIC) HOTELS', NULL, NULL),
(179, '3530 - RENAISSANCE HOTELS', NULL, NULL),
(180, '3531 - KAUAI COCONUT BEACH RESORT', NULL, NULL),
(181, '3532 - ROYAL KONA RESORT', NULL, NULL),
(182, '3533 - HOTEL IBIS', NULL, NULL),
(183, '3534 - SOUTHERN PACIFIC HOTELS', NULL, NULL),
(184, '3535 - HILTON INTERNATIONALS', NULL, NULL),
(185, '3536 - AMFAC HOTELS', NULL, NULL),
(186, '3537 - ANA HOTELS', NULL, NULL),
(187, '3538 - CONCORDE HOTELS', NULL, NULL),
(188, '3539 - SUMMERFIELD SUITES HOTELS', NULL, NULL),
(189, '3540 - IBEROTEL HOTELS', NULL, NULL),
(190, '3541 - HOTEL OKURA', NULL, NULL),
(191, '3542 - ROYAL HOTELS', NULL, NULL),
(192, '3543 - FOUR SEASONS HOTELS', NULL, NULL),
(193, '3544 - CIGA HOTELS', NULL, NULL),
(194, '3545 - SHANGRI-LA INTERNATIONAL', NULL, NULL),
(195, '3546 - SIERRA SUITES HOTELS', NULL, NULL),
(196, '3547 - BREAKERS RESORT', NULL, NULL),
(197, '3548 - HOTELS MELIA', NULL, NULL),
(198, '3549 - AUBERGE DES GOVERNEURS', NULL, NULL),
(199, '3550 - REGAL 8 INNS', NULL, NULL),
(200, '3551 - MIRAGE HOTEL AND CASINO', NULL, NULL),
(201, '3552 - COAST HOTELS', NULL, NULL),
(202, '3553 - PARK INNS INTERNATIONAL', NULL, NULL),
(203, '3554 - PINEHURST RESORT', NULL, NULL),
(204, '3555 - TREASURE ISLAND HOTEL AND CASINO', NULL, NULL),
(205, '3556 - BARTON CREEK RESORT', NULL, NULL),
(206, '3557 - MANHATTAN EAST SUITE HOTELS', NULL, NULL),
(207, '3558 - JOLLY HOTELS', NULL, NULL),
(208, '3559 - CANDLEWOOD SUITES', NULL, NULL),
(209, '3560 - ALADDIN RESORT AND CASINO', NULL, NULL),
(210, '3561 - GOLDEN NUGGET', NULL, NULL),
(211, '3562 - COMFORT INNS', NULL, NULL),
(212, '3563 - JOURNEY’S END MOTELS', NULL, NULL),
(213, '3564 - SAM’S TOWN HOTEL AND CASINO', NULL, NULL),
(214, '3565 - RELAX INNS', NULL, NULL),
(215, '3565 - RELAX INNS', NULL, NULL),
(216, '3566 - GARDEN PLACE HOTEL', NULL, NULL),
(217, '3567 - SOHO GRAND HOTEL', NULL, NULL),
(218, '3568 - LADBROKE HOTELS', NULL, NULL),
(219, '3569 - TRIBECA GRAND HOTEL', NULL, NULL),
(220, '3570 - FORUM HOTELS', NULL, NULL),
(221, '3571 - GRAND WAILEA RESORT', NULL, NULL),
(222, '3572 - MIYAKO HOTELS', NULL, NULL),
(223, '3573 - SANDMAN HOTELS', NULL, NULL),
(224, '3574 - VENTURE INNS', NULL, NULL),
(225, '3575 - VAGABOND HOTELS', NULL, NULL),
(226, '3576 - LA QUINTA RESORT', NULL, NULL),
(227, '3577 - MANDARIN ORIENTAL HOTEL', NULL, NULL),
(228, '3578 - FRANKENMUTH BAVARIAN', NULL, NULL),
(229, '3579 - HOTEL MERCURE', NULL, NULL),
(230, '3580 - HOTEL DEL CORONADO', NULL, NULL),
(231, '3581 - DELTA HOTEL', NULL, NULL),
(232, '3582 - CALIFORNIA HOTEL AND CASINO', NULL, NULL),
(233, '3583 - RADISSON BLU', NULL, NULL),
(234, '3583 - SAS HOTELS', NULL, NULL),
(235, '3584 - PRINCESS HOTELS INTERNATIONAL', NULL, NULL),
(236, '3585 - HUNGAR HOTELS', NULL, NULL),
(237, '3586 - SOKOS HOTELS', NULL, NULL),
(238, '3587 - DORAL HOTELS', NULL, NULL),
(239, '3588 - HELMSLEY HOTELS', NULL, NULL),
(240, '3589 - DORAL GOLF RESORT', NULL, NULL),
(241, '3590 - FAIRMONT HOTELS', NULL, NULL),
(242, '3591 - SONESTA HOTELS', NULL, NULL),
(243, '3592 - OMNI HOTELS', NULL, NULL),
(244, '3593 - CUNARD HOTELS', NULL, NULL),
(245, '3594 - ARIZONA BILTMORE', NULL, NULL),
(246, '3595 - HOSPITALITY INNS', NULL, NULL),
(247, '3596 - WYNN LAS VEGAS', NULL, NULL),
(248, '3597 - RIVERSIDE RESORT HOTEL AND CASINO', NULL, NULL),
(249, '3598 - REGENT INTERNATIONAL HOTELS', NULL, NULL),
(250, '3599 - PANNONIA HOTELS', NULL, NULL),
(251, '3600 - SADDLEBROOK RESORT TAMPA', NULL, NULL),
(252, '3601 - TRADEWINDS RESORTS', NULL, NULL),
(253, '3602 - HUDSON HOTEL', NULL, NULL),
(254, '3603 - NOAH’S HOTELS', NULL, NULL),
(255, '3604 - HILTON GARDEN INN', NULL, NULL),
(256, '3605 - JURYS DOYLE HOTEL GROUP', NULL, NULL),
(257, '3606 - JEFFERSON HOTEL', NULL, NULL),
(258, '3607 - FONTAINEBLEAU RESORTS', NULL, NULL),
(259, '3608 - GAYLORD OPRYLAND', NULL, NULL),
(260, '3609 - GAYLORD PALMS', NULL, NULL),
(261, '3610 - GAYLORD TEXAN', NULL, NULL),
(262, '3611 - C MON INN', NULL, NULL),
(263, '3612 - MOEVENPICK HOTELS', NULL, NULL),
(264, '3613 - MICROTEL INNS & SUITES', NULL, NULL),
(265, '3614 - AMERICINN', NULL, NULL),
(266, '3615 - TRAVELODGE', NULL, NULL),
(267, '3616 - HERMITAGE HOTELS', NULL, NULL),
(268, '3617 - AMERICA’S BEST VALUE INN', NULL, NULL),
(269, '3618 - GREAT WOLF', NULL, NULL),
(270, '3619 - ALOFT', NULL, NULL),
(271, '3620 - BINION’S HORSESHOE CLUB', NULL, NULL),
(272, '3621 - EXTENDED STAY', NULL, NULL),
(273, '3622 - MERLIN HOTELS', NULL, NULL),
(274, '3623 - DORINT HOTELS', NULL, NULL),
(275, '3624 - LADY LUCK HOTEL AND CASINO', NULL, NULL),
(276, '3625 - HOTEL UNIVERSALE', NULL, NULL),
(277, '3626 - STUDIO PLUS', NULL, NULL),
(278, '3627 - EXTENDED STAY AMERICA', NULL, NULL),
(279, '3628 - EXCALIBUR HOTEL AND CASINO', NULL, NULL),
(280, '3629 - DAN HOTELS', NULL, NULL),
(281, '3630 - EXTENDED STAY DELUXE', NULL, NULL),
(282, '3631 - SLEEP INN', NULL, NULL),
(283, '3632 - THE PHOENICIAN', NULL, NULL),
(284, '3633 - RANK HOTELS', NULL, NULL),
(285, '3634 - SWISSOTEL', NULL, NULL),
(286, '3635 - RESO HOTELS', NULL, NULL),
(287, '3636 - SAROVA HOTELS', NULL, NULL),
(288, '3637 - RAMADA INNS', NULL, NULL),
(289, '3638 - HOWARD JOHNSON', NULL, NULL),
(290, '3639 - MOUNT CHARLOTTE THISTLE', NULL, NULL),
(291, '3640 - Hyatt Hotels', NULL, NULL),
(292, '3641 - SOFITEL HOTELS', NULL, NULL),
(293, '3642 - NOVOTEL HOTELS', NULL, NULL),
(294, '3643 - STEIGENBERGER HOTELS', NULL, NULL),
(295, '3644 - ECONO LODGES', NULL, NULL),
(296, '3645 - QUEENS MOAT HOUSES', NULL, NULL),
(297, '3646 - SWALLOW HOTELS', NULL, NULL),
(298, '3647 - HUSA HOTELS', NULL, NULL),
(299, '3648 - DE VERE HOTELS', NULL, NULL),
(300, '3649 - RADISSON HOTELS', NULL, NULL),
(301, '3650 - RED ROOF INNS', NULL, NULL),
(302, '3651 - IMPERIAL LONDON HOTEL', NULL, NULL),
(303, '3652 - EMBASSY HOTELS', NULL, NULL),
(304, '3653 - PENTA HOTELS', NULL, NULL),
(305, '3654 - LOEWS HOTELS', NULL, NULL),
(306, '3655 - SCANDIC HOTELS', NULL, NULL),
(307, '3656 - SARA HOTELS', NULL, NULL),
(308, '3657 - OBEROI HOTELS', NULL, NULL),
(309, '3658 - NEW OTANI HOTELS', NULL, NULL),
(310, '3659 - TAJ HOTELS INTERNATIONAL', NULL, NULL),
(311, '3660 - KNIGHTS INNS', NULL, NULL),
(312, '3661 - METROPOLE HOTELS', NULL, NULL),
(313, '3662 - CIRCUS CIRCUS HOTEL AND CASINO', NULL, NULL),
(314, '3663 - HOTELES EL PRESIDENTE', NULL, NULL),
(315, '3664 - FLAG INN', NULL, NULL),
(316, '3665 - HAMPTON INNS', NULL, NULL),
(317, '3666 - STAKIS HOTELS', NULL, NULL),
(318, '3667 - LUXOR HOTEL AND CASINO', NULL, NULL),
(319, '3668 - MARITIM HOTELS', NULL, NULL),
(320, '3669 - ELDORADO HOTEL AND CASINO', NULL, NULL),
(321, '3670 - ARCADE HOTELS', NULL, NULL),
(322, '3671 - ARCTIA HOTELS', NULL, NULL),
(323, '3672 - CAMPANILE HOTELS', NULL, NULL),
(324, '3673 - IBUSZ HOTELS', NULL, NULL),
(325, '3674 - RANTASIPI HOTELS', NULL, NULL),
(326, '3675 - INTERHOTEL CEDOK', NULL, NULL),
(327, '3676 - MONTE CARLO HOTEL AND CASINO', NULL, NULL),
(328, '3677 - CLIMAT DE FRANCE HOTELS', NULL, NULL),
(329, '3678 - CUMULUS HOTELS', NULL, NULL),
(330, '3679 - SILVER LEGACY HOTEL AND CASINO', NULL, NULL),
(331, '3680 - HOTEIS OTHAN', NULL, NULL),
(332, '3681 - ADAMS MARK HOTELS', NULL, NULL),
(333, '3682 - SAHARA HOTEL AND CASINO', NULL, NULL),
(334, '3683 - BRADBURY SUITES', NULL, NULL),
(335, '3684 - BUDGET HOST INN', NULL, NULL),
(336, '3685 - BUDGETEL HOTELS', NULL, NULL),
(337, '3686 - SUSSE CHALET', NULL, NULL),
(338, '3687 - CLARION HOTELS', NULL, NULL),
(339, '3688 - COMPRI HOTELS', NULL, NULL),
(340, '3690 - COURTYARD BY MARRIOTT', NULL, NULL),
(341, '3691 - DILLON INNS', NULL, NULL),
(342, '3692 - DOUBLETREE HOTELS', NULL, NULL),
(343, '3693 - DRURY INNS', NULL, NULL),
(344, '3694 - ECONOMY INNS OF AMERICA', NULL, NULL),
(345, '3695 - EMBASSY SUITES', NULL, NULL),
(346, '3696 - EXEL INNS', NULL, NULL),
(347, '3697 - FAIRFIELD HOTELS', NULL, NULL),
(348, '3698 - HARLEY HOTELS', NULL, NULL),
(349, '3699 - MIDWAY MOTOR LODGE', NULL, NULL),
(350, '3700 - MOTEL 6', NULL, NULL),
(351, '3701 - LA MANSION DEL RIO', NULL, NULL),
(352, '3702 - THE REGISTRY HOTELS', NULL, NULL),
(353, '3703 - RESIDENCE INNS', NULL, NULL),
(354, '3704 - ROYCE HOTELS', NULL, NULL),
(355, '3705 - SANDMAN INNS', NULL, NULL),
(356, '3706 - SHILO INNS', NULL, NULL),
(357, '3707 - SHONEY\'S INNS', NULL, NULL),
(358, '3708 - VIRGIN RIVER HOTEL AND CASINO', NULL, NULL),
(359, '3709 - SUPER 8 MOTELS', NULL, NULL),
(360, '3710 - THE RITZ-CARLTON', NULL, NULL),
(361, '3711 - FLAG INNS (AUSTRALIA)', NULL, NULL),
(362, '3712 - BUFFALO BILL’S HOTEL AND CASINO', NULL, NULL),
(363, '3713 - QUALITY PACIFIC HOTEL', NULL, NULL),
(364, '3714 - FOUR SEASONS HOTEL (AUSTRALIA)', NULL, NULL),
(365, '3715 - FAIRFIELD INN', NULL, NULL),
(366, '3716 - CARLTON HOTELS', NULL, NULL),
(367, '3717 - CITY LODGE HOTELS', NULL, NULL),
(368, '3718 - KAROS HOTELS', NULL, NULL),
(369, '3719 - PROTEA HOTELS', NULL, NULL),
(370, '3720 - SOUTHERN SUN HOTELS', NULL, NULL),
(371, '3721 - HILTON CONRAD', NULL, NULL),
(372, '3722 - WYNDHAM', NULL, NULL),
(373, '3723 - RICA HOTELS', NULL, NULL),
(374, '3724 - INTER NOR HOTELS', NULL, NULL),
(375, '3725 - SEA PINES RESORT', NULL, NULL),
(376, '3726 - RIO SUITES', NULL, NULL),
(377, '3727 - BROADMOOR HOTEL', NULL, NULL),
(378, '3728 - BALLY’S HOTEL AND CASINO', NULL, NULL),
(379, '3729 - JOHN ASCUAGA’S NUGGET', NULL, NULL),
(380, '3730 - MGM GRAND HOTEL', NULL, NULL),
(381, '3731 - HARRAHS HOTELS / CASINOS', NULL, NULL),
(382, '3732 - OPRYLAND HOTEL', NULL, NULL),
(383, '3733 - BOCA RATON RESORT', NULL, NULL),
(384, '3734 - HARVEY/BRISTOL HOTELS', NULL, NULL),
(385, '3735 - MASTERS ECONOMY INNS', NULL, NULL),
(386, '3736 - COLORADO BELLE/EDGEWATER RESORT', NULL, NULL),
(387, '3737 - RIVIERA HOTEL AND CASINO', NULL, NULL),
(388, '3738 - TROPICANA RESORT & CASINO', NULL, NULL),
(389, '3739 - WOODSIDE HOTELS & RESORTS', NULL, NULL),
(390, '3740 - TOWNEPLACE SUITES', NULL, NULL),
(391, '3741 - MILLENNIUM HOTELS', NULL, NULL),
(392, '3742 - CLUB MED', NULL, NULL),
(393, '3743 - BILTMORE HOTEL & SUITES', NULL, NULL),
(394, '3744 - CAREFREE RESORTS', NULL, NULL),
(395, '3745 - ST. REGIS HOTEL', NULL, NULL),
(396, '3746 - THE ELIOT HOTEL', NULL, NULL),
(397, '3747 - CLUB CORP / CLUB RESORTS', NULL, NULL),
(398, '3748 - WELLESLEY INNS', NULL, NULL),
(399, '3749 - THE BEVERLY HILLS HOTEL', NULL, NULL),
(400, '3750 - CROWNE PLAZA HOTELS', NULL, NULL),
(401, '3751 - HOMEWOOD SUITES', NULL, NULL),
(402, '3752 - PEABODY HOTELS', NULL, NULL),
(403, '3753 - GREENBRIAR RESORTS', NULL, NULL),
(404, '3754 - AMELIA ISLAND PLANTATION', NULL, NULL),
(405, '3755 - THE HOMESTEAD', NULL, NULL),
(406, '3756 - SOUTH SEAS RESORTS', NULL, NULL),
(407, '3757 - CANYON RANCH', NULL, NULL),
(408, '3758 - KAHALA MANDARIN ORIENTAL HOTEL', NULL, NULL),
(409, '3759 - THE ORCHID AT MAUNA LANI', NULL, NULL),
(410, '3760 - HALEKULANI HOTEL/WAIKIKI PARC', NULL, NULL),
(411, '3761 - PRIMADONNA HOTEL AND CASINO', NULL, NULL),
(412, '3762 - WHISKEY PETE’S HOTEL AND CASINO', NULL, NULL),
(413, '3763 - CHATEAU ELAN WINERY AND RESORT', NULL, NULL),
(414, '3764 - BEAU RIVAGE HOTEL AND CASINO', NULL, NULL),
(415, '3765 - BELLAGIO', NULL, NULL),
(416, '3766 - FREMONT HOTEL AND CASINO', NULL, NULL),
(417, '3767 - MAIN STREET STATION HOTEL AND CASINO', NULL, NULL),
(418, '3768 - SILVER STAR HOTEL AND CASINO', NULL, NULL),
(419, '3769 - STRATOSPHERE HOTEL AND CASINO', NULL, NULL),
(420, '3770 - SPRINGHILL SUITES', NULL, NULL),
(421, '3771 - CAESAR’S HOTEL AND CASINO', NULL, NULL),
(422, '3772 - NEMACOLIN WOODLANDS', NULL, NULL),
(423, '3773 - THE VENETIAN RESORT HOTEL CASINO', NULL, NULL),
(424, '3774 - NEW YORK-NEW YORK HOTEL AND CASINO', NULL, NULL),
(425, '3775 - SANDS RESORT', NULL, NULL),
(426, '3776 - NEVELE GRAND RESORT AND COUNTRY CLUB', NULL, NULL),
(427, '3777 - MANDALAY BAY RESORT', NULL, NULL),
(428, '3778 - FOUR POINTS HOTELS', NULL, NULL),
(429, '3779 - W HOTELS', NULL, NULL),
(430, '3780 - DISNEY RESORTS', NULL, NULL),
(431, '3781 - PATRICIA GRAND RESORT HOTELS', NULL, NULL),
(432, '3782 - ROSEN HOTELS AND RESORTS', NULL, NULL),
(433, '3783 - TOWN AND COUNTRY RESORT', NULL, NULL),
(434, '3784 - FIRST HOSPITALITY HOTELS', NULL, NULL),
(435, '3785 - OUTRIGGER HOTELS AND RESORTS', NULL, NULL),
(436, '3786 - OHANA HOTELS OF HAWAII', NULL, NULL),
(437, '3787 - CARIBE ROYALE RESORTS', NULL, NULL),
(438, '3788 - ALA MOANA HOTEL', NULL, NULL),
(439, '3789 - SMUGGLER’S NOTCH RESORT', NULL, NULL),
(440, '3790 - RAFFLES HOTELS', NULL, NULL),
(441, '3791 - STAYBRIDGE SUITES', NULL, NULL),
(442, '3792 - CLARIDGE CASINO HOTEL', NULL, NULL),
(443, '3793 - FLAMINGO HOTELS', NULL, NULL),
(444, '3794 - GRAND CASINO HOTELS', NULL, NULL),
(445, '3795 - PARIS LAS VEGAS HOTEL', NULL, NULL),
(446, '3796 - PEPPERMILL HOTEL CASINO', NULL, NULL),
(447, '3797 - ATLANTIC CITY HILTON RESORTS', NULL, NULL),
(448, '3798 - EMBASSY VACATION RESORT', NULL, NULL),
(449, '3799 - HALE KOA HOTEL', NULL, NULL),
(450, '3800 - HOMESTEAD SUITES', NULL, NULL),
(451, '3801 - WILDERNESS HOTEL AND RESORT', NULL, NULL),
(452, '3802 - THE PALACE HOTEL', NULL, NULL),
(453, '3803 - THE WIGMAM GOLF RESORT AND SPA', NULL, NULL),
(454, '3804 - THE DIPLOMAT COUNTRY CLUB SPA', NULL, NULL),
(455, '3805 - THE ATLANTIC', NULL, NULL),
(456, '3806 - PRINCEVILLE RESORT', NULL, NULL),
(457, '3807 - ELEMENT', NULL, NULL),
(458, '3808 - LXR (Luxury Resorts)', NULL, NULL),
(459, '3809 - SETTLE INN', NULL, NULL),
(460, '3810 - LA COSTA RESORT', NULL, NULL),
(461, '3811 - PREMIER INN', NULL, NULL),
(462, '3812 - HYATT PLACE', NULL, NULL),
(463, '3813 - HOTEL INDIGO', NULL, NULL),
(464, '3814 - THE ROOSEVELT HOTEL NY', NULL, NULL),
(465, '3815 - NICKELODEON FAMILY SUITES BY HOLIDAY INN', NULL, NULL),
(466, '3817 - AFFINIA', NULL, NULL),
(467, '3818 - MAINSTAY SUITES', NULL, NULL),
(468, '3819 - OXFORD SUITES', NULL, NULL),
(469, '3820 - JUMEIRAH ESSEX HOUSE', NULL, NULL),
(470, '3821 - CARIBE ROYALE', NULL, NULL),
(471, '3822 - CROSSLAND', NULL, NULL),
(472, '3823 - GRAND SIERRA RESORT', NULL, NULL),
(473, '3824 - ARIA', NULL, NULL),
(474, '3825 - VDARA', NULL, NULL),
(475, '3826 - AUTOGRAPH', NULL, NULL),
(476, '3827 - GALT HOUSE', NULL, NULL),
(477, '3828 - COSMOPOLITAN OF LAS VEGAS', NULL, NULL),
(478, '4011 - RAILROADS – FREIGHT', NULL, NULL),
(479, '4111 - LOCAL AND SUBURBAN COMMUTER PASSENGER TRANSPORTATION', NULL, NULL),
(480, '4112 - PASSENGER RAILWAYS', NULL, NULL),
(481, '4119 - AMBULANCE SERVICES', NULL, NULL),
(482, '4121 - TAXICABS & LIMOUSINES', NULL, NULL),
(483, '4131 - BUS LINES', NULL, NULL),
(484, '4214 - MOTOR FREIGHT CARRIERS & TRUCKING', NULL, NULL),
(485, '4215 - COURIER SERVICES', NULL, NULL),
(486, '4225 - PUBLIC WAREHOUSING', NULL, NULL),
(487, '4225 - PUBLIC WAREHOUSING & STORAGE', NULL, NULL),
(488, '4411 - STEAMSHIP & CRUISE LINES', NULL, NULL),
(489, '4457 - BOAT RENTALS & LEASES', NULL, NULL),
(490, '4468 - MARINAS MARINE SERVICE & SUPPLIES', NULL, NULL),
(491, '4511 - AIRLINES & AIR CARRIERS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(492, '4582 - AIRPORTS', NULL, NULL),
(493, '4722 - TRAVEL AGENCIES & TOUR OPERATORS', NULL, NULL),
(494, '4723 - PACKAGE TOUR OPERATORS - GERMANY ONLY', NULL, NULL),
(495, '4761 - TELEMARKETING OF TRAVEL RELATED SERVICES AND V', NULL, NULL),
(496, '4784 - TOLL AND BRIDGE FEES', NULL, NULL),
(497, '4789 - TRANSPORTATION SERVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(498, '4812 - TELECOMMUNICATION EQUIPMENT & TELEPHONE SALES', NULL, NULL),
(499, '4813 - SPECIAL TELECOM MERCHANT', NULL, NULL),
(500, '4814 - TELECOMMUNICATION SERVICES', NULL, NULL),
(501, '4815 - VISAPHONE', NULL, NULL),
(502, '4816 - COMPUTER NETWORK / INFORMATION SERVICES', NULL, NULL),
(503, '4821 - TELEGRAPH SERVICES', NULL, NULL),
(504, '4829 - WIRE TRANSFER MONEY ORDERS (WTMOs)', NULL, NULL),
(505, '4899 - CABLE SATELLITE & OTHER PAY TELEVISION & RADIO SERVICES', NULL, NULL),
(506, '4900 - UTILITIES-ELECTRIC', NULL, NULL),
(507, '5013 - MOTOR VEHICLE SUPPPLIES & NEW PARTS', NULL, NULL),
(508, '5021 - OFFICE & COMMERCIAL FURNITURE', NULL, NULL),
(509, '5039 - CONSTRUCTION MATERIALS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(510, '5044 - PHOTOGRAPHIC PHOTOCOPY MICROFILM EQUIPMENT & SUPPLIES', NULL, NULL),
(511, '5045 - COMPUTERS & COMPUTER PERIPHERAL EQUIPMENT & SERVICES', NULL, NULL),
(512, '5046 - COMMERCIAL EQUIPMENT (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(513, '5047 - MEDICAL DENTAL OPHTHALMIC & HOSPITAL EQUIPMENT & SUPPLIES', NULL, NULL),
(514, '5051 - METAL SERVICE CENTERS & OFFICES', NULL, NULL),
(515, '5065 - ELECTRICAL PARTS AND EQUIPMENT', NULL, NULL),
(516, '5072 - HARDWARE', NULL, NULL),
(517, '5074 - PLUMBING AND HEATING EQUIPMENT & SUPPLIES', NULL, NULL),
(518, '5085 - INDUSTRIAL SUPPLIES (NOT ELSEWHERE CLSSIFIED)', NULL, NULL),
(519, '5094 - PRECIOUS STONES', NULL, NULL),
(520, '5099 - DURABLE GOODS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(521, '5111 - STATIONERY STORES OFFICE & SCHOOL SUPPLY STORES', NULL, NULL),
(522, '5122 - DRUGS DRUG PROPRIETARIES & DRUGGIST SUNDRIES', NULL, NULL),
(523, '5131 - PIECE GOODS', NULL, NULL),
(524, '5137 - MEN\'S', NULL, NULL),
(525, '5139 - COMMERCIAL FOOTWEAR', NULL, NULL),
(526, '5169 - CHEMICALS & ALLIED PRODUCTS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(527, '5172 - PETROLEUM & PETROLEUM PRODUCTS', NULL, NULL),
(528, '5192 - BOOKS', NULL, NULL),
(529, '5193 - FLORIST SUPPLIES', NULL, NULL),
(530, '5198 - PAINT', NULL, NULL),
(531, '5199 - NONDURABLE GOODS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(532, '5200 - HOME SUPPLY WAREHOUSE STORES', NULL, NULL),
(533, '5211 - LUMBER & BUILDING MATERIALS STORES', NULL, NULL),
(534, '5231 - GLASS', NULL, NULL),
(535, '5251 - HARDWARE STORES', NULL, NULL),
(536, '5261 - NURSERIES & LAWN & GARDEN SUPPLY STORES', NULL, NULL),
(537, '5271 - MOBILE HOME DEALERS', NULL, NULL),
(538, '5300 - WHOLESALE CLUB', NULL, NULL),
(539, '5309 - DUTY FREE STORES', NULL, NULL),
(540, '5310 - DISCOUNT STORES', NULL, NULL),
(541, '5311 - DEPARTMENT STORES', NULL, NULL),
(542, '5331 - VARIETY STORES', NULL, NULL),
(543, '5399 - MISCELLANEOUS GENERAL MERCHANDISE', NULL, NULL),
(544, '5407 - SECURITY CREDIT', NULL, NULL),
(545, '5411 - GROCERY STORES & SUPERMARKETS', NULL, NULL),
(546, '5422 - FREEZER & LOCKER MEAT PROVISIONERS', NULL, NULL),
(547, '5441 - CANDY', NULL, NULL),
(548, '5451 - DAIRY PRODUCTS STORES', NULL, NULL),
(549, '5462 - BAKERIES', NULL, NULL),
(550, '5499 - MISCELLANEOUS FOOD STORES-CONVENIENCE STORES & SPECIALTY MARKETS', NULL, NULL),
(551, '5511 - CAR & TRUCK DEALERS (NEW & USED) SALES SERVICE REPAIRS PARTS & LEASING', NULL, NULL),
(552, '5521 - CAR & TRUCK DEALERS (USED ONLY) SALES SERVICE REPAIRS PARTS & LEASING', NULL, NULL),
(553, '5531 - AUTO & HOME SUPPLY STORES (NO LONGER VALID MCC)', NULL, NULL),
(554, '5532 - AUTOMOTIVE TIRE STORES', NULL, NULL),
(555, '5533 - AUTOMOTIVE PARTS & ACCESSORIES STORES', NULL, NULL),
(556, '5537 - OTHERS-NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(557, '5541 - SERVICE STATIONS', NULL, NULL),
(558, '5542 - AUTOMATED FUEL DISPENSERS', NULL, NULL),
(559, '5555 - OTHERS-NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(560, '5561 - CAMPER', NULL, NULL),
(561, '5571 - MOTORCYCLE DEALERS', NULL, NULL),
(562, '5592 - MOTOR HOMES DEALERS', NULL, NULL),
(563, '5598 - SNOWMOBILE DEALERS', NULL, NULL),
(564, '5599 - MISCELLANEOUS AUTOMOTIVE', NULL, NULL),
(565, '5611 - MEN\'S & BOY\'S CLOTHING & ACCESSORIES STORES', NULL, NULL),
(566, '5612 - WOMENS READY-TO-WEAR STORES', NULL, NULL),
(567, '5621 - WOMENS READY-TO-WEAR STORES', NULL, NULL),
(568, '5631 - WOMEN\'S ACCESSORY & SPECIALTY SHOPS', NULL, NULL),
(569, '5641 - CHILDREN\'S AND INFANTS\' WEAR', NULL, NULL),
(570, '5651 - FAMILY CLOTHING STORES', NULL, NULL),
(571, '5655 - SPORTS & RIDING APPAREL STORES', NULL, NULL),
(572, '5661 - SHOE STORES', NULL, NULL),
(573, '5681 - FURRIERS & FUR SHOPS', NULL, NULL),
(574, '5691 - MENS & BOYS CLOTHING & ACCESSORIES STORES', NULL, NULL),
(575, '5697 - TAILORS SEAMSTRESSES MENDING & ALTERATIONS', NULL, NULL),
(576, '5698 - WIG AND TOUPEE STORES', NULL, NULL),
(577, '5699 - MISCELLANEOUS APPAREL & ACCESSORY', NULL, NULL),
(578, '5712 - FURNITURE HOME FURNISHINGS & EQUIPMENT STORES EXCEPTING APPLIANCES', NULL, NULL),
(579, '5713 - FLOOR COVERING STORES', NULL, NULL),
(580, '5714 - DRAPERY', NULL, NULL),
(581, '5718 - FIREPLACE', NULL, NULL),
(582, '5719 - MISCELLANEOUS HOME FURNISHING SPECIALTY STORES', NULL, NULL),
(583, '5722 - HOUSEHOLD APPLIANCE STORES', NULL, NULL),
(584, '5732 - ELECTRONICS STORES', NULL, NULL),
(585, '5733 - MUSIC STORES - MUSICAL INSTRUMENTS PIANOS & SHEET MUSIC', NULL, NULL),
(586, '5734 - COMPUTER SOFTWARE STORES', NULL, NULL),
(587, '5735 - RECORD STORES', NULL, NULL),
(588, '5811 - CATERERS', NULL, NULL),
(589, '5812 - EATING PLACES & RESTAURANTS', NULL, NULL),
(590, '5813 - DRINKING PLACES - BARS TAVERNS NIGHTCLUBS COCKTAIL LOUNGES & DISCOTHEQUES', NULL, NULL),
(591, '5814 - FAST FOOD RESTAURANTS', NULL, NULL),
(592, '5815 - Digital Goods Media - Books', NULL, NULL),
(593, '5816 - Digital Goods - Games *', NULL, NULL),
(594, '5817 - Digital Goods - Applications (Excludes Games) *', NULL, NULL),
(595, '5818 - Digital Goods - Large Digital Goods Merchant *', NULL, NULL),
(596, '5912 - DRUG STORES & PHARMACIES', NULL, NULL),
(597, '5921 - PACKAGE STORES - BEER', NULL, NULL),
(598, '5931 - USED MERCHANDISE & SECONDHAND STORES', NULL, NULL),
(599, '5932 - ANTIQUE SHOPS - SALES REPAIRS & RESTORATION SERVICES', NULL, NULL),
(600, '5932 - ANTIQUE SHOPS', NULL, NULL),
(601, '5933 - PAWN SHOPS', NULL, NULL),
(602, '5935 - WRECKING AND SALVAGE YARDS', NULL, NULL),
(603, '5937 - ANTIQUE REPRODUCTIONS', NULL, NULL),
(604, '5940 - BICYCLE SHOPS-SALES & SERVICE', NULL, NULL),
(605, '5941 - SPORTING GOODS STORES', NULL, NULL),
(606, '5942 - BOOK STORES', NULL, NULL),
(607, '5943 - STATIONERY STORES', NULL, NULL),
(608, '5944 - JEWELRY STORES WATCHES CLOCKS & SILVERWARE STORES', NULL, NULL),
(609, '5945 - HOBBY TOY & GAME SHOPS', NULL, NULL),
(610, '5946 - CAMERA & PHOTOGRAPHIC SUPPLY STORES', NULL, NULL),
(611, '5947 - GIFT CARD NOVELTY & SOUVENIR SHOPS', NULL, NULL),
(612, '5948 - LUGGAGE & LEATHER GOODS STORES', NULL, NULL),
(613, '5949 - SEWING NEEDLEWORK', NULL, NULL),
(614, '5950 - GLASSWARE / CRYSTAL STORES', NULL, NULL),
(615, '5960 - DIRECT MARKETING - INSURANCE SERVICES', NULL, NULL),
(616, '5961 - MAIL ORDER', NULL, NULL),
(617, '5962 - DIRECT MARKETING - TRAVEL-RELATED ARRANGEMENT SERVICES (HIGH RISK MCC)', NULL, NULL),
(618, '5963 - DOOR-TO-DOOR SALES', NULL, NULL),
(619, '5964 - DIRECT MARKETING - CATALOG MERCHANT', NULL, NULL),
(620, '5965 - DIRECT MARKETING - COMBINATION CATALOG AND RETAIL MERCHANT', NULL, NULL),
(621, '5966 - DIRECT MARKETING - OUTBOUND TELEMARKETING MERCHANT (HIGH RISK MCC)', NULL, NULL),
(622, '5967 - DIRECT MARKETING - INBOUND TELESERVICES MERCHANT (HIGH RISK MCC)', NULL, NULL),
(623, '5968 - DIRECT MARKETING - CONTINUITY/SUBSCRIPTION MERCH', NULL, NULL),
(624, '5969 - DIRECT MARKETING - OTHER DIRECT MARKETERS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(625, '5970 - ARTISTS SUPPLY & CRAFT SHOPS', NULL, NULL),
(626, '5971 - ART DEALERS & GALLERIES', NULL, NULL),
(627, '5972 - STAMP AND COIN STORES - PHILATELIC AND NUMISMATIC SUPPLIES', NULL, NULL),
(628, '5973 - RELIGIOUS GOODS STORES', NULL, NULL),
(629, '5975 - HEARING AIDS - SALES SERVICE & SUPPLY', NULL, NULL),
(630, '5976 - ORTHOPEDIC GOODS - PROSTHETIC DEVICES', NULL, NULL),
(631, '5977 - COSMETIC STORES', NULL, NULL),
(632, '5978 - TYPEWRITER STORE-SALES', NULL, NULL),
(633, '5983 - FUEL DEALERS - FUEL OIL', NULL, NULL),
(634, '5992 - FLORISTS', NULL, NULL),
(635, '5993 - CIGAR STORES AND STANDS', NULL, NULL),
(636, '5994 - NEWS DEALERS & NEWS STANDS', NULL, NULL),
(637, '5995 - PET SHOPS', NULL, NULL),
(638, '5996 - SWIMMING POOLS - SALES & SERVICE', NULL, NULL),
(639, '5997 - ELECTRIC RAZOR STORES', NULL, NULL),
(640, '5998 - TENT AND AWNING SHOPS', NULL, NULL),
(641, '5999 - MISCELLANEOUS AND SPECIALTY RETAIL', NULL, NULL),
(642, '6010 - FINANCIAL INSTITUTIONS - MANUAL CASH DISBURSEMENTS', NULL, NULL),
(643, '6011 - FINANCIAL INSTITUTIONS AUTOMATED CASH DISBURSEMENTS', NULL, NULL),
(644, '6012 - FINANCIAL INSTITUTIONS MERCHANDISE & SERVICES', NULL, NULL),
(645, '6050 - QUASI CASH - MEMBER FINANCIAL INSTITUTION', NULL, NULL),
(646, '6051 - NON-FINANCIAL INSTITUTIONS-FOREIGN CURRENCY', NULL, NULL),
(647, '6211 - SECURITY BROKERS / DEALERS', NULL, NULL),
(648, '6300 - INSURANCE SALES UNDERWRITING & PREMIUMS', NULL, NULL),
(649, '6381 - INSURANCE PREMIUMS', NULL, NULL),
(650, '6399 - INSURANCE NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(651, '6513 - REAL ESTATE AGENTS', NULL, NULL),
(652, '6529 - QUASI CASH - REMOTE STORED VALUE LOAD - FINANCIAL INSTITUTE', NULL, NULL),
(653, '6530 - QUASI CASH - REMOTE STORED VALUE LOAD - MERCHANT', NULL, NULL),
(654, '6531 - PAYMENT SERVICE PROVIDER', NULL, NULL),
(655, '6532 - MEMBER FINANCIAL INSTITUTION--PAYMENT SERVICE PROVIDER--PAYMENT TRANSACTION', NULL, NULL),
(656, '6533 - MERCHANT--PAYMENT SERVICE PROVIDER--PAYMENT TRANSACTION', NULL, NULL),
(657, '6534 - QUASI CASH - MONEY TRANSFER - MEMBER FINANCIAL INSTITUTION', NULL, NULL),
(658, '6535 - VALUE PURCHASE--MEMBER FINANCIAL INSTITUTION', NULL, NULL),
(659, '6611 - OVERPAYMENTS', NULL, NULL),
(660, '6760 - SAVINGS BONDS', NULL, NULL),
(661, '7011 - LODGING - HOTELS MOTELS RESORTS & CENTRAL RESERVATION SERVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(662, '7012 - TIMESHARES', NULL, NULL),
(663, '7032 - SPORTING & RECREATIONAL CAMPS', NULL, NULL),
(664, '7033 - TRAILER PARKS & CAMP SITES', NULL, NULL),
(665, '7210 - LAUNDRY', NULL, NULL),
(666, '7211 - LAUNDRIES - FAMILY & COMMERCIAL', NULL, NULL),
(667, '7216 - DRY CLEANERS', NULL, NULL),
(668, '7217 - CARPET AND UPHOLSTERY CLEANING', NULL, NULL),
(669, '7221 - PHOTOGRAPHIC STUDIOS-PORTRAITS', NULL, NULL),
(670, '7230 - BEAUTY & BARBER SHOPS', NULL, NULL),
(671, '7251 - SHOE REPAIR SHOPS SHOE SHINE PARLORS & HAT CLEANING SHOPS', NULL, NULL),
(672, '7261 - FUNERAL SERVICE & CREMATORIES', NULL, NULL),
(673, '7273 - DATING AND ESCORT SERVICES', NULL, NULL),
(674, '7276 - TAX PREPARATION SERVICE', NULL, NULL),
(675, '7277 - COUNSELING SERVICE', NULL, NULL),
(676, '7278 - BUYING & SHOPPING SERVICES AND CLUBS', NULL, NULL),
(677, '7295 - NO LONGER USED - VISA', NULL, NULL),
(678, '7296 - COSTUME RENTAL', NULL, NULL),
(679, '7296 - CLOTHING RENTAL - COSTUMES UNIFORMS & FORMAL WEAR', NULL, NULL),
(680, '7297 - MASSAGE PARLORS', NULL, NULL),
(681, '7298 - HEALTH & BEAUTY SPA', NULL, NULL),
(682, '7299 - MISCELLANEOUS PERSONAL SERVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(683, '7311 - ADVERTISING SERVICES', NULL, NULL),
(684, '7321 - CONSUMER CREDIT REPORTING AGENCIES', NULL, NULL),
(685, '7322 - DEBT COLLECTION AGENCIES', NULL, NULL),
(686, '7332 - BLUEPRINTING AND PHOTOCOPYING SERVICES', NULL, NULL),
(687, '7333 - COMMERCIAL PHOTOGRAPHY ART & GRAPHICS', NULL, NULL),
(688, '7338 - QUICK COPY REPRODUCTION & BLUEPRINTING SERVICES', NULL, NULL),
(689, '7339 - STENOGRAPHIC & SECRETARIAL SUPPORT', NULL, NULL),
(690, '7341 - WINDOW CLEANING SERVICES', NULL, NULL),
(691, '7342 - EXTERMINATING & DISINFECTING SERVICES', NULL, NULL),
(692, '7349 - CLEANING MAINTENANCE & JANITORIAL SERVICES', NULL, NULL),
(693, '7361 - EMPLOYMENT AGENCIES & TEMPORARY HELP SERVICES', NULL, NULL),
(694, '7372 - COMPUTER PROGRAMMING DATA PROCESSING & INTEGRATED SYSTEMS DESIGN SERVICES', NULL, NULL),
(695, '7375 - INFORMATION RETRIEVAL SERVICES', NULL, NULL),
(696, '7379 - COMPUTER MAINTENANCE', NULL, NULL),
(697, '7392 - MANAGEMENT', NULL, NULL),
(698, '7393 - PROTECTIVE AND SECURITY SERVICES - INCLUDING ARMORED CARS AND GUARD DOGS', NULL, NULL),
(699, '7394 - EQUIPMENT', NULL, NULL),
(700, '7395 - PHOTOFINISHING LABORATORIES & PHOTO DEVELOPING', NULL, NULL),
(701, '7399 - BUSINESS SERVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(702, '7511 - QUASI CASH - TRUCK STOP TRANSACTIONS', NULL, NULL),
(703, '7512 - AUTOMOBILE RENTAL AGENCY', NULL, NULL),
(704, '7513 - TRUCK AND UTILITY TRAILER RENTALS', NULL, NULL),
(705, '7519 - MOTOR HOME & RECREATIONAL VEHICLE RENTALS', NULL, NULL),
(706, '7523 - PARKING LOTS & GARAGES', NULL, NULL),
(707, '7524 - EXPRESS PAYMENT SERVICE MERCHANTS - PARKING LOTS AND GARAGES', NULL, NULL),
(708, '7531 - AUTOMOTIVE TOP AND BODY REPAIR', NULL, NULL),
(709, '7534 - TIRE RETREADING & REPAIR SHOPS', NULL, NULL),
(710, '7535 - PAINT SHOPS-AUTOMOTIVE', NULL, NULL),
(711, '7538 - AUTOMOTIVE SERVICE SHOPS (NON-DEALER)', NULL, NULL),
(712, '7542 - CAR WASHES', NULL, NULL),
(713, '7549 - TOWING SERVICES', NULL, NULL),
(714, '7622 - ELECTRONICS REPAIR SHOPS', NULL, NULL),
(715, '7623 - AIR CONDITIONING & REFRIGERATION REPAIR SHOPS', NULL, NULL),
(716, '7629 - ELECTRICAL & SMALL APPLIANCE REPAIR SHOPS', NULL, NULL),
(717, '7631 - WATCH', NULL, NULL),
(718, '7641 - FURNITURE - REUPHOLSTERY', NULL, NULL),
(719, '7692 - WELDING SERVICES', NULL, NULL),
(720, '7699 - MISCELLANEOUS REPAIR SHOPS & RELATED SERVICES', NULL, NULL),
(721, '7778 - CITISHARE CASH ADVANCE', NULL, NULL),
(722, '7829 - MOTION PICTURE & VIDEO TAPE PRODUCTION & DISTRIBUTION', NULL, NULL),
(723, '7832 - MOTION PICTURE THEATERS', NULL, NULL),
(724, '7833 - EXPRESS PAYMENT SERVICE MERCHANTS--MOTION PICT', NULL, NULL),
(725, '7841 - MOTION PICTURE & VIDEO TAPE PRODUCTION', NULL, NULL),
(726, '7911 - DANCE HALLS', NULL, NULL),
(727, '7922 - THEATRICAL PRODUCERS (EXCEPT MOTION PICTURES) AND TICKET AGENCIES', NULL, NULL),
(728, '7929 - BANDS', NULL, NULL),
(729, '7932 - BILLARD AND POOL ESTABLISHMENTS', NULL, NULL),
(730, '7933 - BOWLING ALLEYS', NULL, NULL),
(731, '7941 - COMMERCIAL SPORTS PROFESSIONAL SPORTS CLUBS ATHLETIC FIELDS & SPORTS PROMOTERS', NULL, NULL),
(732, '7991 - TOURIST ATTRACTIONS & EXHIBITS', NULL, NULL),
(733, '7992 - GOLF COURSES - PUBLIC', NULL, NULL),
(734, '7993 - VIDEO AMUSEMENT GAME SUPPLIES', NULL, NULL),
(735, '7994 - VIDEO GAME ARCADES / ESTABLISHMENTS', NULL, NULL),
(736, '7995 - BETTING', NULL, NULL),
(737, '7996 - AMUSEMENT PARKS', NULL, NULL),
(738, '7997 - MEMBERSHIP CLUBS COUNTRY CLUBS & PRIVATE GOLF COURSES', NULL, NULL),
(739, '7998 - AQUARIUMS', NULL, NULL),
(740, '7999 - AMUSEMENT & RECREATION SERVICES', NULL, NULL),
(741, '8011 - DOCTORS & PHYSICIANS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(742, '8021 - DENTISTS & ORTHODONTISTS', NULL, NULL),
(743, '8031 - OSTEOPATHS', NULL, NULL),
(744, '8041 - CHIROPRACTORS', NULL, NULL),
(745, '8042 - OPTOMETRISTS & OPHTHALMOLOGISTS', NULL, NULL),
(746, '8043 - OPTICIANS OPTICAL GOODS & EYEGLASSES', NULL, NULL),
(747, '8044 - OPTICAL GOODS AND EYEGLASSES', NULL, NULL),
(748, '8049 - CHIROPODISTS', NULL, NULL),
(749, '8050 - NURSING & PERSONAL CARE FACILITIES', NULL, NULL),
(750, '8062 - HOSPITALS', NULL, NULL),
(751, '8071 - MEDICAL & DENTAL LABORATORIES', NULL, NULL),
(752, '8099 - MEDICAL SERVICES AND HEALTH PRACTITIONERS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(753, '8111 - LEGAL SERVICES & ATTORNEYS', NULL, NULL),
(754, '8211 - ELEMENTARY & SECONDARY SCHOOLS', NULL, NULL),
(755, '8220 - COLLEGES', NULL, NULL),
(756, '8241 - CORRESPONDENCE SCHOOLS', NULL, NULL),
(757, '8244 - BUSINESS & SECRETARIAL SCHOOLS', NULL, NULL),
(758, '8249 - VOCATIONAL & TRADE SCHOOLS', NULL, NULL),
(759, '8299 - SCHOOLS & EDUCATIONAL SERVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(760, '8351 - CHILD CARE SERVICES', NULL, NULL),
(761, '8398 - CHARITABLE & SOCIAL SERVICE ORGANIZATIONS', NULL, NULL),
(762, '8602 - OTHERS-NOT ELSEWHERE CLASSIFIED', NULL, NULL),
(763, '8641 - CIVIC', NULL, NULL),
(764, '8651 - POLITICAL ORGANIZATIONS', NULL, NULL),
(765, '8661 - RELIGIOUS ORGANIZATIONS', NULL, NULL),
(766, '8675 - AUTOMOBILE ASSOCIATIONS', NULL, NULL),
(767, '8699 - MEMBERSHIP ORGANIZATIONS (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(768, '8734 - TESTING LABORATORIES (NON-MEDICAL TESTING)', NULL, NULL),
(769, '8911 - ARCHITECTURAL', NULL, NULL),
(770, '8931 - ACCOUNTING', NULL, NULL),
(771, '8999 - PROFESSIONAL SEVICES (NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(772, '9211 - COURT COSTS', NULL, NULL),
(773, '9222 - FINES', NULL, NULL),
(774, '9223 - BAIL AND BOND PAYMENTS', NULL, NULL),
(775, '9311 - TAX PAYMENTS', NULL, NULL),
(776, '9399 - GOVERNMENT SERVICES ( NOT ELSEWHERE CLASSIFIED)', NULL, NULL),
(777, '9401 - I-PURCHASING', NULL, NULL),
(778, '9402 - POSTAL SERVICES - GOVERNMENT ONLY', NULL, NULL),
(779, '9405 - U.S. FEDERAL GOVERNMENT AGENCIES OR DEPARTMENTS', NULL, NULL),
(780, '9411 - GOVERNMENT LOAN PAYMENTS', NULL, NULL),
(781, '9700 - AUTOMATED REFERRAL SERVICE', NULL, NULL),
(782, '9701 - VISA CREDENTIAL SERVER', NULL, NULL),
(783, '9701 - COOPERATION', NULL, NULL),
(784, '9702 - EMERGENCY SERVICES (GCAS)', NULL, NULL),
(785, '9703 - BPR/RURAL BANK', NULL, NULL),
(786, '9704 - PYRAMID OR MULTI LEVEL MARKETING DISTRIBUTION COMPANIES', NULL, NULL),
(787, '9705 - THIRD PARTY PROCESSORS (AGGREGATORS)', NULL, NULL),
(788, '9751 - U.K. SUPERMARKETS ELECTRONIC HOT FILE', NULL, NULL),
(789, '9752 - U.K. PETROL STATIONS', NULL, NULL),
(790, '9753 - INTRA-COMPANY PURCHASES', NULL, NULL),
(791, '9754 - QUASI CASH - GAMBLING - HORSE RACING', NULL, NULL),
(792, '9950 - INTRA-COMPANY PURCHASES', NULL, NULL),
(793, '5262 - Marketplaces', NULL, NULL),
(794, '5551 - Boat dealers', NULL, NULL);

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
(1, 'Andin Indrianti', 'abdellarentia@gmail.com', '2024-05-23 03:08:30', '085156719832', '2024-05-23 03:29:59', '$2y$12$m7Ux2O3nWLtLbBH5tIJjSOU6Qp5IKwPKcLE.pv87p0Olfp9Vg337G', 1, NULL, '2024-05-23 03:07:39', '2024-05-23 03:57:33');

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
(150, '2024_05_16_111738_add_admin_to_table_withdrawals', 92),
(153, '2024_05_17_021931_create_qris_wallet_pendings_table', 93),
(154, '2024_05_17_095014_add__access_level_to_table_admin', 93),
(155, '2024_05_17_150813_create_qris_a_p_i_settings_table', 94),
(156, '2024_05_17_150820_create_store_lists_table', 94),
(157, '2024_05_18_083423_create_history_cashback_admins_table', 95),
(162, '2024_05_23_205242_create_jenis_usahas_table', 96);

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
(1, 'jackronald118899@gmail.com', '011097', 30, 0, '2024-05-22 23:18:04', '2024-05-22 23:19:15'),
(2, '087739882723', '505033', 5, 0, '2024-05-22 23:19:44', '2024-05-22 23:20:18'),
(3, 'jackronald118899@gmail.com', '199312', 30, 0, '2024-05-23 01:59:31', '2024-05-23 02:00:03'),
(4, 'abdellarentia@gmail.com', '485608', 30, 0, '2024-05-23 03:07:39', '2024-05-23 03:08:30'),
(5, '085156719832', '181764', 5, 0, '2024-05-23 09:27:58', '2024-05-23 09:28:56'),
(7, 'ficationfoxy@gmail.com', '759348', 30, 1, '2024-05-23 13:37:22', '2024-05-23 13:37:22'),
(12, '085156719832', '431338', 5, 1, '2024-05-23 16:00:43', '2024-05-23 16:00:43'),
(13, '0876555445223', '771937', 5, 1, '2024-05-23 16:00:55', '2024-05-23 16:00:55');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'Desktop', '2024-05-23 19:04:01', '2024-05-23 19:04:01'),
(2, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'Laptop', '2024-05-23 19:04:09', '2024-05-23 19:04:09'),
(3, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'Printer', '2024-05-23 19:04:18', '2024-05-23 19:04:18');

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

-- --------------------------------------------------------

--
-- Table structure for table `qris_a_p_i_settings`
--

CREATE TABLE `qris_a_p_i_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 'adminsu@vipos.id', '0', NULL, NULL),
(2, 1, 'jackronald118899@gmail.com', '0', '2024-05-23 01:59:31', '2024-05-23 01:59:31'),
(3, 1, 'abdellarentia@gmail.com', '0', '2024-05-23 03:07:39', '2024-05-23 03:07:39'),
(4, 2, 'ficationfoxy@gmail.com', '0', '2024-05-23 13:37:21', '2024-05-23 13:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `qris_wallet_pendings`
--

CREATE TABLE `qris_wallet_pendings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `saldo` varchar(255) DEFAULT NULL,
  `periode_transaksi` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qris_wallet_pendings`
--

INSERT INTO `qris_wallet_pendings` (`id`, `id_user`, `email`, `saldo`, `periode_transaksi`, `created_at`, `updated_at`) VALUES
(1, 1, 'jackronald118899@gmail.com', '0', NULL, '2024-05-23 01:59:31', '2024-05-23 01:59:31'),
(2, 2, 'ficationfoxy@gmail.com', '0', NULL, '2024-05-23 13:37:21', '2024-05-23 13:37:21');

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
(1, 1, 'adminsu@vipos.id', 'PT. BANK DIGITAL BCA', 'CENAIDJA', '5065205758', NULL, NULL),
(2, 1, 'jackronald118899@gmail.com', 'PT. BANK DIGITAL BCA', 'CENAIDJA', '5065205758', '2024-05-23 01:59:31', '2024-05-23 01:59:31'),
(3, 1, 'abdellarentia@gmail.com', 'PT. BANK DIGITAL BCA', 'CENAIDJA', '5065205758', '2024-05-23 03:07:39', '2024-05-23 09:28:57'),
(4, 2, 'ficationfoxy@gmail.com', 'PT. BANK DIGITAL BCA', 'CENAIDJA', '5065205758', '2024-05-23 13:37:21', '2024-05-23 13:37:21');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', '2', 'ficationfoxy@gmail.com', 'Indotech Comp', 'Jl. Pemuda Nusantara No. 56', 'Surabaya', '61256', '087655654332', '5045 - COMPUTERS & COMPUTER PERIPHERAL EQUIPMENT & SERVICES', 1, 'Terima Kasih sudah berkunjung ke toko kami.', '-1716475579.avif', '2024-05-23 13:37:21', '2024-05-23 14:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `store_lists`
--

CREATE TABLE `store_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `no_telp_toko` varchar(255) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `status_umi` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'One Laptop Surabaya', 'onelaptopsurabaya@gmail.com', '0866766678788', 'Jl. Kusuma Bangsa, Tambaksari, Kec. Tambaksari, Surabaya, Jawa Timur 60136', 'Supplier Unit Laptop', '2024-05-23 19:01:03', '2024-05-23 19:01:03'),
(2, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'T-Rakitan', 't-rakitanindosby@gmail.com', '087678798990', 'Depan Pom Bensin, Ruko Klampis Jaya, Jl. Klampis Jaya Square A-8, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117', 'Supplier Sparepart PC Desktop', '2024-05-23 19:02:03', '2024-05-23 19:02:03'),
(3, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'Gold Ink Marina', 'goldinkmarinasurabaya@gmail.com', '0876787875558', 'Jl. Margorejo Indah Utara No.97-99, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60238', 'Supplier Printer', '2024-05-23 19:03:05', '2024-05-23 19:03:05');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 0, 0, '2024-05-23 13:37:21', '2024-05-23 13:37:21');

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
(1, 'Rico Robert', 'jackronald118899@gmail.com', '2024-05-23 02:00:03', '087739882723', '2024-05-01 03:04:57', '$2y$12$bUThobihB.WZjt5tJYnueOkxCgSAKv7war2XaJslKmW5Wp6TxXnTe', 1, 0, NULL, '2024-05-23 01:59:31', '2024-05-23 02:00:03'),
(2, 'Rico Hermawan Indra', 'ficationfoxy@gmail.com', '2024-05-23 13:38:51', '0876555445223', '2024-05-23 13:38:56', '$2y$12$RPWIf4qCtarQQIeQsjl/ier/cA428HutHMAai2iNWDzgSsV.f0TsO', 1, 2, NULL, '2024-05-23 13:37:21', '2024-05-23 13:37:21');

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
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 'Nama Pelanggan', 'Kota Asal', 'Alamat Pelanggan', 'Email Pelanggan', 'No. Telp./WA', 1, 1, 1, 1, 1, '2024-05-23 13:37:21', '2024-05-23 13:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_qris_accounts`
--

CREATE TABLE `tenant_qris_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
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

--
-- Dumping data for table `tenant_qris_accounts`
--

INSERT INTO `tenant_qris_accounts` (`id`, `store_identifier`, `id_tenant`, `email`, `qris_login_user`, `qris_password`, `qris_merchant_id`, `qris_store_id`, `mdr`, `created_at`, `updated_at`) VALUES
(1, 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', 2, 'ficationfoxy@gmail.com', 'indotech', 'indotech123', '12345678', '213231222', '0', NULL, NULL);

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
(1, 1, 'jackronald118899@gmail.com', '0', '2024-05-23 01:59:31', '2024-05-23 01:59:31'),
(2, 2, 'ficationfoxy@gmail.com', '0', '2024-05-23 13:37:21', '2024-05-23 13:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `umi_requests`
--

CREATE TABLE `umi_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tenant` bigint(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `store_identifier` varchar(255) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_approval` date DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `umi_requests`
--

INSERT INTO `umi_requests` (`id`, `id_tenant`, `email`, `store_identifier`, `tanggal_pengajuan`, `tanggal_approval`, `is_active`, `file_path`, `note`, `created_at`, `updated_at`) VALUES
(1, 2, 'ficationfoxy@gmail.com', 'yfPnAm8RW4wnA031i0XM1jVrjmpJA6', '2024-05-24', '2024-05-31', 1, 'Formulir Pendaftaran NOBU QRIS (NMID) PT BRAHMA ESATAMA_Indotech Comp_24052024013409.xlsx', 'Umi telah disetujui', '2024-05-23 18:34:13', '2024-05-23 18:34:13');

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
-- Indexes for table `history_cashback_admins`
--
ALTER TABLE `history_cashback_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `history_cashback_admins_id_invoice_unique` (`id_invoice`);

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
-- Indexes for table `jenis_usahas`
--
ALTER TABLE `jenis_usahas`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `qris_a_p_i_settings`
--
ALTER TABLE `qris_a_p_i_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qris_a_p_i_settings_id_user_unique` (`id_user`),
  ADD UNIQUE KEY `qris_a_p_i_settings_password_unique` (`password`);

--
-- Indexes for table `qris_wallets`
--
ALTER TABLE `qris_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qris_wallets_email_unique` (`email`);

--
-- Indexes for table `qris_wallet_pendings`
--
ALTER TABLE `qris_wallet_pendings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qris_wallet_pendings_email_unique` (`email`);

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
-- Indexes for table `store_lists`
--
ALTER TABLE `store_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_lists_store_identifier_unique` (`store_identifier`);

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
  ADD UNIQUE KEY `store_identifier` (`store_identifier`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agregate_wallets`
--
ALTER TABLE `agregate_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_identifiers`
--
ALTER TABLE `customer_identifiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_admins`
--
ALTER TABLE `detail_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_kasirs`
--
ALTER TABLE `detail_kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_marketings`
--
ALTER TABLE `detail_marketings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_penarikans`
--
ALTER TABLE `detail_penarikans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_tenants`
--
ALTER TABLE `detail_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `history_cashback_admins`
--
ALTER TABLE `history_cashback_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitation_codes`
--
ALTER TABLE `invitation_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_fields`
--
ALTER TABLE `invoice_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_usahas`
--
ALTER TABLE `jenis_usahas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=795;

--
-- AUTO_INCREMENT for table `kasirs`
--
ALTER TABLE `kasirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `nobu_withdraw_fee_histories`
--
ALTER TABLE `nobu_withdraw_fee_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qris_a_p_i_settings`
--
ALTER TABLE `qris_a_p_i_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qris_wallets`
--
ALTER TABLE `qris_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qris_wallet_pendings`
--
ALTER TABLE `qris_wallet_pendings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rekenings`
--
ALTER TABLE `rekenings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_details`
--
ALTER TABLE `store_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_lists`
--
ALTER TABLE `store_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenant_fields`
--
ALTER TABLE `tenant_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenant_qris_accounts`
--
ALTER TABLE `tenant_qris_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tunai_wallets`
--
ALTER TABLE `tunai_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `umi_requests`
--
ALTER TABLE `umi_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
