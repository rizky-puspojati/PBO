<?php
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class User extends Database
{
    public function login($username, $password)
    {
        $username = trim((string) $username);
        $password = trim((string) $password);
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {

                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_super_admin'] = $user['is_super_admin'];
                header('Location: /WEB%20PBO/KyKos/login.php');
                exit;
            }
        }
        $_SESSION['login_error'] = 'Username atau password salah.';
        header('Location: /WEB%20PBO/KyKos/login.php');
        exit;

    }
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /WEB%20PBO/KyKos/login.php');
        exit;
    }
    public function canAccess(string $halaman): bool
    {
        $allowed = ['index', 'laporan-keuangan', 'data-kamar', 'status-pembayaran'];
        return in_array($halaman, $allowed);
    }
}

class SuperAdmin extends User
{
    public function __construct()
    {
        parent::__construct();
        if (isset($_SESSION['is_super_admin']) && !$_SESSION['is_super_admin']) {
            throw new Exception("Akses Ditolak: Class ini hanya untuk Super Admin.");
        }
    }
    public function addUser($username, $password)
    {
        $username = trim((string) $username);
        $password = trim((string) $password);
        $pass = password_hash($password, PASSWORD_DEFAULT);
        return $this->runQuery("
            INSERT INTO users(username, password, is_super_admin)
            VALUES ('$username', '$pass', 0)
        ", "Username sudah digunakan atau error");
    }
    public function deleteUser($id)
    {
        $id = (int) $id;
        return $this->runQuery("
            DELETE FROM users WHERE id = $id
        ", "Gagal menghapus user");
    }
    public function changeUserToSuperAdmin($id)
    {
        $id = (int) $id;
        return $this->runQuery("
            UPDATE users SET is_super_admin = 1 WHERE id = $id
        ", "Gagal mengubah role user");
    }
    public function changeUserToUser($id)
    {
        $id = (int) $id;
        return $this->runQuery("
            UPDATE users SET is_super_admin = 0 WHERE id = $id
        ", "Gagal mengubah role user");
    }
    public function getAllUsers(): array
    {
        $result = $this->runQuery("SELECT id, username, is_super_admin FROM users ORDER BY id ASC", "Gagal mengambil data user");
        if (!$result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getUserById($id)
    {
        $id = (int) $id;
        return $this->runQuery("SELECT id, username, is_super_admin FROM users WHERE id = $id", "Gagal mengambil data user");
    }
    public function updateUser($id, $username, $is_super_admin)
    {
        $id = (int) $id;
        $username = trim((string) $username);
        $is_super_admin = (int) $is_super_admin;
        return $this->runQuery("
            UPDATE users SET username = '$username', is_super_admin = $is_super_admin WHERE id = $id
        ", "Gagal mengubah data user");
    }
    public function canAccess(string $halaman): bool
    {
        $superOnly = ['index', 'laporan-keuangan', 'data-kamar', 'status-pembayaran', 'manajemen-user'];
        if (in_array($halaman, $superOnly))
            return true;
        return parent::canAccess($halaman);
    }
}

$user;

try {
    $user = new SuperAdmin();
} catch (Exception $e) {
    $user = new User();
}
?>