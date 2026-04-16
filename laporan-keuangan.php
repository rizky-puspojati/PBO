<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: login.php');
    exit;
}

require_once "model/model-laporan.php";
require_once "model/model-kamar.php";
require_once "model/model-admin.php";
require_once "model/model.php";
require_once "config.php";

$laporan = new Laporan();
$totalPenghasilan = $laporan->totalPenghasilan();
$jumlahTersedia = $laporan->jumlahKamarTersedia();
$jumlahTidakTersedia = $laporan->jumlahKamarTidakTersedia();
$detailTidakTersedia = $laporan->detailKamarTidakTersedia();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan - KyKos</title>
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
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <!--  Row 1 -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">LAPORAN KEUANGAN KY KOS</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <h5 class="card-title text-white">Total Penghasilan</h5>
                                                    <h3 class="text-white">Rp <?php echo number_format($totalPenghasilan, 0, ',', '.'); ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-success text-white">
                                                <div class="card-body">
                                                    <h5 class="card-title text-white">Kamar Tersedia</h5>
                                                    <h3 class="text-white"><?php echo $jumlahTersedia; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-secondary text-white">
                                                <div class="card-body">
                                                    <h5 class="card-title text-white">Kamar Disewa</h5>
                                                    <h3 class="text-white"><?php echo $jumlahTidakTersedia; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mt-4">Detail Kamar yang Disewa</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Kamar</th>
                                                    <th scope="col">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                while ($row = $detailTidakTersedia->fetch_assoc()) { ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $no++; ?></th>
                                                        <td><?php echo $row['nama_kamar']; ?></td>
                                                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
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

        <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/sidebarmenu.js"></script>
        <script src="./assets/js/app.min.js"></script>
        <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
        <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
    </div>
</body>

</html>