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