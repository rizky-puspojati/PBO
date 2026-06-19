<?php
require_once 'config.php';

$db = new Database();

// Buat tabel users
$createUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_super_admin INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

// Buat tabel kamar
$createKamarTable = "
CREATE TABLE IF NOT EXISTS kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kamar VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    status ENUM('Tersedia', 'Tidak Tersedia') DEFAULT 'Tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

try {
    $db->conn->query($createUsersTable);
    echo "Tabel users berhasil dibuat atau sudah ada.<br>";

    $db->conn->query($createKamarTable);
    echo "Tabel kamar berhasil dibuat atau sudah ada.<br>";

    // Update schema kamar jika belum ada kolom baru
    $checkCols = $db->conn->query("SHOW COLUMNS FROM `kamar` LIKE 'tipe_kamar'");
    if ($checkCols->num_rows == 0) {
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `tipe_kamar` VARCHAR(50) DEFAULT 'Standard'");
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `ukuran` VARCHAR(50) DEFAULT '3x4'");
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `tipe_kasur` VARCHAR(50) DEFAULT 'Single'");
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `fasilitas` VARCHAR(255) DEFAULT 'Kipas Angin, Kasur'");
        echo "Kolom spesifikasi kamar berhasil ditambahkan ke tabel kamar.<br>";
    }

    // Update schema kamar untuk data penyewa dan pembayaran jika belum ada
    $checkCols2 = $db->conn->query("SHOW COLUMNS FROM `kamar` LIKE 'status_pembayaran'");
    if ($checkCols2->num_rows == 0) {
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `nama_penyewa` VARCHAR(255) DEFAULT '-'");
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `prioritas` VARCHAR(50) DEFAULT 'Low'");
        $db->conn->query("ALTER TABLE `kamar` ADD COLUMN `status_pembayaran` VARCHAR(50) DEFAULT 'Belum Bayar'");
        echo "Kolom status pembayaran & penyewa berhasil ditambahkan.<br>";

        // Seed some demo tenant data to match original mockup
        $db->conn->query("UPDATE `kamar` SET nama_penyewa='Christopher Nolan', prioritas='High', status_pembayaran='Sudah Bayar', status='Terisi' WHERE id=1 OR nama_kamar LIKE '%Melati%'");
        $db->conn->query("UPDATE `kamar` SET nama_penyewa='Udin Pecok', prioritas='Low', status_pembayaran='Sudah Bayar', status='Terisi' WHERE id=2 OR nama_kamar LIKE '%Mawar%'");
        $db->conn->query("UPDATE `kamar` SET nama_penyewa='Christopher Usop', prioritas='Medium', status_pembayaran='Belum Bayar', status='Terisi' WHERE id=3 OR nama_kamar LIKE '%Anggrek%'");
        echo "Data simulasi penyewa & pembayaran berhasil ditautkan.<br>";
    }

    // Cek apakah sudah ada super admin default
    $checkAdmin = $db->conn->query("SELECT COUNT(*) as count FROM users WHERE is_super_admin = 1");
    $row = $checkAdmin->fetch_assoc();

    if ($row['count'] == 0) {
        // Buat super admin default
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $db->conn->query("INSERT INTO users (username, password, is_super_admin) VALUES ('admin', '$defaultPassword', 1)");
        echo "Super Admin default berhasil dibuat (Username: admin, Password: admin123).<br>";
    }

    echo "<h3>Database setup selesai!</h3>";
    echo "<a href='login.php'>Klik di sini untuk login</a>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>