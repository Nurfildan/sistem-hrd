-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 09:27 AM
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
-- Database: `sistem_hrd`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status` enum('Hadir','Terlambat','Izin','Sakit','Alpa','Cuti') NOT NULL DEFAULT 'Hadir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `karyawan_id`, `shift_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-11-24', '13:23:29', '13:23:35', 'Terlambat', '2025-11-24 06:23:29', '2025-11-24 06:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `karyawan_id`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-11-24', '2025-11-26', 'Hamil', 'Ditolak', '2025-11-24 02:13:50', '2025-11-24 06:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_departemen` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama_departemen`, `created_at`, `updated_at`) VALUES
(1, 'Produksi', '2025-11-24 01:23:55', '2025-11-24 01:23:55'),
(2, 'Keuangan', '2025-11-24 01:24:40', '2025-11-24 01:24:40'),
(3, 'IT Development', '2025-11-24 01:36:49', '2025-11-24 01:36:49'),
(4, 'IT Support / Helpdesk', '2025-11-24 01:36:58', '2025-11-24 01:36:58'),
(5, 'Product Management', '2025-11-24 01:37:08', '2025-11-24 01:37:08'),
(6, 'Network & Infrastructure', '2025-11-24 01:37:19', '2025-11-24 01:37:19'),
(7, 'Human Resource (HR)', '2025-11-24 01:37:28', '2025-11-24 01:37:28');

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
-- Table structure for table `jabatan`
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
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `gaji_pokok`, `tunjangan`, `created_at`, `updated_at`) VALUES
(3, 'Frontend Developer', 5000000.00, 1000000.00, '2025-11-24 01:34:13', '2025-11-24 06:10:30'),
(4, 'Backend Developer', 5000000.00, 1500000.00, '2025-11-24 01:34:36', '2025-11-24 01:34:36'),
(5, 'Fullstack Developer', 8000000.00, 2000000.00, '2025-11-24 01:35:01', '2025-11-24 01:35:01'),
(6, 'UI/UX Designer', 5000000.00, 1000000.00, '2025-11-24 01:35:28', '2025-11-24 01:35:28'),
(7, 'Product Manager', 9000000.00, 2500000.00, '2025-11-24 01:36:04', '2025-11-24 01:36:04');

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
-- Table structure for table `karyawan`
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
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nip`, `nama`, `jabatan_id`, `departemen_id`, `tgl_masuk`, `status`, `no_hp`, `email`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(2, '19870101', 'Ahmad Syahroni', 7, 7, '1900-01-01', 'Tetap', '081234567801', 'ahmad@example.com', 'Jl. Melati No. 12, Bandung', '1763965509_IMG-20250803-WA0027.jpg', '2025-11-24 01:38:30', '2025-11-24 06:25:09'),
(3, '19870102', 'Adly Febryan', 5, 3, '2025-11-24', 'Kontrak', '085607360137', 'adlyfebryan0@gmail.com', 'Jl. Manchester No. 55, United', '1763965524_IMG-20250701-WA0036.jpg', '2025-11-24 01:39:33', '2025-11-24 06:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan_shift`
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
-- Dumping data for table `karyawan_shift`
--

INSERT INTO `karyawan_shift` (`id`, `karyawan_id`, `shift_id`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-11-24', '2025-11-24 01:41:49', '2025-11-24 01:41:49');

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
(13, '2025_11_21_162247_create_sessions_table', 2);

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
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tanggal_penggajian` date NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tunjangan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `potongan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_gaji` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_pembayaran` enum('Belum Dibayar','Sudah Dibayar') NOT NULL DEFAULT 'Belum Dibayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penggajian`
--

INSERT INTO `penggajian` (`id`, `karyawan_id`, `bulan`, `tanggal_penggajian`, `gaji_pokok`, `tunjangan`, `potongan`, `total_gaji`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-02', '2025-11-24', 8000000.00, 2000000.00, 0.00, 10000000.00, 'Belum Dibayar', '2025-11-24 01:43:09', '2025-11-24 01:43:09'),
(2, 2, '2025-07', '2025-11-24', 9000000.00, 2500000.00, 0.00, 11500000.00, 'Belum Dibayar', '2025-11-24 06:33:35', '2025-11-24 06:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE `potongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_potongan` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bulan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `potongan`
--

INSERT INTO `potongan` (`id`, `karyawan_id`, `nama_potongan`, `jumlah`, `bulan`, `created_at`, `updated_at`) VALUES
(1, 2, 'Potongan Absensi & Cuti', 0.00, '11-2025', '2025-11-24 01:43:23', '2025-11-24 07:09:56'),
(2, 3, 'Potongan Absensi & Cuti', 0.00, '11-2025', '2025-11-24 01:43:23', '2025-11-24 07:09:56');

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
('6PyuKpZ47kYpmRLd0DAihwpaTqBbZaKRnJt0BRkO', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRmxYcm12WnpBdzZYWWVBTnVIWXAxTVV5REhiRWk1Zlg3N2lJc0ZJUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXRpIjtzOjU6InJvdXRlIjtzOjEwOiJjdXRpLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1764574597);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
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
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `nama_shift`, `jam_mulai`, `jam_selesai`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Shift Pagi', '08:00:00', '12:00:00', 'Harap Datang Sesuai Jadwal', '2025-11-24 01:41:20', '2025-11-24 01:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `karyawan_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'admin@gmail.com', NULL, '$2y$12$aw4E5DN4oZiS/SFCZFTJTuKR7o/4Hql3aAaHFPS2ebpsTF7aiZYfC', 'Admin', NULL, '2025-11-24 01:12:55', '2025-11-24 01:20:34'),
(2, NULL, 'HRD', 'HRD@gmail.com', NULL, '$2y$12$qq8w3.8k..d7nivhrGEKheGGYzYPpg7JCzR4lBi6F70BljSUhvTzu', 'HRD', NULL, '2025-11-24 01:21:54', '2025-11-24 01:21:54'),
(3, 3, 'Adly Febryan', 'adlyfebryan0@gmail.com', NULL, '$2y$12$94fVadEicYKurrDViqNfguO6I74lv2wImoFpZ.PfLz2wySiRa3yJ6', 'Karyawan', NULL, '2025-11-24 02:12:38', '2025-11-24 06:04:54'),
(4, 2, 'karyawan', 'karyawan@gmail.com', NULL, '$2y$12$8ewmxOfzCAu89uBr/vTQ3uUApeCYYeGBvLPxEKAPU0XTIM2h0vtD.', 'Karyawan', NULL, '2025-11-24 06:18:23', '2025-11-24 06:18:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_karyawan_id_tanggal_unique` (`karyawan_id`,`tanggal`),
  ADD KEY `absensi_shift_id_foreign` (`shift_id`);

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
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_nip_unique` (`nip`),
  ADD KEY `karyawan_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `karyawan_departemen_id_foreign` (`departemen_id`);

--
-- Indexes for table `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_shift_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `karyawan_shift_shift_id_foreign` (`shift_id`);

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
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penggajian_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `potongan_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_karyawan_id_foreign` (`karyawan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_departemen_id_foreign` FOREIGN KEY (`departemen_id`) REFERENCES `departemen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan_shift`
--
ALTER TABLE `karyawan_shift`
  ADD CONSTRAINT `karyawan_shift_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawan_shift_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `potongan`
--
ALTER TABLE `potongan`
  ADD CONSTRAINT `potongan_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
