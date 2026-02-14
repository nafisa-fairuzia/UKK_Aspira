-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2026 at 07:25 AM
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
-- Database: `ukk_aspira`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `profile_pic`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '$2y$12$zbqJRcmEV6wy6tU7PRRZGOV0mKPvIAyimFrj8bTq0KpbWx5plHCqC', 'Muhammad Rizki', NULL, '2026-02-07 09:12:57', '2026-02-11 12:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` bigint UNSIGNED NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `id_kategori` bigint UNSIGNED NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `id_input_aspirasi` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `status`, `id_kategori`, `feedback`, `id_input_aspirasi`, `created_at`, `updated_at`) VALUES
(1, 'Selesai', 9, NULL, 1, '2026-02-07 09:50:17', '2026-02-07 09:50:17'),
(2, 'Proses', 10, 'oke', 2, '2026-02-07 09:50:34', '2026-02-07 09:50:34'),
(3, 'Selesai', 13, NULL, 5, '2026-02-08 09:51:06', '2026-02-08 09:57:08'),
(4, 'Proses', 12, 'oke', 4, '2026-02-08 09:56:31', '2026-02-08 09:56:31'),
(5, 'Proses', 11, 'Okee', 6, '2026-02-08 10:06:01', '2026-02-08 10:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` bigint UNSIGNED NOT NULL,
  `nis` int NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `lokasi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu','Proses','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggapan_admin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `status`, `gambar`, `tanggapan_admin`, `created_at`, `updated_at`) VALUES
(1, 12345678, 9, 'Ruang 9', 'Atapnya Bocor', 'Menunggu', NULL, NULL, '2026-02-07 09:47:53', '2026-02-07 09:47:53'),
(2, 12345678, 10, 'RPS', 'Wifinya Lambat', 'Menunggu', NULL, NULL, '2026-02-07 09:48:19', '2026-02-07 09:48:19'),
(4, 12345676, 12, 'Ruang 8', 'Pintunya Gabiisa di Kunci', 'Menunggu', 'aspirasi/p1Dsx1D69gFvy4lk39FeH5xOkH9NyWt8aWIEnXwT.jpg', NULL, '2026-02-08 09:10:37', '2026-02-08 09:10:37'),
(5, 12345677, 13, 'Ruang 21', 'Lampunya Kurang Terang', 'Menunggu', 'aspirasi/kPZtFFNYhoP2reysajn8poSc4Erxs1GiemC28PPN.jpg', NULL, '2026-02-08 09:14:36', '2026-02-08 09:14:36'),
(6, 12345678, 11, 'Toilet RPS', 'Toiletnya Kotor', 'Menunggu', 'aspirasi/48PSmTlzHYXWp4WQA9Z8WeodsMxUfSIMe8JWuSOB.jpg', NULL, '2026-02-08 10:04:05', '2026-02-08 10:04:54'),
(7, 12345678, 13, 'RPS', 'Lampunya Redup', 'Menunggu', 'aspirasi/EvZkEFYIDXiHbVt6Ec7GhwyIWTGewnA3GUxnQGBL.jpg', NULL, '2026-02-11 08:39:33', '2026-02-11 08:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint UNSIGNED NOT NULL,
  `ket_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(9, 'Ruang & Bangunan', '2026-02-07 09:45:44', '2026-02-07 09:45:44'),
(10, 'Internet & Jaringan', '2026-02-07 09:45:50', '2026-02-07 09:45:50'),
(11, 'Air & Toilet', '2026-02-07 09:46:08', '2026-02-07 09:46:08'),
(12, 'Keamanan', '2026-02-07 09:46:16', '2026-02-07 09:46:16'),
(13, 'Lampu & Penerangan', '2026-02-07 09:46:27', '2026-02-07 09:46:27'),
(15, 'Perangkat IT', '2026-02-12 00:23:13', '2026-02-12 00:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, 'X TKJ 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(2, 'X TKJ 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(3, 'X RPL 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(4, 'X RPL 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(5, 'X DKV 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(6, 'X DKV 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(7, 'X APT 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(8, 'X APT 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(9, 'X ATPH 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(10, 'X ATPH 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(11, 'X TSM 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(12, 'X TSM 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(13, 'X TSM 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(14, 'X TKR 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(15, 'X TKR 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(16, 'X TKR 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(17, 'XI TKJ 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(18, 'XI TKJ 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(19, 'XI RPL 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(20, 'XI RPL 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(21, 'XI DKV 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(22, 'XI DKV 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(23, 'XI APT 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(24, 'XI APT 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(25, 'XI ATPH 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(26, 'XI ATPH 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(27, 'XI TSM 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(28, 'XI TSM 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(29, 'XI TSM 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(30, 'XI TKR 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(31, 'XI TKR 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(32, 'XI TKR 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(33, 'XII TKJ 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(34, 'XII TKJ 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(35, 'XII RPL 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(36, 'XII RPL 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(37, 'XII DKV 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(38, 'XII DKV 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(39, 'XII APT 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(40, 'XII APT 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(41, 'XII ATPH 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(42, 'XII ATPH 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(43, 'XII TSM 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(44, 'XII TSM 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(45, 'XII TSM 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(46, 'XII TKR 1', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(47, 'XII TKR 2', '2026-02-07 09:11:39', '2026-02-07 09:11:39'),
(48, 'XII TKR 3', '2026-02-07 09:11:39', '2026-02-07 09:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_11_000001_create_kategori_table', 1),
(5, '2026_01_11_000050_create_kelas_table', 1),
(6, '2026_01_11_073129_create_admin_table', 1),
(7, '2026_01_11_073208_create_siswa_table', 1),
(8, '2026_01_11_073300_create_input_aspirasi_table', 1),
(9, '2026_01_11_073400_create_aspirasi_table', 1),
(10, '2026_01_15_004134_create_notifikasi_table', 1),
(11, '2026_02_06_000001_add_username_password_to_siswa_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe` enum('admin','siswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `id_pengaduan` bigint UNSIGNED DEFAULT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `judul`, `pesan`, `url`, `tipe`, `id_pengaduan`, `dibaca`, `created_at`, `updated_at`) VALUES
(1, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/1', 'admin', 1, 1, '2026-02-07 09:47:53', '2026-02-07 09:49:42'),
(2, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/2', 'admin', 2, 1, '2026-02-07 09:48:19', '2026-02-07 09:49:38'),
(4, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Selesai', 'http://127.0.0.1:8000/siswa/pengaduan/1', 'siswa', 1, 1, '2026-02-07 09:50:17', '2026-02-07 09:51:32'),
(5, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Proses', 'http://127.0.0.1:8000/siswa/pengaduan/2', 'siswa', 2, 1, '2026-02-07 09:50:34', '2026-02-07 09:51:32'),
(6, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/4', 'admin', 4, 1, '2026-02-08 09:10:37', '2026-02-08 09:34:09'),
(7, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/5', 'admin', 5, 1, '2026-02-08 09:14:36', '2026-02-08 09:34:09'),
(8, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Proses', 'http://127.0.0.1:8000/siswa/pengaduan/5', 'siswa', 5, 0, '2026-02-08 09:51:06', '2026-02-08 09:51:06'),
(9, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Proses', 'http://127.0.0.1:8000/siswa/pengaduan/4', 'siswa', 4, 0, '2026-02-08 09:56:31', '2026-02-08 09:56:31'),
(10, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Selesai', 'http://127.0.0.1:8000/siswa/pengaduan/5', 'siswa', 5, 0, '2026-02-08 09:57:08', '2026-02-08 09:57:08'),
(11, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/6', 'admin', 6, 1, '2026-02-08 10:04:05', '2026-02-08 10:05:47'),
(12, 'Status Pengaduan Diperbarui', 'Status pengaduan Anda telah diperbarui menjadi: Proses', 'http://127.0.0.1:8000/siswa/pengaduan/6', 'siswa', 6, 1, '2026-02-08 10:06:01', '2026-02-08 10:06:21'),
(13, 'Pengaduan Baru', 'Ada pengaduan baru dari siswa yang perlu ditinjau', 'http://127.0.0.1:8000/admin/pengaduan/7', 'admin', 7, 1, '2026-02-11 08:39:33', '2026-02-11 09:39:55');

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8vVPgUZnuUpfK902MwuVGXgdLJusH4GkBvxq5zLv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiUTN3MmFyZkxBWkh0OEpHN3lVbWRlbmJ4SVAyRHoyUjJjWE1YbE40NSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo1OiJsb2dpbiI7YjoxO3M6NDoicm9sZSI7czo1OiJhZG1pbiI7czo4OiJhZG1pbl9pZCI7aToxO3M6NDoibmFtYSI7czoxNDoiTXVoYW1tYWQgUml6a2kiO3M6MTE6InByb2ZpbGVfcGljIjtOO30=', 1770880933);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` bigint UNSIGNED NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `username`, `password`, `id_kelas`, `profile_pic`, `created_at`, `updated_at`) VALUES
(12345676, 'Dani Saputra', 'Dani', '$2y$12$40avNqY1exEorTkRzWOpFubmnStuPx.Wfe6uV/h9XFcQh6gBj.xvm', 31, NULL, '2026-02-08 09:08:13', '2026-02-08 09:08:13'),
(12345677, 'Fina Aulia', 'Fina', '$2y$12$kaY0rl/MMHW/5oKmUugo7uTJU2Vq0Y4BuaQbUhz9Td7e8bZsdhwpO', 33, NULL, '2026-02-08 09:06:31', '2026-02-08 09:06:31'),
(12345678, 'Nafisa Fairuzia', 'nafisa', '$2y$12$fPXKv8xvWW5GTIov1dJExOx5VKM8Zu7SfBLQWDyMSS9rgUn7wv3Jm', 36, NULL, '2026-02-07 09:22:12', '2026-02-11 08:38:51'),
(12345679, 'Muhammad Ilham', 'Ilham', '$2y$12$EZtIw64o2rja6B6UfFZJf.IoF4BTtulVT3KPImSxqF3lKdDnGAxJG', 35, NULL, '2026-02-08 01:30:52', '2026-02-08 01:30:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
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
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username_unique` (`username`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `aspirasi_id_kategori_foreign` (`id_kategori`),
  ADD KEY `aspirasi_id_input_aspirasi_foreign` (`id_input_aspirasi`);

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
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `input_aspirasi_nis_foreign` (`nis`),
  ADD KEY `input_aspirasi_id_kategori_foreign` (`id_kategori`);

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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_pengaduan_foreign` (`id_pengaduan`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD UNIQUE KEY `siswa_username_unique` (`username`),
  ADD KEY `siswa_id_kelas_foreign` (`id_kelas`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_id_input_aspirasi_foreign` FOREIGN KEY (`id_input_aspirasi`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `input_aspirasi_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
