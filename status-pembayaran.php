<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

require_once "model/model-kamar.php";
$kamarModel = new Kamar();

// Handle update status pembayaran dari request
if (isset($_GET['action']) && $_GET['action'] == 'update_status') {
    $id = (int)$_GET['id'];
    $status = $_GET['status']; // 'Sudah Bayar' atau 'Belum Bayar'
    if ($kamarModel->updateStatusPembayaran($id, $status)) {
        header("Location: status-pembayaran.php");
        exit;
    }
}

$data = $kamarModel->tampil();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pembayaran - KyKos</title>
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/KyKos_logo_noBg.png" />
    <link rel="stylesheet" href="./assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  App Topstrip -->
        <?php include 'navbar/navbar.php' ?>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <!--  Row 1 -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card overflow-hidden"></div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center ">
                                    <div>
                                        <h3 class="card-title">STATUS PEMBAYARAN KY KOS</h3>
                                    </div>
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <select class="form-select theme-select border-0" aria-label="Default select example">
                                            <option value="1">Aktif Saat Ini</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-0 text-muted">Pendaftar</th>
                                                <th scope="col" class="px-0 text-muted">Harga Kamar</th>
                                                <th scope="col" class="px-0 text-muted text-center">Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $has_tenants = false;
                                            $profile_images = ['./assets/images/profile/user-3.jpg', './assets/images/profile/user-4.jpg', './assets/images/profile/user-5.jpg', './assets/images/profile/user-6.jpg'];
                                            $img_idx = 0;
                                            
                                            if ($data && $data->num_rows > 0) {
                                                while ($row = $data->fetch_assoc()) { 
                                                    if (!empty($row['nama_penyewa']) && $row['nama_penyewa'] != '-') {
                                                        $has_tenants = true;
                                                        $p_img = $profile_images[$img_idx % count($profile_images)];
                                                        $img_idx++;

                                            ?>
                                                        <tr>
                                                            <td class="px-0">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="<?php echo $p_img; ?>" class="rounded-circle" width="40" alt="profile" />
                                                                    <div class="ms-3">
                                                                        <h6 class="mb-0 fw-bolder"><?php echo htmlspecialchars($row['nama_penyewa']); ?></h6>
                                                                        <span class="text-muted"><?php echo htmlspecialchars($row['nama_kamar']); ?></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-0">
                                                                <b>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></b>
                                                            </td>
                                                            <td class="px-0 text-dark fw-medium text-center">
                                                                <div class="dropdown">
                                                                    <?php 
                                                                    $btn_color = ($row['status_pembayaran'] == 'Sudah Bayar') ? 'bg-success' : 'bg-danger';
                                                                    $btn_text = ($row['status_pembayaran'] == 'Sudah Bayar') ? 'Sudah Bayar' : 'Belum Bayar';
                                                                    ?>
                                                                    <button class="btn badge <?php echo $btn_color; ?> dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                        <?php echo $btn_text; ?>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#" data-value="Sudah Bayar" data-id="<?php echo $row['id']; ?>">Sudah Bayar</a></li>
                                                                        <li><a class="dropdown-item" href="#" data-value="Belum Bayar" data-id="<?php echo $row['id']; ?>">Belum Bayar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                            <?php 
                                                    }
                                                } 
                                            }
                                            if (!$has_tenants) {
                                                echo '<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada penghuni aktif saat ini.</td></tr>';
                                            }
                                            ?>
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

    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/js/app.min.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="./assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <script>
        document.querySelectorAll('.dropdown-item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const nilai = this.getAttribute('data-value');
                const id = this.getAttribute('data-id');
                // Arahkan ke URL dengan parameter action untuk melakukan update ke database
                window.location.href = 'status-pembayaran.php?action=update_status&id=' + id + '&status=' + encodeURIComponent(nilai);
            });
        });
    </script>
</body>

</html>