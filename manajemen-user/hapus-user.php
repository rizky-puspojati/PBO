<?php
require_once "../model/user.php";

// Cek apakah user sudah login dan super admin
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    die("Akses ditolak! Hanya Super Admin yang bisa mengakses fitur ini.");
}

$id = $_GET['id'] ?? 0;

if ($id) {
    $superAdmin = new SuperAdmin();
    try {
        $superAdmin->deleteUser($id);
        header('Location: manajemen-user.php?success=1');
        exit;
    } catch (Exception $e) {
        die("Gagal menghapus user: " . $e->getMessage());
    }
} else {
    header('Location: manajemen-user.php');
    exit;
}
?>