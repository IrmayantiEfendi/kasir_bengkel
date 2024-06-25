<?php
require 'config/koneksi.php';
include 'layouts/main.php' ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                    <h6 class="m-0 font-weight-bold text-primary">Input Data Barang</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample1">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="action/insert_barang.php" method="POST">
                        <input type="text" class="form-control" id="id_user" name="id_user" value="<?php echo $id_user; ?>" readonly required hidden>

                            <!-- Input Data -->
                            <div class="row row mt-4">
                                <div class="col-lg-4">
                                    <?php require 'func/kode_barang_baru.php'; ?>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang" value="<?php echo $kodeBarang; ?>" readonly required>
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" required>
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli Rp." required>
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual Rp." required>
                                </div>
                            </div>

                            <!-- Input Data -->
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <input type="number" class="form-control" id="stock_awal" name="stock_awal" placeholder="Stock Awal">
                                </div>
                                <div class="col-lg-4">
                                    <input type="number" class="form-control" id="min_stock" name="min_stock" placeholder="Minimum Stock">
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" class="btn btn-primary btn-block" name="simpan" value="Simpan">
                                </div>
                                <div class="col-lg-2">
                                    <a href="" class="btn btn-danger btn-reset btn-block">Reset</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
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
                            $result_count   = mysqli_query($conn, "SELECT * FROM databarang LEFT JOIN tb_user ON databarang.id_user=tb_user.id_user ORDER BY kode_barang DESC");
                        } else {
                            $kolom_cari     = $_GET['kolom_cari'];
                            $result_count   = mysqli_query($conn, "SELECT * FROM databarang LEFT JOIN tb_user ON databarang.id_user=tb_user.id_user WHERE kode_barang LIKE '%$kolom_cari%' OR nama_barang LIKE '%$kolom_cari%' ORDER BY kode_barang DESC");
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
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stock Awal</th>
                                    <th>Minimum Stock</th>
                                    <th>Admin</th>
                                    <th colspan="2">
                                        <center>Aksi</center>
                                    </th>
                                </thead>
                                <tbody>
                                    <!-- Query Select Data -->
                                    <?php
                                    if(empty($_GET['kolom_cari'])){
                                        $kolom_cari = "";
                                        $selectTable = mysqli_query($conn, "SELECT * FROM databarang LEFT JOIN tb_user ON databarang.id_user=tb_user.id_user ORDER BY kode_barang DESC LIMIT $offset, $total_records_per_page");
                                    }else{
                                        $kolom_cari = $_GET['kolom_cari'];
                                        $selectTable = mysqli_query($conn, "SELECT * FROM databarang LEFT JOIN tb_user ON databarang.id_user=tb_user.id_user WHERE kode_barang LIKE '%$kolom_cari%' OR nama_barang LIKE '%$kolom_cari%' ORDER BY kode_barang DESC LIMIT $offset, $total_records_per_page");
                                    }
                                    while ($id = mysqli_fetch_array($selectTable)) {
                                        $kode_barang = $id['kode_barang'];
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $id['kode_barang']; ?></td>
                                            <td><?php echo $id['nama_barang']; ?></td>
                                            <td><?php echo 'Rp. ' . number_format($id['harga_beli'], 1); ?></td>
                                            <td><?php echo 'Rp. ' . number_format($id['harga_jual'], 1); ?></td>
                                            <td><?php echo $id['stock_awal']; ?></td>
                                            <td><?php echo $id['min_stock']; ?></td>
                                            <td><?php echo $id['username']; ?></td>
                                            <!--  -->
                                            <td><a href="#editBarang" data-toggle="modal" data-kode_barang="<?php echo $id['kode_barang'] ?>" data-page_no="<?php echo $page_no ?>" data-kolom_cari="<?php echo $kolom_cari ?>"><i class="fas fa-fw fa-edit" aria-hidden="true"></i> Edit</a></td>
                                            <td><a href="action/delete_barang.php?page_no=<?php echo $page_no ?>&&kolom_cari=<?php echo $kolom_cari ?>&&kode_barang=<?php echo $id['kode_barang']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-fw fa-trash"></i> Hapus</a></td>
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
<!-- SCRIPT FUNCTION -->
<!-- modal start TAMBAH -->
<div class="example-modal">
    <div id="editBarang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- fetched-data adalah data yg ada di modal -->
                <div class="fetched-data"></div>
                <!-- fetched-data adalah data yg ada di modal -->
            </div>
        </div>
    </div>
</div>
<!-- modal end -->

<!-- START MANGGIL MODAL TAMBAH-->
<script>
    $(document).ready(function() {
        $('#editBarang').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var kode_barang = $(e.relatedTarget).data('kode_barang');
            var page_no = $(e.relatedTarget).data('page_no');
            var kolom_cari = $(e.relatedTarget).data('kolom_cari');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_edit_barang.php',
                data: 'kode_barang='+kode_barang+'&page_no='+page_no+'&kolom_cari='+kolom_cari,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!--MODAL END -->