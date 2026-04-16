-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table kykos.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `Password`, `nama`, `email`, `nomor_telp`, `is_super_admin`) VALUES
	(1, '123', 'Rizky', 'rizky@gmail.com', '08120192357', 0);

-- Dumping data for table kykos.anggotakos: ~0 rows (approximately)

-- Dumping data for table kykos.kamar: ~10 rows (approximately)
INSERT INTO `kamar` (`id`, `nama_kamar`, `harga`, `status`) VALUES
	(1, 'Kamar Melati', 400000.00, 'Tersedia'),
	(2, 'Kamar Mawar', 700000.00, 'Tersedia'),
	(3, 'Kamar Anggrek', 600000.00, 'Tersedia'),
	(4, 'Kamar Kenanga', 600000.00, 'Tersedia'),
	(5, 'Kamar Dahlia', 750000.00, 'Tersedia'),
	(6, 'Kamar Flamboyan', 750000.00, 'Tersedia'),
	(7, 'Kamar Bougenville', 800000.00, 'Terisi'),
	(8, 'Kamar Teratai', 800000.00, 'Terisi'),
	(9, 'Kamar Eksekutif A', 1200000.00, 'Terisi'),
	(10, 'Kamar Eksekutif B', 1100000.00, 'Tersedia');

-- Dumping data for table kykos.pendaftarkos: ~0 rows (approximately)

-- Dumping data for table kykos.transaksi: ~3 rows (approximately)
INSERT INTO `transaksi` (`id`, `id_kamar`, `tanggal_pembayaran`, `jumlah_bayar`) VALUES
	(1, 1, '2026-04-14', 800000.00),
	(2, 2, '2026-04-14', 1200000.00),
	(3, 3, '2026-04-14', 800000.00);

-- Dumping data for table kykos.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `is_super_admin`, `created_at`) VALUES
	(1, 'admin', '$2y$10$KywPYOFihEczLGqHIvAqnOxiztBiYLxoF1fM5UDYFxqcxhK9/d.6K', 1, '2026-04-14 13:03:34'),
	(3, 'Rizky Puspojati', '$2y$10$.H0vVRzK3PYf64LBGTgM5OddMVE1otLowDto3SPV7oPXQbZXq1/p6', 0, '2026-04-15 08:30:35');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
