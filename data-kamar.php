<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

require_once "model/model-kamar.php";
require_once "model/model-admin.php";
require_once "model/model.php";
require_once "config.php";

$kamar = new Kamar();
$data = $kamar->tampil();
$no = 1;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Kamar - KyKos</title>
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
                  <div class="d-md-flex align-items-center">
                    <div>
                      <h3 class="card-title">DATA KAMAR KY KOS</h3>
                    </div>
                    <div class="ms-auto mt-3 mt-md-0">
                      <a href="tambah-kamar.php" class="btn btn-success">Tambah Data</a>
                    </div>
                  </div>
                  <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Kamar</th>
                          <th scope="col">Tipe</th>
                          <th scope="col">Ukuran & Kasur</th>
                          <th scope="col">Harga / Bulan</th>
                          <th scope="col">Status</th>
                          <th scope="col">Fasilitas</th>
                          <th scope="col" style="min-width: 200px;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($data && $data->num_rows > 0) { ?>
                          <?php while ($row = $data->fetch_assoc()) { ?>
                            <tr>
                              <th scope="row"><?php echo $no++; ?></th>
                              <td><strong><?php echo htmlspecialchars($row['nama_kamar']); ?></strong></td>
                              <td>
                                <?php if (($row['tipe_kamar'] ?? '') == 'VIP') { ?>
                                  <span class="badge bg-danger">VIP</span>
                                <?php } else { ?>
                                  <span class="badge bg-secondary">Standard</span>
                                <?php } ?>
                              </td>
                              <td>
                                <small class="d-block text-muted">
                                  Ukuran: <?php echo htmlspecialchars($row['ukuran'] ?? '3x4'); ?><br>
                                  Kasur: <?php echo htmlspecialchars($row['tipe_kasur'] ?? 'Single'); ?>
                                </small>
                              </td>
                              <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                              <td>
                                <?php if ($row['status'] == 'Tersedia') { ?>
                                  <span class="badge bg-success">Tersedia</span>
                                <?php } else { ?>
                                  <span class="badge bg-warning">Terisi</span>
                                <?php } ?>
                              </td>
                              <td>
                                <small class="text-muted">
                                  <?php echo htmlspecialchars($row['fasilitas'] ?? '-'); ?>
                                </small>
                              </td>
                              <td>
                                <div class="btn-group" role="group">
                                  <a href="detail-kamar.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-info btn-sm">Detail</a>
                                  <a href="edit-kamar.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                  <a href="hapus-kamar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">Hapus</a>
                                </div>
                              </td>
                            </tr>
                          <?php } ?>
                        <?php } else { ?>
                          <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data kamar.</td>
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
  </div>
</body>

</html>