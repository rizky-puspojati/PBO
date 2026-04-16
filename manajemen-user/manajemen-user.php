<?php
require_once "../model/user.php";

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: ../login.php');
    exit;
}

// Cek apakah user adalah super admin
if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    die("Akses ditolak! Hanya Super Admin yang bisa mengakses fitur ini.");
}

$superAdmin = new SuperAdmin();
$users = $superAdmin->getAllUsers();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - KyKos</title>
    <link rel="shortcut icon" type="image/png" href="/WEB%20PBO/KyKos/assets/images/logos/KyKos_logo_noBg.png" />
    <link rel="stylesheet" href="/WEB%20PBO/KyKos/assets/css/styles.min.css" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  App Topstrip -->
        <?php include '../navbar/navbar.php' ?>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <!--  Row 1 -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-md-flex align-items-center">
                                        <div>
                                            <h3 class="card-title">MANAJEMEN USER KY KOS</h3>
                                        </div>
                                        <div class="ms-auto mt-3 mt-md-0">
                                            <a href="tambah-user.php" class="btn btn-success">Tambah User</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Username</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                if (!empty($users)) {
                                                    foreach ($users as $user) { ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $no++; ?></th>
                                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                                            <td>
                                                                <?php echo ($user['is_super_admin'] == 1) ? '<span class="badge bg-danger">Super Admin</span>' : '<span class="badge bg-info">Admin</span>'; ?>
                                                            </td>
                                                            <td>
                                                                <a href="edit-user.php?id=<?php echo $user['id']; ?>"
                                                                    class="btn btn-warning btn-sm">Edit</a>
                                                                <a href="hapus-user.php?id=<?php echo $user['id']; ?>"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data user</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/WEB%20PBO/KyKos/assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="/WEB%20PBO/KyKos/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/WEB%20PBO/KyKos/assets/js/sidebarmenu.js"></script>
        <script src="/WEB%20PBO/KyKos/assets/js/app.min.js"></script>
    </div>
</body>

</html>