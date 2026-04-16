<?php
require_once(dirname(__FILE__) . "/../model/user.php");
if (isset($_POST['logout'])) {
  $user->logout();
}
?>

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed"></div>
<div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
  <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
  </div>

  <div class="d-lg-flex align-items-center gap-2">
    <div class="d-flex align-items-center justify-content-center gap-4 ">
      <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Muhammad Rizky Puspojati'; ?>

      <li class="nav-item dropdown">
        <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="./assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
          <form method="post" class="message-body">
            <button type="submit" name="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
          </form>
        </div>
      </li>
    </div>
  </div>

</div>

<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="/WEB%20PBO/KyKos/index.php" class="text-nowrap logo-img">
        <img src="/WEB%20PBO/KyKos/assets/images/logos/KyKos logo.png" width="100%" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-6"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/WEB%20PBO/KyKos/index.php" aria-expanded="false">
            <i class="ti ti-atom"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li>
          <span class="sidebar-divider lg"></span>
        </li>
        <li class="nav-small-cap">
          <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
          <span class="hide-menu">Features</span>
        </li>
        <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin'] == 1) { ?>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/WEB%20PBO/KyKos/manajemen-user/manajemen-user.php" aria-expanded="false">
              <i class="ti ti-users"></i>
              <span class="hide-menu">Manajemen User</span>
            </a>
          </li>
        <?php } ?>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="/WEB%20PBO/KyKos/laporan-keuangan.php"
            aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-report-money"></i>
              </span>
              <span class="hide-menu">Laporan Keuangan</span>
            </div>

          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/WEB%20PBO/KyKos/data-kamar.php" aria-expanded="false">
            <i class="ti ti-door"></i>
            <span class="hide-menu">Data Kamar</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="/WEB%20PBO/KyKos/status-pembayaran.php"
            aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-check"></i>
              </span>
              <span class="hide-menu">Status Pembayaran</span>
            </div>

          </a>
        </li>


      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>