-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 23, 2022 at 05:33 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitampan`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi_berita` text NOT NULL,
  `status` enum('1','2','','') NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `desa`
--

CREATE TABLE `desa` (
  `id` int(11) NOT NULL,
  `nama_desa` varchar(255) NOT NULL,
  `long_desa` varchar(100) NOT NULL,
  `lat_desa` varchar(100) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `desa`
--

INSERT INTO `desa` (`id`, `nama_desa`, `long_desa`, `lat_desa`, `id_kecamatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Bojong', '-6.9029888', '07.6120355,17', 3, '2022-08-22 15:04:55', '2022-08-22 15:04:55', NULL),
(8, 'Mulyajaya', '-6.9029888', '07.6120355,17', 3, '2022-08-22 15:05:17', '2022-08-22 15:05:17', NULL),
(9, 'Sukajaya', '-6.9029888', '07.6120355,17', 1, '2022-08-22 15:06:11', '2022-08-22 15:06:11', NULL),
(10, 'Girimukti', '-6.9029888', '07.6120355,17', 1, '2022-08-22 15:07:03', '2022-08-22 15:07:03', NULL),
(12, 'Karangsewu', '-6.9029888', '07.6120355,17', 1, '2022-08-22 15:08:17', '2022-08-22 15:08:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `harga_kelompok_tani`
--

CREATE TABLE `harga_kelompok_tani` (
  `id` int(11) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `periode_bulan` date NOT NULL,
  `harga_tani` float NOT NULL,
  `id_petani` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `harga_kelompok_tani`
--

INSERT INTO `harga_kelompok_tani` (`id`, `id_komoditas`, `periode_bulan`, `harga_tani`, `id_petani`, `created_at`, `updated_at`) VALUES
(3, 13, '2022-08-22', 7600, 16, '2022-08-22 15:46:58', '2022-08-22 15:47:16'),
(4, 13, '2022-08-22', 7900, 17, '2022-08-22 15:47:51', '2022-08-22 15:47:51'),
(5, 15, '2022-08-22', 2300, 16, '2022-08-22 15:48:03', '2022-08-22 15:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `harga_pasar`
--

CREATE TABLE `harga_pasar` (
  `id` int(11) NOT NULL,
  `id_penyuluh` int(11) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `periode_bulan` date NOT NULL,
  `harga_pasar_lokal` float NOT NULL,
  `harga_pasar_induk` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `harga_pasar`
--

INSERT INTO `harga_pasar` (`id`, `id_penyuluh`, `id_komoditas`, `periode_bulan`, `harga_pasar_lokal`, `harga_pasar_induk`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 3, 13, '2022-08-22', 9000, 12000, '2022-08-22 15:45:28', '2022-08-22 15:45:28', NULL),
(9, 4, 13, '2022-08-22', 9500, 13000, '2022-08-22 15:45:47', '2022-08-22 15:45:47', NULL),
(10, 3, 14, '2022-08-22', 3900, 4200, '2022-08-22 15:46:07', '2022-08-22 15:46:07', NULL),
(11, 4, 15, '2022-07-07', 8000, 9500, '2022-08-22 15:46:30', '2022-08-22 15:46:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_komoditas`
--

CREATE TABLE `jenis_komoditas` (
  `id` int(11) NOT NULL,
  `nama_jenis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_komoditas`
--

INSERT INTO `jenis_komoditas` (`id`, `nama_jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Sayuran', '2022-08-22 15:29:53', '2022-08-22 15:29:53', NULL),
(8, 'Buah', '2022-08-22 15:30:26', '2022-08-22 15:30:26', NULL),
(9, 'Biji-bijian', '2022-08-22 15:30:35', '2022-08-22 15:30:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama_kecamatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cisewu', '2022-07-25 13:58:34', '2022-07-25 13:58:34', NULL),
(3, 'Banjarwangi', '2022-08-18 03:08:35', '2022-08-18 03:08:35', NULL),
(4, 'Cisompet', '2022-08-22 15:02:44', '2022-08-22 15:02:44', NULL),
(5, 'Leles', '2022-08-22 15:02:59', '2022-08-22 15:02:59', NULL),
(6, 'Cilawu', '2022-08-22 15:03:15', '2022-08-22 15:03:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_tani`
--

CREATE TABLE `kelompok_tani` (
  `id` int(11) NOT NULL,
  `nama_kelompok` varchar(255) NOT NULL,
  `id_desa` int(11) NOT NULL,
  `id_penyuluh` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelompok_tani`
--

INSERT INTO `kelompok_tani` (`id`, `nama_kelompok`, `id_desa`, `id_penyuluh`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'Kelompok A', 7, 3, '2022-08-22 15:34:14', '2022-08-22 15:34:14', NULL),
(7, 'Kelompok B', 8, 3, '2022-08-22 15:34:25', '2022-08-22 15:34:25', NULL),
(9, 'Kelompok Jaya', 7, 4, '2022-08-22 15:35:46', '2022-08-22 15:36:09', NULL),
(10, 'Kelompok Tani Jaya', 9, 5, '2022-08-22 15:36:27', '2022-08-22 15:36:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `komoditas`
--

CREATE TABLE `komoditas` (
  `id` int(11) NOT NULL,
  `nama_komoditas` varchar(255) NOT NULL,
  `icon` text NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komoditas`
--

INSERT INTO `komoditas` (`id`, `nama_komoditas`, `icon`, `id_jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 'Apple', 'iconkomoditas/eEbx4IBOl96nJ1JhF2uo8VclpuIaHsFuzwlEMG4g.jpg', 8, '2022-08-22 15:33:19', '2022-08-22 15:33:19', NULL),
(14, 'Kol', 'iconkomoditas/LKJIgjewTGVV4YwuHqag3a5FMcKWHXRTaEz1CBqj.png', 7, '2022-08-22 15:33:34', '2022-08-22 15:33:34', NULL),
(15, 'Jagung', 'iconkomoditas/ePcPIZGoE6BGRwD3DLS1t9FMsLJbqt5RnH4cC904.avif', 9, '2022-08-22 15:33:56', '2022-08-22 15:33:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `komoditas_pengepul`
--

CREATE TABLE `komoditas_pengepul` (
  `id` int(11) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_pengepul` int(11) NOT NULL,
  `id_penyuluh` int(11) NOT NULL,
  `harga` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komoditas_pengepul`
--

INSERT INTO `komoditas_pengepul` (`id`, `id_komoditas`, `created_at`, `updated_at`, `deleted_at`, `id_pengepul`, `id_penyuluh`, `harga`) VALUES
(2, 13, '2022-08-22 15:36:48', '2022-08-22 15:37:33', NULL, 6, 3, 12000.00),
(3, 15, '2022-08-22 15:37:02', '2022-08-22 15:37:02', NULL, 6, 4, 9000.00),
(4, 14, '2022-08-22 15:37:14', '2022-08-22 15:37:14', NULL, 6, 3, 3000.00);

-- --------------------------------------------------------

--
-- Table structure for table `komoditas_petani`
--

CREATE TABLE `komoditas_petani` (
  `id` varchar(15) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_old` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_new` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_activity`
--

INSERT INTO `log_activity` (`id`, `user_id`, `subject`, `url`, `method`, `ip`, `data_old`, `data_new`, `created_at`, `updated_at`) VALUES
(170, 41, 'Ditambah Instructor Id 3', '/pendaftaran-penyuluh/store', 'POST', '127.0.0.1', '{\"nama_penyuluh\":\"Asep\",\"id_user\":44,\"updated_at\":\"2022-08-22T14:47:42.000000Z\",\"created_at\":\"2022-08-22T14:47:42.000000Z\",\"id\":3}', '-', '2022-08-22 14:47:42', '2022-08-22 14:47:42'),
(171, 41, 'Ditambah FarmerGroup Id 5', '/kelompok-tani/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"nama_kelompok\":\"Kelompok A\",\"id_desa\":\"1\",\"updated_at\":\"2022-08-22T15:01:30.000000Z\",\"created_at\":\"2022-08-22T15:01:30.000000Z\",\"id\":5}', '-', '2022-08-22 15:01:30', '2022-08-22 15:01:30'),
(172, 41, 'Dihapus Village Id 2', '/desa/delete/2', 'GET', '127.0.0.1', '{\"id\":2,\"nama_desa\":\"Test\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":1,\"created_at\":\"2022-07-30T04:34:32.000000Z\",\"updated_at\":\"2022-07-30T04:34:32.000000Z\",\"deleted_at\":null}', '-', '2022-08-22 15:01:38', '2022-08-22 15:01:38'),
(173, 41, 'Dihapus Village Id 6', '/desa/delete/6', 'GET', '127.0.0.1', '{\"id\":6,\"nama_desa\":\"Testtt\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":1,\"created_at\":\"2022-08-19T08:03:27.000000Z\",\"updated_at\":\"2022-08-19T08:03:27.000000Z\",\"deleted_at\":null}', '-', '2022-08-22 15:01:41', '2022-08-22 15:01:41'),
(174, 41, 'Ditambah District Id 4', '/kecamatan/store', 'POST', '127.0.0.1', '{\"nama_kecamatan\":\"Cisompet\",\"updated_at\":\"2022-08-22T15:02:44.000000Z\",\"created_at\":\"2022-08-22T15:02:44.000000Z\",\"id\":4}', '-', '2022-08-22 15:02:44', '2022-08-22 15:02:44'),
(175, 41, 'Ditambah District Id 5', '/kecamatan/store', 'POST', '127.0.0.1', '{\"nama_kecamatan\":\"Leles\",\"updated_at\":\"2022-08-22T15:02:59.000000Z\",\"created_at\":\"2022-08-22T15:02:59.000000Z\",\"id\":5}', '-', '2022-08-22 15:02:59', '2022-08-22 15:02:59'),
(176, 41, 'Ditambah District Id 6', '/kecamatan/store', 'POST', '127.0.0.1', '{\"nama_kecamatan\":\"Cilawu\",\"updated_at\":\"2022-08-22T15:03:15.000000Z\",\"created_at\":\"2022-08-22T15:03:15.000000Z\",\"id\":6}', '-', '2022-08-22 15:03:15', '2022-08-22 15:03:15'),
(177, 41, 'Dihapus Village Id 4', '/desa/delete/4', 'GET', '127.0.0.1', '{\"id\":4,\"nama_desa\":\"Bojong\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":1,\"created_at\":\"2022-08-18T03:06:33.000000Z\",\"updated_at\":\"2022-08-18T03:06:33.000000Z\",\"deleted_at\":null}', '-', '2022-08-22 15:03:28', '2022-08-22 15:03:28'),
(178, 41, 'Dihapus Village Id 1', '/desa/delete/1', 'GET', '127.0.0.1', '{\"id\":1,\"nama_desa\":\"Desa Cisewuu\",\"long_desa\":\"100\",\"lat_desa\":\"100\",\"id_kecamatan\":3,\"created_at\":\"2022-07-25T13:58:54.000000Z\",\"updated_at\":\"2022-08-19T08:05:58.000000Z\",\"deleted_at\":null}', '-', '2022-08-22 15:04:00', '2022-08-22 15:04:00'),
(179, 41, 'Ditambah Village Id 7', '/desa/store', 'POST', '127.0.0.1', '{\"nama_desa\":\"Bojong\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":\"3\",\"updated_at\":\"2022-08-22T15:04:55.000000Z\",\"created_at\":\"2022-08-22T15:04:55.000000Z\",\"id\":7}', '-', '2022-08-22 15:04:55', '2022-08-22 15:04:55'),
(180, 41, 'Ditambah Village Id 8', '/desa/store', 'POST', '127.0.0.1', '{\"nama_desa\":\"Mulyajaya\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":\"3\",\"updated_at\":\"2022-08-22T15:05:17.000000Z\",\"created_at\":\"2022-08-22T15:05:17.000000Z\",\"id\":8}', '-', '2022-08-22 15:05:17', '2022-08-22 15:05:17'),
(181, 41, 'Ditambah Village Id 9', '/desa/store', 'POST', '127.0.0.1', '{\"nama_desa\":\"Sukajaya\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":\"1\",\"updated_at\":\"2022-08-22T15:06:11.000000Z\",\"created_at\":\"2022-08-22T15:06:11.000000Z\",\"id\":9}', '-', '2022-08-22 15:06:11', '2022-08-22 15:06:11'),
(182, 41, 'Ditambah Village Id 10', '/desa/store', 'POST', '127.0.0.1', '{\"nama_desa\":\"Girimukti\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":\"1\",\"updated_at\":\"2022-08-22T15:07:03.000000Z\",\"created_at\":\"2022-08-22T15:07:03.000000Z\",\"id\":10}', '-', '2022-08-22 15:07:03', '2022-08-22 15:07:03'),
(183, 41, 'Ditambah Village Id 12', '/desa/store', 'POST', '127.0.0.1', '{\"nama_desa\":\"Karangsewu\",\"long_desa\":\"-6.9029888\",\"lat_desa\":\"07.6120355,17\",\"id_kecamatan\":\"1\",\"updated_at\":\"2022-08-22T15:08:17.000000Z\",\"created_at\":\"2022-08-22T15:08:17.000000Z\",\"id\":12}', '-', '2022-08-22 15:08:17', '2022-08-22 15:08:17'),
(184, 41, 'Dihapus CommoditySector Id 5', '/jenis-komoditas/delete/5', 'GET', '127.0.0.1', '{\"id\":5,\"nama_jenis\":\"Test 1\",\"created_at\":\"2022-08-18T02:54:27.000000Z\",\"updated_at\":\"2022-08-18T02:54:27.000000Z\",\"deleted_at\":null}', '-', '2022-08-22 15:25:37', '2022-08-22 15:25:37'),
(185, 41, 'Ditambah CommoditySector Id 7', '/jenis-komoditas/store', 'POST', '127.0.0.1', '{\"nama_jenis\":\"Sayuran\",\"updated_at\":\"2022-08-22T15:29:53.000000Z\",\"created_at\":\"2022-08-22T15:29:53.000000Z\",\"id\":7}', '-', '2022-08-22 15:29:53', '2022-08-22 15:29:53'),
(186, 41, 'Ditambah CommoditySector Id 8', '/jenis-komoditas/store', 'POST', '127.0.0.1', '{\"nama_jenis\":\"Buah\",\"updated_at\":\"2022-08-22T15:30:26.000000Z\",\"created_at\":\"2022-08-22T15:30:26.000000Z\",\"id\":8}', '-', '2022-08-22 15:30:26', '2022-08-22 15:30:26'),
(187, 41, 'Ditambah CommoditySector Id 9', '/jenis-komoditas/store', 'POST', '127.0.0.1', '{\"nama_jenis\":\"Biji-bijian\",\"updated_at\":\"2022-08-22T15:30:35.000000Z\",\"created_at\":\"2022-08-22T15:30:35.000000Z\",\"id\":9}', '-', '2022-08-22 15:30:35', '2022-08-22 15:30:35'),
(188, 41, 'Ditambah Commodity Id 13', '/komoditas/store', 'POST', '127.0.0.1', '{\"nama_komoditas\":\"Apple\",\"icon\":\"iconkomoditas\\/eEbx4IBOl96nJ1JhF2uo8VclpuIaHsFuzwlEMG4g.jpg\",\"id_jenis\":\"8\",\"updated_at\":\"2022-08-22T15:33:19.000000Z\",\"created_at\":\"2022-08-22T15:33:19.000000Z\",\"id\":13}', '-', '2022-08-22 15:33:19', '2022-08-22 15:33:19'),
(189, 41, 'Ditambah Commodity Id 14', '/komoditas/store', 'POST', '127.0.0.1', '{\"nama_komoditas\":\"Kol\",\"icon\":\"iconkomoditas\\/LKJIgjewTGVV4YwuHqag3a5FMcKWHXRTaEz1CBqj.png\",\"id_jenis\":\"7\",\"updated_at\":\"2022-08-22T15:33:34.000000Z\",\"created_at\":\"2022-08-22T15:33:34.000000Z\",\"id\":14}', '-', '2022-08-22 15:33:34', '2022-08-22 15:33:34'),
(190, 41, 'Ditambah Commodity Id 15', '/komoditas/store', 'POST', '127.0.0.1', '{\"nama_komoditas\":\"Jagung\",\"icon\":\"iconkomoditas\\/ePcPIZGoE6BGRwD3DLS1t9FMsLJbqt5RnH4cC904.avif\",\"id_jenis\":\"9\",\"updated_at\":\"2022-08-22T15:33:56.000000Z\",\"created_at\":\"2022-08-22T15:33:56.000000Z\",\"id\":15}', '-', '2022-08-22 15:33:56', '2022-08-22 15:33:56'),
(191, 41, 'Ditambah FarmerGroup Id 6', '/kelompok-tani/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"nama_kelompok\":\"Kelompok A\",\"id_desa\":\"7\",\"updated_at\":\"2022-08-22T15:34:14.000000Z\",\"created_at\":\"2022-08-22T15:34:14.000000Z\",\"id\":6}', '-', '2022-08-22 15:34:14', '2022-08-22 15:34:14'),
(192, 41, 'Ditambah FarmerGroup Id 7', '/kelompok-tani/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"nama_kelompok\":\"Kelompok B\",\"id_desa\":\"8\",\"updated_at\":\"2022-08-22T15:34:25.000000Z\",\"created_at\":\"2022-08-22T15:34:25.000000Z\",\"id\":7}', '-', '2022-08-22 15:34:25', '2022-08-22 15:34:25'),
(193, 41, 'Ditambah Instructor Id 4', '/pendaftaran-penyuluh/store', 'POST', '127.0.0.1', '{\"nama_penyuluh\":\"Ujang\",\"id_user\":45,\"updated_at\":\"2022-08-22T15:34:57.000000Z\",\"created_at\":\"2022-08-22T15:34:57.000000Z\",\"id\":4}', '-', '2022-08-22 15:34:57', '2022-08-22 15:34:57'),
(194, 41, 'Ditambah Instructor Id 5', '/pendaftaran-penyuluh/store', 'POST', '127.0.0.1', '{\"nama_penyuluh\":\"Agus\",\"id_user\":46,\"updated_at\":\"2022-08-22T15:35:20.000000Z\",\"created_at\":\"2022-08-22T15:35:20.000000Z\",\"id\":5}', '-', '2022-08-22 15:35:20', '2022-08-22 15:35:20'),
(195, 41, 'Ditambah FarmerGroup Id 9', '/kelompok-tani/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"nama_kelompok\":\"Kelompok\",\"id_desa\":\"7\",\"updated_at\":\"2022-08-22T15:35:46.000000Z\",\"created_at\":\"2022-08-22T15:35:46.000000Z\",\"id\":9}', '-', '2022-08-22 15:35:46', '2022-08-22 15:35:46'),
(196, 41, 'Diubah FarmerGroup Id 9', '/kelompok-tani/update/9', 'POST', '127.0.0.1', '{\"id\":9,\"nama_kelompok\":\"Kelompok\",\"id_desa\":7,\"id_penyuluh\":3,\"created_at\":\"2022-08-22T15:35:46.000000Z\",\"updated_at\":\"2022-08-22T15:35:46.000000Z\",\"deleted_at\":null}', '{\"id\":9,\"nama_kelompok\":\"Kelompok Jaya\",\"id_desa\":\"7\",\"id_penyuluh\":\"3\",\"created_at\":\"2022-08-22T15:35:46.000000Z\",\"updated_at\":\"2022-08-22T15:35:57.000000Z\",\"deleted_at\":null}', '2022-08-22 15:35:57', '2022-08-22 15:35:57'),
(197, 41, 'Diubah FarmerGroup Id 9', '/kelompok-tani/update/9', 'POST', '127.0.0.1', '{\"id\":9,\"nama_kelompok\":\"Kelompok Jaya\",\"id_desa\":7,\"id_penyuluh\":3,\"created_at\":\"2022-08-22T15:35:46.000000Z\",\"updated_at\":\"2022-08-22T15:35:57.000000Z\",\"deleted_at\":null}', '{\"id\":9,\"nama_kelompok\":\"Kelompok Jaya\",\"id_desa\":\"7\",\"id_penyuluh\":\"4\",\"created_at\":\"2022-08-22T15:35:46.000000Z\",\"updated_at\":\"2022-08-22T15:36:09.000000Z\",\"deleted_at\":null}', '2022-08-22 15:36:09', '2022-08-22 15:36:09'),
(198, 41, 'Ditambah FarmerGroup Id 10', '/kelompok-tani/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"5\",\"nama_kelompok\":\"Kelompok Tani Jaya\",\"id_desa\":\"9\",\"updated_at\":\"2022-08-22T15:36:27.000000Z\",\"created_at\":\"2022-08-22T15:36:27.000000Z\",\"id\":10}', '-', '2022-08-22 15:36:27', '2022-08-22 15:36:27'),
(199, 41, 'Ditambah CollectingTraderCommodity Id 2', '/komoditas-pengepul/store', 'POST', '127.0.0.1', '{\"id_pengepul\":\"6\",\"id_penyuluh\":\"3\",\"id_komoditas\":\"14\",\"harga\":\"12000\",\"updated_at\":\"2022-08-22T15:36:48.000000Z\",\"created_at\":\"2022-08-22T15:36:48.000000Z\",\"id\":2}', '-', '2022-08-22 15:36:48', '2022-08-22 15:36:48'),
(200, 41, 'Ditambah CollectingTraderCommodity Id 3', '/komoditas-pengepul/store', 'POST', '127.0.0.1', '{\"id_pengepul\":\"6\",\"id_penyuluh\":\"4\",\"id_komoditas\":\"15\",\"harga\":\"9000\",\"updated_at\":\"2022-08-22T15:37:02.000000Z\",\"created_at\":\"2022-08-22T15:37:02.000000Z\",\"id\":3}', '-', '2022-08-22 15:37:02', '2022-08-22 15:37:02'),
(201, 41, 'Ditambah CollectingTraderCommodity Id 4', '/komoditas-pengepul/store', 'POST', '127.0.0.1', '{\"id_pengepul\":\"6\",\"id_penyuluh\":\"3\",\"id_komoditas\":\"14\",\"harga\":\"3000\",\"updated_at\":\"2022-08-22T15:37:14.000000Z\",\"created_at\":\"2022-08-22T15:37:14.000000Z\",\"id\":4}', '-', '2022-08-22 15:37:14', '2022-08-22 15:37:14'),
(202, 41, 'Diubah CollectingTraderCommodity Id 2', '/komoditas-pengepul/update/2', 'POST', '127.0.0.1', '{\"id\":2,\"id_komoditas\":14,\"created_at\":\"2022-08-22T15:36:48.000000Z\",\"updated_at\":\"2022-08-22T15:36:48.000000Z\",\"deleted_at\":null,\"id_pengepul\":6,\"id_penyuluh\":3,\"harga\":12000}', '{\"id\":2,\"id_komoditas\":\"15\",\"created_at\":\"2022-08-22T15:36:48.000000Z\",\"updated_at\":\"2022-08-22T15:37:25.000000Z\",\"deleted_at\":null,\"id_pengepul\":\"6\",\"id_penyuluh\":\"3\",\"harga\":\"12000\"}', '2022-08-22 15:37:25', '2022-08-22 15:37:25'),
(203, 41, 'Diubah CollectingTraderCommodity Id 2', '/komoditas-pengepul/update/2', 'POST', '127.0.0.1', '{\"id\":2,\"id_komoditas\":15,\"created_at\":\"2022-08-22T15:36:48.000000Z\",\"updated_at\":\"2022-08-22T15:37:25.000000Z\",\"deleted_at\":null,\"id_pengepul\":6,\"id_penyuluh\":3,\"harga\":12000}', '{\"id\":2,\"id_komoditas\":\"13\",\"created_at\":\"2022-08-22T15:36:48.000000Z\",\"updated_at\":\"2022-08-22T15:37:33.000000Z\",\"deleted_at\":null,\"id_pengepul\":\"6\",\"id_penyuluh\":\"3\",\"harga\":\"12000\"}', '2022-08-22 15:37:33', '2022-08-22 15:37:33'),
(204, 41, 'Ditambah Farmer Id 16', '/pendaftaran-petani/store', 'POST', '127.0.0.1', '{\"id_kelompok\":\"6\",\"nama_petani\":\"Fajar\",\"photo\":\"photo_petani\\/XifBSHMMBJHHk15d0iUB1kHTkX07ONlh1nweadCQ.jpg\",\"alamat\":\"Dago\",\"id_desa\":\"7\",\"status\":\"1\",\"id_user\":47,\"updated_at\":\"2022-08-22T15:43:13.000000Z\",\"created_at\":\"2022-08-22T15:43:13.000000Z\",\"id\":16}', '-', '2022-08-22 15:43:13', '2022-08-22 15:43:13'),
(205, 41, 'Ditambah Farmer Id 17', '/pendaftaran-petani/store', 'POST', '127.0.0.1', '{\"id_kelompok\":\"9\",\"nama_petani\":\"Cecep\",\"photo\":\"photo_petani\\/ZyHD3QFXnVtB7FTMws3r3POs8IanVTL1dyvAQXNt.jpg\",\"alamat\":\"Cisewu\",\"id_desa\":\"9\",\"status\":\"2\",\"id_user\":48,\"updated_at\":\"2022-08-22T15:43:55.000000Z\",\"created_at\":\"2022-08-22T15:43:55.000000Z\",\"id\":17}', '-', '2022-08-22 15:43:55', '2022-08-22 15:43:55'),
(206, 41, 'Ditambah Plant Id 4', '/tanam/store', 'POST', '127.0.0.1', '{\"id_petani\":\"16\",\"id_komoditas\":\"13\",\"tanggal_tanam\":\"2022-08-22\",\"luas_tanam\":\"300\",\"jenis_pupuk\":\"Kompos\",\"biaya_produksi\":\"50000\",\"updated_at\":\"2022-08-22T15:44:39.000000Z\",\"created_at\":\"2022-08-22T15:44:39.000000Z\",\"id\":4}', '-', '2022-08-22 15:44:39', '2022-08-22 15:44:39'),
(207, 41, 'Ditambah Plant Id 5', '/tanam/store', 'POST', '127.0.0.1', '{\"id_petani\":\"17\",\"id_komoditas\":\"14\",\"tanggal_tanam\":\"2022-08-04\",\"luas_tanam\":\"14\",\"jenis_pupuk\":\"Kompos\",\"biaya_produksi\":\"500000\",\"updated_at\":\"2022-08-22T15:44:58.000000Z\",\"created_at\":\"2022-08-22T15:44:58.000000Z\",\"id\":5}', '-', '2022-08-22 15:44:58', '2022-08-22 15:44:58'),
(208, 41, 'Diubah Plant Id 4', '/tanam/update/4', 'POST', '127.0.0.1', '{\"id\":4,\"id_komoditas\":13,\"id_petani\":\"16\",\"tanggal_tanam\":\"2022-08-22\",\"luas_tanam\":\"300\",\"jenis_pupuk\":\"Kompos\",\"biaya_produksi\":50000,\"created_at\":\"2022-08-22T15:44:39.000000Z\",\"updated_at\":\"2022-08-22T15:44:39.000000Z\",\"deleted_at\":null}', '{\"id\":4,\"id_komoditas\":\"13\",\"id_petani\":\"16\",\"tanggal_tanam\":\"2022-08-22\",\"luas_tanam\":\"300\",\"jenis_pupuk\":\"Kompos\",\"biaya_produksi\":\"120000\",\"created_at\":\"2022-08-22T15:44:39.000000Z\",\"updated_at\":\"2022-08-22T15:45:04.000000Z\",\"deleted_at\":null}', '2022-08-22 15:45:04', '2022-08-22 15:45:04'),
(209, 41, 'Ditambah MarketPrice Id 8', '/harga-pasar/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"id_komoditas\":\"13\",\"periode_bulan\":\"2022-08-22\",\"harga_pasar_lokal\":\"9000\",\"harga_pasar_induk\":\"12000\",\"updated_at\":\"2022-08-22T15:45:28.000000Z\",\"created_at\":\"2022-08-22T15:45:28.000000Z\",\"id\":8}', '-', '2022-08-22 15:45:28', '2022-08-22 15:45:28'),
(210, 41, 'Ditambah MarketPrice Id 9', '/harga-pasar/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"4\",\"id_komoditas\":\"13\",\"periode_bulan\":\"2022-08-22\",\"harga_pasar_lokal\":\"9500\",\"harga_pasar_induk\":\"13000\",\"updated_at\":\"2022-08-22T15:45:47.000000Z\",\"created_at\":\"2022-08-22T15:45:47.000000Z\",\"id\":9}', '-', '2022-08-22 15:45:47', '2022-08-22 15:45:47'),
(211, 41, 'Ditambah MarketPrice Id 10', '/harga-pasar/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"3\",\"id_komoditas\":\"14\",\"periode_bulan\":\"2022-08-22\",\"harga_pasar_lokal\":\"3900\",\"harga_pasar_induk\":\"4200\",\"updated_at\":\"2022-08-22T15:46:07.000000Z\",\"created_at\":\"2022-08-22T15:46:07.000000Z\",\"id\":10}', '-', '2022-08-22 15:46:07', '2022-08-22 15:46:07'),
(212, 41, 'Ditambah MarketPrice Id 11', '/harga-pasar/store', 'POST', '127.0.0.1', '{\"id_penyuluh\":\"4\",\"id_komoditas\":\"15\",\"periode_bulan\":\"2022-07-07\",\"harga_pasar_lokal\":\"8000\",\"harga_pasar_induk\":\"9500\",\"updated_at\":\"2022-08-22T15:46:30.000000Z\",\"created_at\":\"2022-08-22T15:46:30.000000Z\",\"id\":11}', '-', '2022-08-22 15:46:30', '2022-08-22 15:46:30'),
(213, 41, 'Ditambah FarmerPrice Id 3', '/harga-petani/store', 'POST', '127.0.0.1', '{\"id_petani\":\"16\",\"id_komoditas\":\"13\",\"periode_bulan\":\"2022-08-22\",\"harga_tani\":\"9000\",\"updated_at\":\"2022-08-22T15:46:58.000000Z\",\"created_at\":\"2022-08-22T15:46:58.000000Z\",\"id\":3}', '-', '2022-08-22 15:46:58', '2022-08-22 15:46:58'),
(214, 41, 'Diubah FarmerPrice Id 3', '/harga-petani/update/3', 'POST', '127.0.0.1', '{\"id\":3,\"id_komoditas\":13,\"periode_bulan\":\"2022-08-22\",\"harga_tani\":9000,\"id_petani\":16,\"created_at\":\"2022-08-22T15:46:58.000000Z\",\"updated_at\":\"2022-08-22T15:46:58.000000Z\"}', '{\"id\":3,\"id_komoditas\":\"13\",\"periode_bulan\":\"2022-08-22\",\"harga_tani\":\"7600\",\"id_petani\":\"16\",\"created_at\":\"2022-08-22T15:46:58.000000Z\",\"updated_at\":\"2022-08-22T15:47:16.000000Z\"}', '2022-08-22 15:47:16', '2022-08-22 15:47:16'),
(215, 41, 'Ditambah FarmerPrice Id 4', '/harga-petani/store', 'POST', '127.0.0.1', '{\"id_petani\":\"17\",\"id_komoditas\":\"13\",\"periode_bulan\":\"2022-08-22\",\"harga_tani\":\"7900\",\"updated_at\":\"2022-08-22T15:47:51.000000Z\",\"created_at\":\"2022-08-22T15:47:51.000000Z\",\"id\":4}', '-', '2022-08-22 15:47:51', '2022-08-22 15:47:51'),
(216, 41, 'Ditambah FarmerPrice Id 5', '/harga-petani/store', 'POST', '127.0.0.1', '{\"id_petani\":\"16\",\"id_komoditas\":\"15\",\"periode_bulan\":\"2022-08-22\",\"harga_tani\":\"2300\",\"updated_at\":\"2022-08-22T15:48:03.000000Z\",\"created_at\":\"2022-08-22T15:48:03.000000Z\",\"id\":5}', '-', '2022-08-22 15:48:03', '2022-08-22 15:48:03'),
(217, 41, 'Diubah CollectingTrader Id 6', '/pengepul/update/6', 'POST', '127.0.0.1', '{\"id\":6,\"nama_pengepul\":\"Arsy\",\"created_at\":\"2022-08-20T17:09:55.000000Z\",\"updated_at\":\"2022-08-20T17:09:55.000000Z\",\"deleted_at\":null,\"kontak\":812222,\"alamat\":\"aalka\",\"lokasi_distribusi\":\"Bandung\"}', '{\"id\":6,\"nama_pengepul\":\"Arsy\",\"created_at\":\"2022-08-20T17:09:55.000000Z\",\"updated_at\":\"2022-08-22T15:48:24.000000Z\",\"deleted_at\":null,\"kontak\":\"0812222\",\"alamat\":\"Cimahi\",\"lokasi_distribusi\":\"Bandung\"}', '2022-08-22 15:48:24', '2022-08-22 15:48:24'),
(218, 41, 'Ditambah CollectingTrader Id 8', '/pengepul/store', 'POST', '127.0.0.1', '{\"nama_pengepul\":\"Jajang\",\"alamat\":\"Soreang\",\"kontak\":\"081223342\",\"lokasi_distribusi\":\"Garut\",\"updated_at\":\"2022-08-22T15:48:45.000000Z\",\"created_at\":\"2022-08-22T15:48:45.000000Z\",\"id\":8}', '-', '2022-08-22 15:48:45', '2022-08-22 15:48:45'),
(219, 41, 'Ditambah Farmer Id 18', '/pendaftaran-petani/store', 'POST', '127.0.0.1', '{\"id_kelompok\":\"6\",\"nama_petani\":\"Sari\",\"photo\":\"photo_petani\\/oFu97hIzk8uWBuR0iIue7xf5YfZDyAWZXLBIBw53.png\",\"alamat\":\"Cisewu\",\"id_desa\":\"7\",\"status\":\"3\",\"id_user\":49,\"updated_at\":\"2022-08-22T15:50:15.000000Z\",\"created_at\":\"2022-08-22T15:50:15.000000Z\",\"id\":18}', '-', '2022-08-22 15:50:15', '2022-08-22 15:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_komoditas`
--

CREATE TABLE `lokasi_komoditas` (
  `id` int(11) NOT NULL,
  `long_komoditas` text NOT NULL,
  `lat_komoditas` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2022_08_18_094354_update_table_commodity_type', 2),
(3, '2022_08_18_095742_update_table_commodity', 3),
(4, '2022_08_18_100121_update_table_village', 4),
(5, '2022_08_18_100724_update_table_district', 5),
(6, '2022_08_18_111012_update_table_farmer_group', 6),
(7, '2022_08_20_235137_update_table_pengepul', 7),
(8, '2022_08_21_001519_delete_column_table_pengepul', 8),
(9, '2022_08_21_002644_update_table_farmer', 9),
(12, '2022_08_22_120849_update_table_commodity_pengepul', 10),
(13, '2022_08_22_193541_update_table_user', 11);

-- --------------------------------------------------------

--
-- Table structure for table `panen`
--

CREATE TABLE `panen` (
  `id` int(11) NOT NULL,
  `id_petani` int(11) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `tanggal_panen` date NOT NULL,
  `jumlah_panen` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengepul`
--

CREATE TABLE `pengepul` (
  `id` int(11) NOT NULL,
  `nama_pengepul` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `kontak` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `lokasi_distribusi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengepul`
--

INSERT INTO `pengepul` (`id`, `nama_pengepul`, `created_at`, `updated_at`, `deleted_at`, `kontak`, `alamat`, `lokasi_distribusi`) VALUES
(6, 'Arsy', '2022-08-20 17:09:55', '2022-08-22 15:48:24', NULL, 812222, 'Cimahi', 'Bandung'),
(8, 'Jajang', '2022-08-22 15:48:45', '2022-08-22 15:48:45', NULL, 81223342, 'Soreang', 'Garut');

-- --------------------------------------------------------

--
-- Table structure for table `penyuluh`
--

CREATE TABLE `penyuluh` (
  `id` int(11) NOT NULL,
  `nama_penyuluh` varchar(50) NOT NULL,
  `kontak` varchar(13) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyuluh`
--

INSERT INTO `penyuluh` (`id`, `nama_penyuluh`, `kontak`, `id_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Asep', NULL, 44, '2022-08-22 14:47:42', '2022-08-22 14:47:42', NULL),
(4, 'Ujang', NULL, 45, '2022-08-22 15:34:57', '2022-08-22 15:34:57', NULL),
(5, 'Agus', NULL, 46, '2022-08-22 15:35:20', '2022-08-22 15:35:20', NULL);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petani`
--

CREATE TABLE `petani` (
  `id` int(11) NOT NULL,
  `id_kelompok` varchar(10) NOT NULL,
  `nama_petani` varchar(70) NOT NULL,
  `id_desa` int(11) NOT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `photo` text NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petani`
--

INSERT INTO `petani` (`id`, `id_kelompok`, `nama_petani`, `id_desa`, `no_hp`, `status`, `id_user`, `created_at`, `updated_at`, `deleted_at`, `photo`, `alamat`) VALUES
(16, '6', 'Fajar', 7, NULL, 1, 47, '2022-08-22 15:43:13', '2022-08-22 15:43:13', NULL, 'photo_petani/XifBSHMMBJHHk15d0iUB1kHTkX07ONlh1nweadCQ.jpg', 'Dago'),
(17, '9', 'Cecep', 9, NULL, 2, 48, '2022-08-22 15:43:55', '2022-08-22 15:43:55', NULL, 'photo_petani/ZyHD3QFXnVtB7FTMws3r3POs8IanVTL1dyvAQXNt.jpg', 'Cisewu'),
(18, '6', 'Sari', 7, NULL, 3, 49, '2022-08-22 15:50:15', '2022-08-22 15:50:15', NULL, 'photo_petani/oFu97hIzk8uWBuR0iIue7xf5YfZDyAWZXLBIBw53.png', 'Cisewu');

-- --------------------------------------------------------

--
-- Table structure for table `tanam`
--

CREATE TABLE `tanam` (
  `id` int(11) NOT NULL,
  `id_komoditas` int(11) NOT NULL,
  `id_petani` varchar(15) NOT NULL,
  `tanggal_tanam` date NOT NULL,
  `luas_tanam` varchar(10) NOT NULL,
  `jenis_pupuk` varchar(30) NOT NULL,
  `biaya_produksi` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tanam`
--

INSERT INTO `tanam` (`id`, `id_komoditas`, `id_petani`, `tanggal_tanam`, `luas_tanam`, `jenis_pupuk`, `biaya_produksi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 13, '16', '2022-08-22', '300', 'Kompos', 120000, '2022-08-22 15:44:39', '2022-08-22 15:45:04', NULL),
(5, 14, '17', '2022-08-04', '14', 'Kompos', 500000, '2022-08-22 15:44:58', '2022-08-22 15:44:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `level` enum('1','2','3','4') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `nik` bigint(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `no_hp`, `password`, `remember_token`, `level`, `created_at`, `updated_at`, `deleted_at`, `nik`) VALUES
(41, '081276643981', 'sirWKQb2THiAY', NULL, '1', '2022-08-22 13:08:53', '2022-08-22 13:10:42', NULL, 3273022208220001),
(44, '081276643933', 'sirWKQb2THiAY', NULL, '2', '2022-08-22 14:47:42', '2022-08-22 14:47:42', NULL, 3273022208220002),
(45, '081276643981', 'sirWKQb2THiAY', NULL, '2', '2022-08-22 15:34:57', '2022-08-22 15:34:57', NULL, 3273022208220003),
(46, '081276643933', 'sirWKQb2THiAY', NULL, '2', '2022-08-22 15:35:20', '2022-08-22 15:35:20', NULL, 3273022208220004),
(47, '081276643933', 'sirWKQb2THiAY', NULL, '3', '2022-08-22 15:43:13', '2022-08-22 15:43:13', NULL, 3273022208220005),
(48, '081276643981', 'sirWKQb2THiAY', NULL, '4', '2022-08-22 15:43:55', '2022-08-22 15:43:55', NULL, 3273022208220006),
(49, '081276643933', 'sirWKQb2THiAY', NULL, '4', '2022-08-22 15:50:15', '2022-08-22 15:50:15', NULL, 3273022208220007);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkbr` (`id_user`);

--
-- Indexes for table `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `desa_nama_desa_unique` (`nama_desa`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `harga_kelompok_tani`
--
ALTER TABLE `harga_kelompok_tani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`id_petani`) USING BTREE,
  ADD KEY `fkkloi` (`id_komoditas`);

--
-- Indexes for table `harga_pasar`
--
ALTER TABLE `harga_pasar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penyuluh` (`id_penyuluh`),
  ADD KEY `id_komoditas` (`id_komoditas`);

--
-- Indexes for table `jenis_komoditas`
--
ALTER TABLE `jenis_komoditas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis_komoditas_nama_jenis_unique` (`nama_jenis`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kecamatan_nama_kecamatan_unique` (`nama_kecamatan`);

--
-- Indexes for table `kelompok_tani`
--
ALTER TABLE `kelompok_tani`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelompok_tani_nama_kelompok_unique` (`nama_kelompok`),
  ADD KEY `fk` (`id_penyuluh`,`id_desa`),
  ADD KEY `fkdes` (`id_desa`);

--
-- Indexes for table `komoditas`
--
ALTER TABLE `komoditas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `komoditas_nama_komoditas_unique` (`nama_komoditas`),
  ADD KEY `jenis` (`id_jenis`);

--
-- Indexes for table `komoditas_pengepul`
--
ALTER TABLE `komoditas_pengepul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`id`,`id_komoditas`),
  ADD KEY `fkkomod` (`id_komoditas`),
  ADD KEY `id_pengepul` (`id_pengepul`),
  ADD KEY `id_penyuluh` (`id_penyuluh`);

--
-- Indexes for table `komoditas_petani`
--
ALTER TABLE `komoditas_petani`
  ADD KEY `idkompt` (`id`,`id_komoditas`),
  ADD KEY `fkkompet` (`id_komoditas`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lokasi_komoditas`
--
ALTER TABLE `lokasi_komoditas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panen`
--
ALTER TABLE `panen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_petani` (`id_petani`,`id_komoditas`) USING BTREE,
  ADD KEY `fkomo` (`id_komoditas`);

--
-- Indexes for table `pengepul`
--
ALTER TABLE `pengepul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyuluh`
--
ALTER TABLE `penyuluh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkpeyh` (`id_user`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petani`
--
ALTER TABLE `petani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`id_user`),
  ADD KEY `fkkl` (`id_kelompok`),
  ADD KEY `fdesa` (`id_desa`);

--
-- Indexes for table `tanam`
--
ALTER TABLE `tanam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`tanggal_tanam`,`id_komoditas`),
  ADD KEY `fkpet` (`id_petani`),
  ADD KEY `komoo` (`id_komoditas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `desa`
--
ALTER TABLE `desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `harga_kelompok_tani`
--
ALTER TABLE `harga_kelompok_tani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `harga_pasar`
--
ALTER TABLE `harga_pasar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jenis_komoditas`
--
ALTER TABLE `jenis_komoditas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelompok_tani`
--
ALTER TABLE `kelompok_tani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komoditas`
--
ALTER TABLE `komoditas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `komoditas_pengepul`
--
ALTER TABLE `komoditas_pengepul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `panen`
--
ALTER TABLE `panen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengepul`
--
ALTER TABLE `pengepul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penyuluh`
--
ALTER TABLE `penyuluh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petani`
--
ALTER TABLE `petani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tanam`
--
ALTER TABLE `tanam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `desa`
--
ALTER TABLE `desa`
  ADD CONSTRAINT `desa_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id`);

--
-- Constraints for table `harga_kelompok_tani`
--
ALTER TABLE `harga_kelompok_tani`
  ADD CONSTRAINT `harga_kelompok_tani_ibfk_1` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`),
  ADD CONSTRAINT `harga_kelompok_tani_ibfk_2` FOREIGN KEY (`id_petani`) REFERENCES `petani` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `harga_pasar`
--
ALTER TABLE `harga_pasar`
  ADD CONSTRAINT `harga_pasar_ibfk_1` FOREIGN KEY (`id_penyuluh`) REFERENCES `penyuluh` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `harga_pasar_ibfk_2` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`);

--
-- Constraints for table `kelompok_tani`
--
ALTER TABLE `kelompok_tani`
  ADD CONSTRAINT `kelompok_tani_ibfk_1` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelompok_tani_ibfk_2` FOREIGN KEY (`id_penyuluh`) REFERENCES `penyuluh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komoditas`
--
ALTER TABLE `komoditas`
  ADD CONSTRAINT `komoditas_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_komoditas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komoditas_pengepul`
--
ALTER TABLE `komoditas_pengepul`
  ADD CONSTRAINT `komoditas_pengepul_ibfk_1` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komoditas_pengepul_ibfk_2` FOREIGN KEY (`id_pengepul`) REFERENCES `pengepul` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komoditas_pengepul_ibfk_3` FOREIGN KEY (`id_penyuluh`) REFERENCES `penyuluh` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komoditas_petani`
--
ALTER TABLE `komoditas_petani`
  ADD CONSTRAINT `komoditas_petani_ibfk_1` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`);

--
-- Constraints for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD CONSTRAINT `log_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `panen`
--
ALTER TABLE `panen`
  ADD CONSTRAINT `panen_ibfk_1` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penyuluh`
--
ALTER TABLE `penyuluh`
  ADD CONSTRAINT `penyuluh_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `petani`
--
ALTER TABLE `petani`
  ADD CONSTRAINT `petani_ibfk_2` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `petani_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tanam`
--
ALTER TABLE `tanam`
  ADD CONSTRAINT `tanam_ibfk_1` FOREIGN KEY (`id_komoditas`) REFERENCES `komoditas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
