<?php
require_once "model/model-kamar.php";

$kamar = new Kamar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $kamar->getById($id);
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_kamar = $_POST['nama_kamar'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    if ($kamar->update($id, $nama_kamar, $harga, $status)) {
        header("Location: data-kamar.php");
    } else {
        echo "Gagal mengupdate data";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Kamar - KyKos</title>
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
                  <h3 class="card-title">EDIT DATA KAMAR</h3>
                  <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <div class="mb-3">
                      <label for="nama_kamar" class="form-label">Nama Kamar</label>
                      <input type="text" class="form-control" id="nama_kamar" name="nama_kamar" value="<?php echo $data['nama_kamar']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="harga" class="form-label">Harga</label>
                      <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $data['harga']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option value="Tersedia" <?php if ($data['status'] == 'Tersedia') echo 'selected'; ?>>Tersedia</option>
                        <option value="Tidak Tersedia" <?php if ($data['status'] == 'Tidak Tersedia') echo 'selected'; ?>>Tidak Tersedia</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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