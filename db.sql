-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_ayp
-- CREATE DATABASE IF NOT EXISTS `db_ayp` /*!40100 DEFAULT CHARACTER SET latin1 */;
-- USE `db_ayp`;

-- Dumping structure for table db_ayp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.migrations: ~11 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(3, '2023_12_04_140458_create_m_kabupaten_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(4, '2023_12_04_140549_create_m_kecamatan_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(5, '2023_12_04_140630_create_m_desa_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(6, '2023_12_04_140801_create_m_tps_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(7, '2023_12_04_140916_create_m_partai_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(8, '2023_12_04_141136_create_m_kandidat_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(9, '2023_12_04_141556_create_t_pemilih_pasti_table', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(10, '2023_12_04_141944_create_t_suara_tps_table', 9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(12, '2023_12_08_184712_add_column_status_in_t_suara_tps_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(13, '2023_12_10_124459_add_column_jumlah_pemilih_t_suara_tps_table', 11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_desa
CREATE TABLE IF NOT EXISTS `m_desa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint(20) NOT NULL,
  `id_kecamatan` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_data` (`id_kabupaten`,`id_kecamatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_desa: ~0 rows (approximately)
DELETE FROM `m_desa`;
/*!40000 ALTER TABLE `m_desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_desa` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_kabupaten
CREATE TABLE IF NOT EXISTS `m_kabupaten` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_kabupaten: ~0 rows (approximately)
DELETE FROM `m_kabupaten`;
/*!40000 ALTER TABLE `m_kabupaten` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_kabupaten` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_kandidat
CREATE TABLE IF NOT EXISTS `m_kandidat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_partai` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('caleg','lawan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_partai` (`id_partai`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_kandidat: ~1 rows (approximately)
DELETE FROM `m_kandidat`;
/*!40000 ALTER TABLE `m_kandidat` DISABLE KEYS */;
INSERT INTO `m_kandidat` (`id`, `id_partai`, `nama`, `kategori`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Dr. Ir. Hj. Andi Yuliani Paris', 'caleg', '2023-12-05 04:51:19', '2023-12-05 04:54:05');
/*!40000 ALTER TABLE `m_kandidat` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_kecamatan
CREATE TABLE IF NOT EXISTS `m_kecamatan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kabupaten` (`id_kabupaten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_kecamatan: ~0 rows (approximately)
DELETE FROM `m_kecamatan`;
/*!40000 ALTER TABLE `m_kecamatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_kecamatan` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_partai
CREATE TABLE IF NOT EXISTS `m_partai` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_partai: ~2 rows (approximately)
DELETE FROM `m_partai`;
/*!40000 ALTER TABLE `m_partai` DISABLE KEYS */;
INSERT INTO `m_partai` (`id`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'PAN', 'Partai Amanat Nasional', '2023-12-04 22:36:55', NULL);
/*!40000 ALTER TABLE `m_partai` ENABLE KEYS */;

-- Dumping structure for table db_ayp.m_tps
CREATE TABLE IF NOT EXISTS `m_tps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint(20) NOT NULL,
  `id_kecamatan` bigint(20) NOT NULL,
  `id_desa` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_data` (`id_kabupaten`,`id_kecamatan`,`id_desa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.m_tps: ~0 rows (approximately)
DELETE FROM `m_tps`;
/*!40000 ALTER TABLE `m_tps` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_tps` ENABLE KEYS */;

-- Dumping structure for table db_ayp.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table db_ayp.t_pemilih_pasti
CREATE TABLE IF NOT EXISTS `t_pemilih_pasti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint(20) NOT NULL,
  `id_kecamatan` bigint(20) NOT NULL,
  `id_desa` bigint(20) NOT NULL,
  `id_tps` bigint(20) NOT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `t_pemilih_pasti_no_ktp_unique` (`no_ktp`),
  KEY `t_pemilih_pasti_id_kabupaten_index` (`id_kabupaten`),
  KEY `t_pemilih_pasti_id_kecamatan_index` (`id_kecamatan`),
  KEY `t_pemilih_pasti_id_desa_index` (`id_desa`),
  KEY `t_pemilih_pasti_id_tps_index` (`id_tps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.t_pemilih_pasti: ~0 rows (approximately)
DELETE FROM `t_pemilih_pasti`;
/*!40000 ALTER TABLE `t_pemilih_pasti` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_pemilih_pasti` ENABLE KEYS */;

-- Dumping structure for table db_ayp.t_suara_tps
CREATE TABLE IF NOT EXISTS `t_suara_tps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kabupaten` bigint(20) NOT NULL,
  `id_kecamatan` bigint(20) NOT NULL,
  `id_desa` bigint(20) NOT NULL,
  `id_tps` bigint(20) NOT NULL,
  `id_kandidat` bigint(20) NOT NULL,
  `total_suara` int(11) NOT NULL,
  `jumlah_pemilih` int(11) NOT NULL DEFAULT '0',
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('waiting','valid','invalid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_kabupaten_id_kecamatan_id_desa_id_tps_id_kandidat` (`id_kabupaten`,`id_kecamatan`,`id_desa`,`id_tps`,`id_kandidat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.t_suara_tps: ~0 rows (approximately)
DELETE FROM `t_suara_tps`;
/*!40000 ALTER TABLE `t_suara_tps` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_suara_tps` ENABLE KEYS */;

-- Dumping structure for table db_ayp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('admin','kabupaten','kecamatan','desa','tps') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `no_ktp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kabupaten` bigint(20) NOT NULL DEFAULT '0',
  `id_kecamatan` bigint(20) NOT NULL DEFAULT '0',
  `id_desa` bigint(20) NOT NULL DEFAULT '0',
  `id_tps` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_ayp.users: ~6 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `nama`, `username`, `password`, `level`, `no_ktp`, `alamat`, `id_kabupaten`, `id_kecamatan`, `id_desa`, `id_tps`, `created_at`, `updated_at`) VALUES
	(1, 'Syaiful Bahar', 'iful', '$2y$12$KTBdGYtQOJx9OkMS9jmbTeNXC3YA224U2DLVQGMAalq7qptWR1I.2', 'admin', '1234567890123456', 'Panjallingan', 0, 0, 0, 0, '2023-12-05 04:21:47', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
