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

$superAdmin = new SuperAdmin();
$id = $_GET['id'] ?? 0;
$error = '';
$user_data = null;

if ($id) {
    $result = $superAdmin->getUserById($id);
    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        $error = 'User tidak ditemukan!';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $is_super_admin = $_POST['is_super_admin'] ?? 0;

    if ($id) {
        try {
            if ($is_super_admin == 1) {
                $superAdmin->changeUserToSuperAdmin($id);
            } else {
                $superAdmin->changeUserToUser($id);
            }
            header('Location: manajemen-user.php?success=1');
            exit;
        } catch (Exception $e) {
            $error = 'Gagal mengubah role user: ' . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User - KyKos</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/KyKos_logo_noBg.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
                                    <h3 class="card-title">EDIT USER</h3>

                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($user_data) { ?>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $user_data['id']; ?>">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    value="<?php echo htmlspecialchars($user_data['username']); ?>"
                                                    disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="is_super_admin" class="form-label">Role</label>
                                                <select class="form-control" id="is_super_admin" name="is_super_admin"
                                                    required>
                                                    <option value="0" <?php echo ($user_data['is_super_admin'] == 0) ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="1" <?php echo ($user_data['is_super_admin'] == 1) ? 'selected' : ''; ?>>Super Admin</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="manajemen-user.php" class="btn btn-secondary">Kembali</a>
                                        </form>
                                    <?php } else { ?>
                                        <p>User tidak ditemukan.</p>
                                        <a href="manajemen-user.php" class="btn btn-secondary">Kembali</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/sidebarmenu.js"></script>
        <script src="../assets/js/app.min.js"></script>
    </div>
</body>

</html>