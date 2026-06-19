<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

require_once "model/model-kamar.php";
require_once "model/model-transaksi.php";

$kamarModel = new Kamar();
$kamarObj = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Load kamar beserta seluruh relasi OOP-nya (Composition, Aggregation, Association, Polymorphism)
    $kamarObj = $kamarModel->getByIdOOP($id);
}

if (!$kamarObj) {
    echo "<h3>Kamar tidak ditemukan!</h3>";
    echo "<a href='data-kamar.php'>Kembali ke Data Kamar</a>";
    exit;
}

// Ambil input durasi untuk kalkulasi biaya (Polymorphism)
$durasi = isset($_POST['durasi']) ? (int)$_POST['durasi'] : 3;
if ($durasi < 1) $durasi = 1;
$totalBiaya = $kamarObj->hitungBiayaSewa($durasi);

// Simulasi dependensi (Transaksi & InvoicePrinter)
$transaksi = new Transaksi($kamarObj, date('Y-m-d'), $totalBiaya, 100 + $kamarObj->id);
$printer = new InvoicePrinter();
$receiptText = $transaksi->printInvoice($printer);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Kamar - KyKos</title>
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
          <!-- Back button -->
          <div class="mb-4">
            <a href="data-kamar.php" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2">
              <i class="ti ti-arrow-left fs-4"></i> Kembali ke Daftar Kamar
            </a>
          </div>

          <div class="row">
            <!-- Left Side: Room details & specifications -->
            <div class="col-lg-7">
              <!-- Kamar Info Card -->
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-semibold mb-0"><?php echo htmlspecialchars($kamarObj->nama_kamar); ?></h3>
                    <?php if ($kamarObj instanceof KamarVIP) { ?>
                      <span class="badge bg-danger fs-3">Kamar VIP</span>
                    <?php } else { ?>
                      <span class="badge bg-secondary fs-3">Kamar Standard</span>
                    <?php } ?>
                  </div>
                  <p class="text-muted">ID Kamar: <?php echo $kamarObj->id; ?> | Status: 
                    <?php if ($kamarObj->status == 'Tersedia') { ?>
                      <span class="badge bg-light-success text-success">Tersedia</span>
                    <?php } else { ?>
                      <span class="badge bg-light-warning text-warning">Terisi</span>
                    <?php } ?>
                  </p>

                  <hr>

                  <div class="row mt-4">
                    <!-- Spesifikasi Kamar (Composition) -->
                    <div class="col-md-6 mb-4">
                      <h5 class="fw-semibold mb-3">Spesifikasi Kamar</h5>
                      <table class="table table-bordered table-sm mb-0">
                        <tbody>
                          <tr>
                            <td class="text-muted p-2" style="width: 40%;">Ukuran</td>
                            <td class="p-2"><strong><?php echo htmlspecialchars($kamarObj->detailKamar->ukuran); ?> m</strong></td>
                          </tr>
                          <tr>
                            <td class="text-muted p-2">Tipe Kasur</td>
                            <td class="p-2"><strong><?php echo htmlspecialchars($kamarObj->detailKamar->tipeKasur); ?></strong></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <!-- Informasi Penghuni (Association) -->
                    <div class="col-md-6 mb-4">
                      <h5 class="fw-semibold mb-3">Informasi Penghuni</h5>
                      <div class="p-3 bg-light rounded d-flex align-items-center gap-3">
                        <div class="p-2 bg-white rounded text-primary">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <div>
                          <small class="text-muted d-block">Nama Penyewa</small>
                          <strong class="fs-4"><?php echo htmlspecialchars($kamarObj->penyewa->nama); ?></strong>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Fasilitas Kamar (Aggregation) -->
                  <div class="mt-2">
                    <h5 class="fw-semibold mb-3">Fasilitas Kamar</h5>
                    <div class="d-flex flex-wrap gap-2">
                      <?php if (!empty($kamarObj->daftarFasilitas)) { ?>
                        <?php foreach ($kamarObj->daftarFasilitas as $fas) { ?>
                          <span class="badge bg-light-success text-success p-2 fs-3 rounded">
                            <i class="ti ti-circle-check-filled me-1"></i> <?php echo htmlspecialchars($fas->nama); ?>
                          </span>
                        <?php } ?>
                      <?php } else { ?>
                        <span class="text-muted">-</span>
                      <?php } ?>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- Right Side: Billing calculator & Receipt output -->
            <div class="col-lg-5">
              <!-- Billing Calculator (Polymorphism) -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title fw-semibold mb-3">Simulasi Biaya Sewa</h4>
                  
                  <div class="bg-light p-3 rounded mb-3">
                    <span class="text-muted small d-block">Kategori Layanan:</span>
                    <strong class="text-primary fw-semibold fs-4">
                      <?php echo ($kamarObj instanceof KamarVIP) ? 'Premium (Layanan VIP)' : 'Standard'; ?>
                    </strong>
                  </div>

                  <form method="POST" class="mb-3">
                    <label for="durasi" class="form-label">Durasi Sewa (Bulan)</label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo $durasi; ?>" min="1" required>
                      <button class="btn btn-primary" type="submit">Hitung</button>
                    </div>
                  </form>

                  <div class="d-flex justify-content-between align-items-center p-3 border rounded border-primary bg-light-primary">
                    <div>
                      <span class="text-muted small d-block">Tarif per Bulan:</span>
                      <strong>Rp <?php echo number_format($kamarObj->harga, 0, ',', '.'); ?></strong>
                    </div>
                    <div class="text-end">
                      <span class="text-muted small d-block">Total Tarif (<?php echo $durasi; ?> Bulan):</span>
                      <h4 class="text-primary fw-bold mb-0">Rp <?php echo number_format($totalBiaya, 0, ',', '.'); ?></h4>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Struk Pembayaran (Dependency) -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title fw-semibold mb-3">Struk Pembayaran</h4>
                  <pre class="bg-dark text-white p-3 rounded font-monospace mb-0" style="font-size: 12px; line-height: 1.5; overflow-x: auto;"><?php echo htmlspecialchars($receiptText); ?></pre>
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
