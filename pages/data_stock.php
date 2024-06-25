<?php
require 'config/koneksi.php';
include 'layouts/main.php' ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Stock Barang</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Data Barang</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">
                        <!-- Pencarian data start -->
                        <form method="GET">
                            <div class="row row mt-4">
                                <div class="col-lg-4">
                                    <p>Kolom Cari</p>
                                    <input type="text" class="form-control" id="kolom_cari" name="kolom_cari" placeholder="Ketik disini...">
                                </div>
                                <div class="col-lg-2">
                                    <p>&nbsp;</p>
                                    <input type="submit" class="btn btn-info btn-block" id="tombol_cari" name="tombol_cari" value="Cari">
                                </div>
                            </div>
                        </form>
                        <!-- Pencarian data end -->
                            <!-- Tombol laporan stock -->
                            <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <?php
                                    if(empty($_GET['kolom_cari'])){
                                        $kolom_cari = "";
                                    }else{
                                        $kolom_cari = $_GET['kolom_cari'];
                                    }
                                    ?>
                                    <a href="PDF/laporan_stock.php?kolom_cari=<?php echo $kolom_cari; ?>" target="_blank"><i class="fas fa-fw fa-file-pdf" aria-hidden="true"></i> Laporan Stock</a>
                                </div>
                            </div>
                            <!-- Tombol laporan stock selesai -->
                        <!-- Pagination select count start -->
                        <?php
                        if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                            $page_no = $_GET['page_no'];
                        } else {
                            $page_no = 1;
                        }
                        $total_records_per_page  = 25;
                        $offset                  = ($page_no - 1) * $total_records_per_page;
                        $no                      = $offset + 1;
                        $previous_page           = $page_no - 1;
                        $next_page               = $page_no + 1;
                        $adjacents               = "2";
                        // =====================SQL BERDASARKAN PENCARIAN===================
                        if (empty($_GET['kolom_cari'])) {
                            $kolom_cari     = "";
                            $result_count   = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang");
                        } else {
                            $kolom_cari     = $_GET['kolom_cari'];
                            $result_count   = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang WHERE stockbarang.kode_barang LIKE '%$kolom_cari%' OR databarang.nama_barang LIKE '%$kolom_cari%'");
                        }

                        $total_records = mysqli_num_rows($result_count);
                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                        $second_last = $total_no_of_pages - 1; // total pages minus 1
                        ?>
                        <!-- Pagination select count end -->

                        <!-- Data Tables -->
                        <div class="row row mt-4">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <th>Nomor</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Jual</th>
                                    <th>Stock Saat Ini</th>
                                    <th>Total Harga Jual</th>
                                </thead>
                                <tbody>
                                    <!-- Query Select Data -->
                                    <?php
                                    if(empty($_GET['kolom_cari'])){
                                        $kolom_cari = "";
                                        $selectTable = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang LIMIT $offset, $total_records_per_page");
                                    }else{
                                        $kolom_cari = $_GET['kolom_cari'];
                                        $selectTable = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang WHERE stockbarang.kode_barang LIKE '%$kolom_cari%' OR databarang.nama_barang LIKE '%$kolom_cari%' ORDER BY stockbarang.kode_barang DESC LIMIT $offset, $total_records_per_page");
                                    }
                                    while ($id = mysqli_fetch_array($selectTable)) {
                                        $kode_barang = $id['kode_barang'];
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $id['kode_barang']; ?></td>
                                            <td><?php echo $id['nama_barang']; ?></td>
                                            <td><?php echo 'Rp. ' . number_format($id['harga_jual'], 1); ?></td>
                                            <td><?php echo $id['total_stock']; ?></td>
                                            <td><?php echo 'Rp. '. number_format($id['total_stock']*$id['harga_jual'],1);?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <!-- End Query -->
                                </tbody>
                            </table>
                        </div>
                                    
                        <!-- Pagination show numbering -->
                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                            <strong>Showing Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                        </div>
                        <!--  -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <?php if ($page_no > 1) { echo "<li><a class='page-link' href='?page_no=1&&kolom_cari=$kolom_cari'>First Page</a></li>"; } ?>

                                <li class="page-item" <?php if ($page_no <= 1) { echo "class='disabled'"; } ?>>
                                    <a class="page-link" <?php if ($page_no > 1) {echo "href='?page_no=$previous_page&&kolom_cari=$kolom_cari'";} ?>>Previous</a>
                                </li>

                                <li class="page-item" <?php if ($page_no >= $total_no_of_pages) { echo "class='disabled'"; } ?>>
                                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&&kolom_cari=$kolom_cari'"; } ?>>Next</a>
                                </li>

                                <?php if ($page_no < $total_no_of_pages) { echo "<li><a class='page-link' href='?page_no=$total_no_of_pages&&kolom_cari=$kolom_cari'>Last &rsaquo;&rsaquo;</a></li>"; } ?>
                            </ul>
                        </nav>
                        <!-- End pagination show numbering -->
                        <!--  -->
                    </div>
                </div>
            </div>

        </div>
    </div>


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