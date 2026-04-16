<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

require_once "model/model-kamar.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kamar = new Kamar();
  $nama_kamar = $_POST['nama_kamar'];
  $harga = $_POST['harga'];
  $status = $_POST['status'];

  if ($kamar->tambah($nama_kamar, $harga, $status)) {
    header("Location: data-kamar.php");
  } else {
    echo "Gagal menambah data";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Kamar - KyKos</title>
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
                  <h3 class="card-title">TAMBAH DATA KAMAR</h3>
                  <form method="POST">
                    <div class="mb-3">
                      <label for="nama_kamar" class="form-label">Nama Kamar</label>
                      <input type="text" class="form-control" id="nama_kamar" name="nama_kamar" placeholder="Masukkan nama kamar" required>
                    </div>
                    <div class="mb-3">
                      <label for="harga" class="form-label">Harga</label>
                      <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga" required>
                    </div>
                    <div class="mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="data-kamar.php" class="btn btn-secondary">Kembali</a>
                  </form>
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
  </div>
</body>

</html>