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


                        <div class="col-lg-4">
                            <div class="card overflow-hidden">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center ">
                                    <div>
                                        <h3 class="card-title">STATUS PEMBAYARAN KY KOS</h3>
                                    </div>
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <select class="form-select theme-select border-0"
                                            aria-label="Default select example">
                                            <option value="1">April 2026</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-0 text-muted">
                                                    Pendaftar
                                                </th>
                                                <th scope="col" class="px-0 text-muted">
                                                    Harga Kamar
                                                </th>
                                                <th scope="col" class="px-0 text-muted text-center">
                                                    Prioritas
                                                </th>
                                                <th scope="col" class="px-0 text-muted text-center">
                                                    Pembayaran
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="px-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="./assets/images/profile/user-3.jpg"
                                                            class="rounded-circle" width="40" alt="flexy" />
                                                        <div class="ms-3">
                                                            <h6 class="mb-0 fw-bolder">Christopher Nolan</h6>
                                                            <span class="text-muted">Kamar Eksekutif A</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-0">
                                                    <b>Rp 1.200.000</b>

                                                </td>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <span class="badge bg-info">High</span>
                                                </td>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <div class="dropdown">
                                                        <button class="btn badge bg-success dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown">
                                                            Sudah Bayar
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Sudah Bayar"
                                                                    data-color="bg-success">Sudah Bayar</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Belum Bayar"
                                                                    data-color="bg-danger">Belum Bayar</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="./assets/images/profile/user-5.jpg"
                                                            class="rounded-circle" width="40" alt="flexy" />
                                                        <div class="ms-3">
                                                            <h6 class="mb-0 fw-bolder">
                                                                Udin Pecok
                                                            </h6>
                                                            <span class="text-muted">Penghuni Kamar Teratai</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-0">

                                                    <b>Rp 800.000</b>
                                                </td>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <span class="badge text-bg-dark">Low</span>
                                                </td>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <div class="dropdown">
                                                        <button class="btn badge bg-success dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown">
                                                            Sudah Bayar
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Sudah Bayar"
                                                                    data-color="bg-success">Sudah Bayar</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Belum Bayar"
                                                                    data-color="bg-danger">Belum Bayar</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="./assets/images/profile/user-6.jpg"
                                                            class="rounded-circle" width="40" alt="flexy" />
                                                        <div class="ms-3">
                                                            <h6 class="mb-0 fw-bolder">
                                                                Christopher Usop
                                                            </h6>
                                                            <span class="text-muted">Penghuni Kamar Bougenville</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-0">

                                                    <b>Rp 800.000</b>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <span class="badge bg-warning">Medium</span>
                                                </td>
                                                <td class="px-0 text-dark fw-medium text-center">
                                                    <div class="dropdown">
                                                        <button class="btn badge bg-danger dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown">
                                                            Belum Bayar
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Sudah Bayar"
                                                                    data-color="bg-success">Sudah Bayar</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="Belum Bayar"
                                                                    data-color="bg-danger">Belum Bayar</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->


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