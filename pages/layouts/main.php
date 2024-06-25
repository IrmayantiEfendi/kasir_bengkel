<?php
session_start();
require 'config/koneksi.php';
if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit();
} else {
    if ($_SESSION['role'] != 'admin' AND $_SESSION['role'] != 'super admin') {
        header("location: logout.php");
    }
    $username   = $_SESSION['username'];
    $id_user    = $_SESSION['id_user'];
    $role       = $_SESSION['role'];
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- header -->

<head>
    <?php include 'header.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Kasir Bengkel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item  <?php if($thispage == "dashboard"){ echo "active"; } ?>">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <?php
            if ($_SESSION['role'] == 'super admin') {
            ?>
            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="data_karyawan.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data Karyawan</span>
                </a>
            </li>
            <?php
            }
            ?>

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="data_barang.php">
                    <i class="fas fa-fw fa-bars"></i>
                    <span>Data Barang</span>
                </a>
            </li>

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="data_stock.php?kolom_cari=">
                    <i class="fas fa-fw fa-cubes"></i>
                    <span>Data Stock Barang</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Transaksi
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="barang_masuk.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Transaksi Pembelian</span>
                </a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="barang_keluar.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Transaksi Penjualan</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Bedakan link rincian data bagi admin dan super admin start-->
            <?php 
            if ($_SESSION['role'] == 'super admin') {
                $textBeli = 'Request Edit Pembelian';
                $textJual = 'Request Edit Penjualan';
                $linkRincianBeli = 'rincian_request_masuk.php';
                $linkRincianJual = 'rincian_request_keluar.php';
            }elseif ($_SESSION['role'] == 'admin') {
                $textBeli = 'Rincian Pembelian';
                $textJual = 'Rincian Penjualan';
                $linkRincianBeli = 'rincian_masuk.php';
                $linkRincianJual = 'rincian_keluar.php';
            }
            ?>
            <!-- Bedakan link rincian data bagi admin dan super admin end-->

            <!-- Heading -->
            <div class="sidebar-heading">
                Rincian
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $linkRincianBeli ?>">
                    <i class="fas fa-fw fa-list"></i>
                    <span><?php echo $textBeli ?></span>
                </a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $linkRincianJual ?>">
                    <i class="fas fa-fw fa-list"></i>
                    <span><?php echo $textJual ?></span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Laporan
            </div>

            <?php
            if ($_SESSION['role'] == 'super admin') {
            ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="laporan_masuk.php">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Laporan Rekap Pembelian</span>
                    </a>
                </li>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="laporan_keluar.php">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Laporan Rekap Penjualan</span>
                    </a>
                </li>
            <?php } ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- JIKA ROLE LOGIN ADALAH SUPER ADMIN, MAKA TAMPILKAN NOTIFIKASI BAR -->
                        <?php 
                        if ($role == 'super admin') {
                            include 'notif_bar.php';
                        }
                        ?>
                        <!-- JIKA ROLE LOGIN ADALAH SUPER ADMIN, MAKA TAMPILKAN NOTIFIKASI BAR SELESAI -->

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hallo, <?php echo $username ?>!</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <!-- =============================================================================================== -->




                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- footer -->
                <?php include 'footer.php'; ?>

</body>

</html>