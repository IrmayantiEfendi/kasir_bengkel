<?php 
include 'layouts/main.php';
require 'config/koneksi.php';
$thispage = 'dashboard';
 ?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            $selectBarang = mysqli_query($conn, "SELECT COUNT(*) AS ttl_brg FROM databarang");
                            $assoc = mysqli_fetch_assoc($selectBarang);
                            echo $assoc['ttl_brg'];
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Stock Awal</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
                            $selectAwal = mysqli_query($conn, "SELECT sum(stock_awal) as stock_awal FROM databarang");
                            $assoc = mysqli_fetch_assoc($selectAwal);
                            echo $assoc['stock_awal'];
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-insert fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Barang Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
                            $selectMasuk = mysqli_query($conn, "SELECT sum(qty_masuk) as ttl_masuk FROM pemasukan");
                            $assoc = mysqli_fetch_assoc($selectMasuk);
                            echo $assoc['ttl_masuk'];
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-insert fa-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Barang Keluar
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                <?php
                                $selectKeluar = mysqli_query($conn, "SELECT sum(qty_keluar) as ttl_keluar FROM pengeluaran");
                                $assoc = mysqli_fetch_assoc($selectKeluar);
                                echo $assoc['ttl_keluar'];
                                ?>
                                </div>
                            </div>
                            <!-- <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-minus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Stock Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
                            $selectStock = mysqli_query($conn, "SELECT sum(total_stock) as total_stock FROM stockbarang");
                            $assoc = mysqli_fetch_assoc($selectStock);
                            echo $assoc['total_stock'];
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

</div>
<!-- /.container-fluid -->

<!-- Copyright from here -->
</div>
<!-- End of Main Content -->
<?php
include 'layouts/jqueryModal.php'; 
include 'layouts/copyright.php'; ?>

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->