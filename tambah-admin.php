<?php
require_once "model/model-admin.php";

$user = new Admin();
$data = $user->tampil();

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telp = $_POST['nomor_telp'];

    $user->tambah($password, $nama, $email, $nomor_telp);

    echo "<script>
        alert('Data berhasil ditambahkan');
        window.location='admin.php';
    </script>";
}
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

            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title mb-4">TAMBAH DATA ADMIN KY KOS</h3>
                  <div class="row">
                    <div class="col-md-8">
                      <form method="POST" action="">
                        <div class="mb-3">
                          <label for="nama" class="form-label">Nama Admin</label>
                          <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                          <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                          <input type="text" class="form-control" id="nomor_telp" name="nomor_telp" required>
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        <a href="admin.php" class="btn btn-secondary">Kembali</a>
                      </form>
                    </div>
                  </div>

                  <hr class="my-5">
                  <h4 class="card-title mb-4">DAFTAR ADMIN</h4>
                  <div class="d-md-flex align-items-center">
                    <div class="ms-auto mt-3 mt-md-0">
                      <a href="tambah-admin.php" class="btn btn-success">Tambah Data</a>
                    </div>
                  </div>
                  <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                      <thead>
                        <tr>
                          <th scope="col" class="px-0 text-muted text-center">
                            Nama Admin
                          </th>
                          <th scope="col" class="px-0 text-muted text-center">
                            Email
                          </th>
                          <th scope="col" class="px-0 text-muted text-center">
                            Nomor Telepon
                          </th>
                          <th scope="col" class="px-0 text-muted text-center">
                            Aksi
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php if($data && $data->num_rows > 0) { while($row = $data->fetch_assoc()) { ?>
                        <tr>
                         <td class="px-0 text-center"><?= htmlspecialchars($row['nama']) ?></td>
                         <td class="px-0 text-center"><?= htmlspecialchars($row['email']) ?></td>
                         <td class="px-0 text-center"><?= htmlspecialchars($row['nomor_telp']) ?></td>
                         <td class="px-0 text-center">
                          <a href="edit-admin.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm"><i class="ti ti-edit"></i></a>
                          <a href="hapus-admin.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="ti ti-trash"></i></a>
                         </td>
                        </tr>
                      <?php } } else { ?>
                        <tr>
                          <td colspan="4" class="text-center text-muted">Tidak ada data admin</td>
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