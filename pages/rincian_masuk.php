<?php
require 'config/koneksi.php';
include 'layouts/main.php';
include 'func/auto_complete.php';
$id_user = 1;
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rincian Transaksi Barang Masuk</h1>
  </div>
  <!-- Content Row -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Collapsable Card Example for Table -->
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
          <h6 class="m-0 font-weight-bold text-primary">Pembelian Barang: <?php echo date('D, d M Y') ?></h6>
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
                            $result_count   = mysqli_query($conn, "SELECT * FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pemasukan.id_user=tb_user.id_user ORDER BY id_masuk DESC");
                        } else {
                            $kolom_cari     = $_GET['kolom_cari'];
                            $result_count   = mysqli_query($conn, "SELECT * FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pemasukan.id_user=tb_user.id_user WHERE pemasukan.no_trans_beli LIKE '%$kolom_cari%' OR pemasukan.tgl_masuk LIKE '%$kolom_cari%' OR pemasukan.kode_barang LIKE '%$kolom_cari%' OR databarang.nama_barang LIKE '%$kolom_cari%' OR tb_user.username LIKE '%$kolom_cari%' ORDER BY id_masuk DESC");
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
                                    <tr class="after-add-more">
                                        <th>No</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Nomor Transaksi Pembelian</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Quantity Beli</th>
                                        <th>Total Uang Keluar</th>
                                        <th>Nama Admin</th>
                                        <th colspan="2">
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($_GET['kolom_cari'])) {
                                        $kolom_cari = "";
                                        $selectTemp = mysqli_query($conn, "SELECT * FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pemasukan.id_user=tb_user.id_user ORDER BY id_masuk DESC LIMIT $offset, $total_records_per_page");
                                    } else {
                                        $kolom_cari = $_GET['kolom_cari'];
                                        $selectTemp = mysqli_query($conn, "SELECT * FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pemasukan.id_user=tb_user.id_user WHERE pemasukan.no_trans_beli LIKE '%$kolom_cari%' OR pemasukan.tgl_masuk LIKE '%$kolom_cari%' OR pemasukan.kode_barang LIKE '%$kolom_cari%' OR databarang.nama_barang LIKE '%$kolom_cari%' OR tb_user.username LIKE '%$kolom_cari%' ORDER BY id_masuk DESC LIMIT $offset, $total_records_per_page");
                                    }
                                    $totalQty = $totalHarga = 0;
                                    while ($id = mysqli_fetch_array($selectTemp)) {
                                        $id_masuk = $id['id_masuk'];
                                        $totalQty += $id['qty_masuk'];
                                        $subtotalHarga = $id['harga_beli'] * $id['qty_masuk'];
                                        $totalHarga += $subtotalHarga;
                                    ?>
                                        <!-- buat hidden kolom tampung id_user -->
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo date('D, d-M-Y h:i', strtotime($id['tgl_masuk'])); ?></td>
                                            <td><?php echo $id['no_trans_beli']; ?></td>
                                            <td><?php echo $id['kode_barang']; ?></td>
                                            <td><?php echo $id['nama_barang']; ?></td>
                                            <td><?php echo number_format($id['harga_beli'], 1); ?></td>
                                            <td><?php echo $id['qty_masuk']; ?></td>
                                            <td><?php echo number_format($subtotalHarga, 1); ?></td>
                                            <td><?php echo $id['username']; ?></td>
                                            <!-- tampilkan pilihan request edit dan delete apabila user adalah admin -->
                                            <?php
                                                // cek apabila sudah terdapat request maka tombol tidak ditampilkan
                                                $cekRequest     = mysqli_query($conn, "SELECT * FROM req_tb_masuk WHERE id_masuk='$id_masuk' AND status=''");
                                                $row            = mysqli_fetch_assoc($cekRequest);
                                                // if cek request
                                                if (mysqli_num_rows($cekRequest) > 0) {
                                                    echo "
                                                    <td colspan=2>
                                                        Data ini sudah direquest untuk ".$row['kategori']."
                                                    </td>    ";
                                                }else{
                                                ?>
                                                    <td>
                                                        <a href="#reqEditMasuk" class="btn btn-warning" data-toggle="modal" data-id_masuk="<?php echo $id_masuk ?>" data-page_no="<?php echo $page_no ?>" data-kolom_cari="<?php echo $kolom_cari ?>"><i class="fas fa-fw fa-paper-plane" aria-hidden="true"></i> Request Edit</a>
                                                    </td>
                                                    <td>
                                                        <a href="#reqHapusMasuk" class="btn btn-danger" data-toggle="modal" data-id_masuk="<?php echo $id_masuk ?>" data-page_no="<?php echo $page_no ?>" data-kolom_cari="<?php echo $kolom_cari ?>"><i class="fas fa-fw fa-paper-plane" aria-hidden="true"></i> Request Hapus</a>
                                                    </td>
                                                <?php
                                                }
                                                // end if cek request
                                                ?>
                                                <!-- admin selesai -->
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--  -->
                        <!-- Pagination show numbering -->
                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                            <strong>Showing Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                        </div>
                        <!--  -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <?php if ($page_no > 1) {
                                    echo "<li><a class='page-link' href='?page_no=1&&kolom_cari=$kolom_cari'>First Page</a></li>";
                                } ?>

                                <li class="page-item" <?php if ($page_no <= 1) {
                                                            echo "class='disabled'";
                                                        } ?>>
                                    <a class="page-link" <?php if ($page_no > 1) {
                                                                echo "href='?page_no=$previous_page&&kolom_cari=$kolom_cari'";
                                                            } ?>>Previous</a>
                                </li>

                                <li class="page-item" <?php if ($page_no >= $total_no_of_pages) {
                                                            echo "class='disabled'";
                                                        } ?>>
                                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                                echo "href='?page_no=$next_page&&kolom_cari=$kolom_cari'";
                                                            } ?>>Next</a>
                                </li>

                                <?php if ($page_no < $total_no_of_pages) {
                                    echo "<li><a class='page-link' href='?page_no=$total_no_of_pages&&kolom_cari=$kolom_cari'>Last &rsaquo;&rsaquo;</a></li>";
                                } ?>
                            </ul>
                        </nav>
                        <!-- End pagination show numbering -->

              <!--  -->
          </div>
        </div>
      </div>
      <!-- end collapsable -->
    </div>
  </div>
</div>

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
<!-- modal start edit -->
<div class="example-modal">
    <div id="editRincianMasuk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!-- START MANGGIL MODAL EDIT-->
<script>
    $(document).ready(function() {
        $('#editRincianMasuk').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var id_masuk = $(e.relatedTarget).data('id_masuk');
            var page_no = $(e.relatedTarget).data('page_no');
            var kolom_cari = $(e.relatedTarget).data('kolom_cari');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_fix_edit_brg_masuk.php',
                data: 'id_masuk='+id_masuk+'&page_no='+page_no+'&kolom_cari='+kolom_cari,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!--MODAL END -->

<!-- modal start REQ edit -->
<div class="example-modal">
    <div id="reqEditMasuk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!-- START MANGGIL MODAL REQ EDIT-->
<script>
    $(document).ready(function() {
        $('#reqEditMasuk').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var id_masuk = $(e.relatedTarget).data('id_masuk');
            var page_no = $(e.relatedTarget).data('page_no');
            var kolom_cari = $(e.relatedTarget).data('kolom_cari');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_req_edit_masuk.php',
                data: 'id_masuk='+id_masuk+'&page_no='+page_no+'&kolom_cari='+kolom_cari,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!--MODAL REQ END -->

<!-- modal start REQ HAPUS -->
<div class="example-modal">
    <div id="reqHapusMasuk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- fetched-data adalah data yg ada di modal -->
                <div class="fetched-data"></div>
                <!-- fetched-data adalah data yg ada di modal -->
            </div>
        </div>
    </div>
</div>
<!--REQ modal end -->

<!-- START MANGGIL MODAL REQ HAPUS-->
<script>
    $(document).ready(function() {
        $('#reqHapusMasuk').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var id_masuk = $(e.relatedTarget).data('id_masuk');
            var page_no = $(e.relatedTarget).data('page_no');
            var kolom_cari = $(e.relatedTarget).data('kolom_cari');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_req_hapus_masuk.php',
                data: 'id_masuk='+id_masuk+'&page_no='+page_no+'&kolom_cari='+kolom_cari,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!--EDIT MODAL END -->