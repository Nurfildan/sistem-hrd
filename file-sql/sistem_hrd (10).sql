-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Feb 2026 pada 03.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_hrd`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status` enum('Hadir','Terlambat','Izin','Sakit','Alpa','Cuti') NOT NULL DEFAULT 'Hadir',
  `terlambat_menit` int(11) NOT NULL DEFAULT 0,
  `sumber` enum('Auto','Manual') NOT NULL DEFAULT 'Auto',
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `karyawan_id`, `shift_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `status`, `terlambat_menit`, `sumber`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-12-30', '13:03:49', '13:06:46', 'Terlambat', 0, 'Auto', NULL, '2025-12-30 06:03:49', '2025-12-30 06:06:46'),
(2, 2, 1, '2026-01-05', '08:51:02', NULL, 'Terlambat', 0, 'Auto', NULL, '2026-01-05 01:51:02', '2026-01-05 01:51:02'),
(4, 2, 1, '2026-01-14', '10:11:35', '10:11:44', 'Terlambat', 0, 'Auto', NULL, '2026-01-14 03:11:35', '2026-01-14 03:11:44'),
(5, 2, 1, '2026-02-09', '09:15:25', '09:15:34', 'Terlambat', 0, 'Auto', NULL, '2026-02-09 02:15:25', '2026-02-09 02:15:34'),
(6, 2, 1, '2026-02-19', '10:44:54', '10:45:15', 'Hadir', 0, 'Auto', NULL, '2026-02-19 03:44:54', '2026-02-19 03:45:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aturan_potongan_jabatan`
--

CREATE TABLE `aturan_potongan_jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `potongan_hadir` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_terlambat` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_izin` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_sakit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_alpa` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_cuti` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aturan_potongan_jabatan`
--

INSERT INTO `aturan_potongan_jabatan` (`id`, `jabatan_id`, `potongan_hadir`, `potongan_terlambat`, `potongan_izin`, `potongan_sakit`, `potongan_alpa`, `potongan_cuti`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 25000.00, 30000.00, 0.00, 100000.00, 0.00, '2025-12-22 03:43:53', '2025-12-22 03:43:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id`, `karyawan_id`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-01-05', '2026-01-05', 'sakit', 'Disetujui', NULL, NULL, '2026-01-05 01:46:00', '2026-01-05 01:46:56'),
(2, 2, '2026-02-10', '2026-02-11', 'sakit', 'Ditolak', NULL, NULL, '2026-02-09 02:15:59', '2026-02-09 02:16:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

CREATE TABLE `departemen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_departemen` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`id`, `nama_departemen`, `created_at`, `updated_at`) VALUES
(1, 'IT', '2025-12-22 03:43:52', '2025-12-22 03:43:52'),
(2, 'HRD', '2025-12-22 03:43:52', '2025-12-22 03:43:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `gaji_pokok`, `tunjangan`, `created_at`, `updated_at`) VALUES
(1, 'Staff Karyawan', 4000000.00, 400000.00, '2025-12-22 03:43:52', '2026-02-11 01:35:36'),
(3, 'Staff HRD', 10000000.00, 2000000.00, '2026-02-11 01:31:18', '2026-02-11 01:31:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `departemen_id` bigint(20) UNSIGNED NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status` enum('Tetap','Kontrak','Magang') NOT NULL DEFAULT 'Kontrak',
  `no_hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nip`, `nama`, `jabatan_id`, `departemen_id`, `tgl_masuk`, `status`, `no_hp`, `email`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(2, '0987654322', 'Karla', 1, 1, '2025-12-22', 'Tetap', '083131', 'mnurfildan27@gmail.com', 'Bandung', NULL, '2025-12-22 07:49:28', '2025-12-22 07:49:28'),
(3, '3333331', 'HRD', 3, 2, '2026-02-11', 'Tetap', '000000', 'HRD@gmail.com', 'Bandung', 'C:\\xampp\\tmp\\phpD.tmp', '2026-02-11 01:49:14', '2026-02-11 01:49:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan_shift`
--

CREATE TABLE `karyawan_shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawan_shift`
--

INSERT INTO `karyawan_shift` (`id`, `karyawan_id`, `shift_id`, `tanggal`, `created_at`, `updated_at`) VALUES
(2, 2, 2, '2025-12-01', '2025-12-30 03:06:16', '2025-12-30 03:06:16'),
(3, 2, 1, '2025-12-30', '2025-12-30 05:53:16', '2025-12-30 05:55:44'),
(4, 2, 1, '2026-01-05', '2026-01-05 01:50:30', '2026-01-05 01:50:30'),
(6, 2, 1, '2026-01-14', '2026-01-14 02:50:30', '2026-01-14 02:50:30'),
(8, 2, 1, '2026-02-09', '2026-02-09 02:14:35', '2026-02-09 02:14:35'),
(9, 2, 1, '2026-02-08', '2026-02-19 02:42:30', '2026-02-19 02:42:30'),
(10, 2, 1, '2026-02-19', '2026-02-19 02:42:31', '2026-02-19 02:47:30'),
(11, 2, 1, '2026-02-08', '2026-02-19 02:47:30', '2026-02-19 02:47:30'),
(12, 2, 1, '2026-02-07', '2026-02-19 02:47:30', '2026-02-19 02:47:30'),
(13, 2, 2, '2026-02-18', '2026-02-19 02:47:30', '2026-02-19 02:47:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_11_13_013951_create_jabatan_table', 1),
(4, '2025_11_13_014017_create_departemen_table', 1),
(5, '2025_11_13_014034_create_karyawan_table', 1),
(6, '2025_11_13_014035_create_users_table', 1),
(7, '2025_11_13_014057_create_shift_table', 1),
(8, '2025_11_13_014110_create_karyawan_shift_table', 1),
(9, '2025_11_13_015005_create_absensi_table', 1),
(10, '2025_11_13_015015_create_cuti_table', 1),
(11, '2025_11_13_015027_create_penggajian_table', 1),
(12, '2025_11_13_015042_create_potongan_table', 1),
(13, '2025_12_15_114116_create_aturan_potongan_jabatan_table', 1),
(14, '2026_02_09_100905_add_audit_columns_to_absensi_table', 2),
(15, '2026_02_09_100945_add_approval_columns_to_cuti_table', 2),
(16, '2026_02_09_101003_create_settings_table', 2),
(17, '2026_02_09_101021_add_snapshot_columns_to_penggajian_table', 2),
(18, '2026_02_18_093011_drop_potongan_tambahan_from_penggajian_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggajian`
--

CREATE TABLE `penggajian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_karyawan` varchar(255) DEFAULT NULL,
  `nama_jabatan` varchar(255) DEFAULT NULL,
  `periode` varchar(255) NOT NULL,
  `tanggal_penggajian` date NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan_otomatis` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_gaji` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_pembayaran` enum('Belum Dibayar','Sudah Dibayar') NOT NULL DEFAULT 'Belum Dibayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penggajian`
--

INSERT INTO `penggajian` (`id`, `karyawan_id`, `nama_karyawan`, `nama_jabatan`, `periode`, `tanggal_penggajian`, `gaji_pokok`, `tunjangan`, `potongan_otomatis`, `total_gaji`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(3, 2, NULL, NULL, '2025-12', '2025-12-30', 3000000.00, 500000.00, 25000.00, 3475000.00, 'Belum Dibayar', '2025-12-22 07:49:42', '2025-12-30 06:29:15'),
(5, 2, NULL, NULL, '2025-03', '2025-12-22', 3000000.00, 500000.00, 0.00, 3500000.00, 'Belum Dibayar', '2025-12-22 07:49:50', '2025-12-22 07:49:50'),
(7, 2, NULL, NULL, '2025-11', '2025-12-30', 3000000.00, 500000.00, 0.00, 3500000.00, 'Belum Dibayar', '2025-12-30 01:57:52', '2025-12-30 01:57:52'),
(9, 2, NULL, NULL, '2026-02', '2026-02-09', 3000000.00, 500000.00, 25000.00, 3475000.00, 'Belum Dibayar', '2026-02-09 02:18:31', '2026-02-09 02:18:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `potongan`
--

CREATE TABLE `potongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penggajian_id` bigint(20) UNSIGNED NOT NULL,
  `nama_potongan` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8KBQhKqeXxZtLP4D807MxJL45JGmfnnmVyGi0saZ', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnpJamEwa3VDaEh2Y2tBcGFTYlhaalYxWkNSTk55ZFZlVWxVaVpHNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hYnNlbnNpIjtzOjU6InJvdXRlIjtzOjEzOiJhYnNlbnNpLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1771489084),
('F7ls6cnjTpL0QiO9vfVNgejTkvczSB4mn5MYY4fU', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZW1CRFhUOHhNQ2ZPazhodUVSQnNjTkNPNTk0MUpodXFRMDUzZmN5bSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXJ5YXdhbi9jcmVhdGUiO3M6NToicm91dGUiO3M6MTU6Imthcnlhd2FuLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1771557560),
('iN8FiXvLmSY0GO8ipWReKvsZnAR4fAgCfGUBIMqT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibVRYaXhDT1pNbHAxTzM3SHJRM0lISzF5aFhGRnE0VHdHVXZFandQbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771573274);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_shift` varchar(255) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id`, `nama_shift`, `jam_mulai`, `jam_selesai`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Shift Pagi', '08:00:00', '16:00:00', NULL, '2025-12-22 03:43:53', '2025-12-22 03:43:53'),
(2, 'Shift Siang', '16:00:00', '00:00:00', NULL, '2025-12-22 03:43:53', '2025-12-22 03:43:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','HRD','Karyawan') NOT NULL DEFAULT 'Karyawan',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `karyawan_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin', 'admin@gmail.com', NULL, '$2y$12$7RBNhOM1okmUhCfExJsaQOCDXlht5VPSWMcxw2W.c7ioB4p0M5IkK', 'Admin', NULL, '2025-12-22 03:43:53', '2025-12-22 03:43:53'),
(3, 2, 'Karyawan', 'karyawan@gmail.com', NULL, '$2y$12$PnlNZhHpx6TFxIFZxTP.XOHS4Q3yCAwttMv6Tr4aOoxLpAqhEQ/52', 'Karyawan', NULL, '2025-12-22 03:43:53', '2025-12-22 03:43:53'),
(4, 3, 'HRD', 'HRD@gmail.com', NULL, '$2y$12$fkeu7zXnJMrFw6Szn/ZkCe.JS50jez5xWU8rArSm8kGuXrSw72nze', 'HRD', NULL, '2026-02-11 01:46:28', '2026-02-11 01:50:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_karyawan_id_tanggal_unique` (`karyawan_id`,`tanggal`),
  ADD KEY `absensi_shift_id_foreign` (`shift_id`),
  ADD KEY `absensi_updated_by_foreign` (`updated_by`);

--
-- Indeks untuk tabel `aturan_potongan_jabatan`
--
ALTER TABLE `aturan_potongan_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aturan_potongan_jabatan_jabatan_id_unique` (`jabatan_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `cuti_approved_by_foreign` (`approved_by`);

--
-- Indeks untuk tabel `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_nip_unique` (`nip`),
  ADD KEY `karyawan_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `karyawan_departemen_id_foreign` (`departemen_id`);

--
-- Indeks untuk tabel `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_shift_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `karyawan_shift_shift_id_foreign` (`shift_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penggajian_karyawan_id_foreign` (`karyawan_id`);

--
-- Indeks untuk tabel `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `potongan_penggajian_id_foreign` (`penggajian_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_karyawan_id_foreign` (`karyawan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `aturan_potongan_jabatan`
--
ALTER TABLE `aturan_potongan_jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `aturan_potongan_jabatan`
--
ALTER TABLE `aturan_potongan_jabatan`
  ADD CONSTRAINT `aturan_potongan_jabatan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cuti_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_departemen_id_foreign` FOREIGN KEY (`departemen_id`) REFERENCES `departemen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  ADD CONSTRAINT `karyawan_shift_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawan_shift_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `potongan`
--
ALTER TABLE `potongan`
  ADD CONSTRAINT `potongan_penggajian_id_foreign` FOREIGN KEY (`penggajian_id`) REFERENCES `penggajian` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
