<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

require_once 'model/model-admin.php';
require_once 'model/model-kamar.php';
require_once 'model/model-laporan.php';

// Ambil nama admin yang sedang login
$adminModel = new Admin();
$user_id = $_SESSION['user_id'];
$result = $adminModel->getById($user_id);
if ($result && $row = $result->fetch_assoc()) {
  $nama_admin = $row['nama'];
} else {
  $nama_admin = $_SESSION['username']; // fallback jika tidak ditemukan
}

// Ambil data laporan untuk dashboard
$laporan = new Laporan();
$total_penghasilan = $laporan->totalPenghasilan();
$kamar_tersedia = $laporan->jumlahKamarTersedia();
$kamar_terisi = $laporan->jumlahKamarTidakTersedia();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KyKos</title>
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
            <h1><?php echo "Hai, " . htmlspecialchars($nama_admin) . "!"; ?></h1>

            <!-- Statistics Cards -->
            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <h5 class="card-title mb-2">Total Penghasilan</h5>
                      <h3 class="fw-bold text-success">Rp <?php echo number_format($total_penghasilan, 0, ',', '.'); ?>
                      </h3>
                    </div>
                    <div class="ms-auto">
                      <i class="ti ti-wallet fs-8 text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <h5 class="card-title mb-2">Kamar Tersedia</h5>
                      <h3 class="fw-bold text-info"><?php echo $kamar_tersedia; ?> Kamar</h3>
                    </div>
                    <div class="ms-auto">
                      <i class="ti ti-door-2 fs-8 text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card overflow-hidden">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <h5 class="card-title mb-2">Kamar Terisi</h5>
                      <h3 class="fw-bold text-warning"><?php echo $kamar_terisi; ?> Kamar</h3>
                    </div>
                    <div class="ms-auto">
                      <i class="ti ti-door-2 fs-8 text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Second Row - Data Kamar Tersedia -->
          <div class="row mt-4">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-3">Kamar Tersedia</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Nama Kamar</th>
                          <th>Harga</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $kamarModel = new Kamar();
                        $kamar_list = $kamarModel->tampil();
                        if ($kamar_list && $kamar_list->num_rows > 0) {
                          while ($kamar = $kamar_list->fetch_assoc()) {
                            if ($kamar['status'] == 'Tersedia') {
                              echo '<tr>';
                              echo '<td>' . htmlspecialchars($kamar['nama_kamar']) . '</td>';
                              echo '<td>Rp ' . number_format($kamar['harga'], 0, ',', '.') . '</td>';
                              echo '<td><span class="badge bg-primary">Tersedia</span></td>';
                              echo '</tr>';
                            }
                          }
                        } else {
                          echo '<tr><td colspan="3" class="text-center text-muted">Tidak ada kamar tersedia</td></tr>';
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-0">Status Pembayaran</h4>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>Nama Penghuni</th>
                        <th>Kamar</th>
                        <th>Status Bayar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Christopher Nolan</td>
                        <td>Kamar 01</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                      </tr>
                      <tr>
                        <td>Udin Pecok</td>
                        <td>Kamar 02</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                      </tr>
                      <tr>
                        <td>Christopher Usop</td>
                        <td>Kamar 03</td>
                        <td><span class="badge bg-danger">Tertunggak</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


            <!-- Fourth Row - Recent Comments -->
            <div class="row mt-4">
              <div class="col-lg-12">
                <!-- Card -->
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-0">Recent Comments</h4>
                  </div>
                  <div class="comment-widgets scrollable mb-2 common-widget" style="height: 465px" data-simplebar="">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row border-bottom p-3 gap-3">
                      <div>
                        <span><img src="./assets/images/profile/user-3.jpg" class="rounded-circle" alt="user"
                            width="50" /></span>
                      </div>
                      <div class="comment-text w-100">
                        <h6 class="fw-medium">Cristiano Ronaldo</h6>
                        <p class="mb-1 fs-2 text-muted">
                          Kosan ini sangat bagus, fasilitas sangat lengkap dan service nya benar - benar top.
                        </p>
                        <div class="comment-footer mt-2">
                          <div class="d-flex align-items-center">
                          </div>
                          <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            mt-2
                            text-end
                          ">10 April, 2026</span>
                        </div>
                      </div>
                    </div>
                  <div class="comment-widgets scrollable mb-2 common-widget" style="height: 465px" data-simplebar="">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row border-bottom p-3 gap-3">
                      <div>
                        <span><img src="./assets/images/profile/user-3.jpg" class="rounded-circle" alt="user"
                            width="50" /></span>
                      </div>
                      <div class="comment-text w-100">
                        <h6 class="fw-medium">Lionel Cilor</h6>
                        <p class="mb-1 fs-2 text-muted">
                          Kosan ini sangat bagus, fasilitas sangat lengkap dan service nya benar - benar top.
                        </p>
                        <div class="comment-footer mt-2">
                          <div class="d-flex align-items-center">
                          </div>
                          <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            mt-2
                            text-end
                          ">20 April, 2026</span>
                        </div>
                      </div>
                    </div>
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row border-bottom p-3 gap-3">
                      <div>
                        <span><img src="./assets/images/profile/user-6.jpg" class="rounded-circle" alt="user"
                            width="50" /></span>
                      </div>
                      <div class="comment-text w-100">
                        <h6 class="fw-medium">Johnathan Piscok</h6>
                        <p class="mb-1 fs-2 text-muted">
                          Aku sangat suka kos ini, cuman jarak dari kampus UPN cukup jauh
                        </p>
                        <div class="comment-footer mt-2">
                          <div class="d-flex align-items-center">
                          </div>
                          <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            mt-2
                            text-end
                          ">14 April, 2026</span>
                        </div>
                      </div>
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
      <!-- solar icons -->
      <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

      <script>
        document.querySelectorAll('.dropdown-item').forEach(function (item) {
          item.addEventListener('click', function (e) {
            e.preventDefault();

            const nilai = this.getAttribute('data-value');
            const warna = this.getAttribute('data-color');

            const tombol = this.closest('.dropdown').querySelector('.btn');

            // Hapus SEMUA kemungkinan warna
            tombol.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-primary', 'bg-secondary', 'bg-info');

            tombol.classList.add(warna);
            tombol.textContent = nilai + ' ';
          });
        });
      </script>
</body>

</html>