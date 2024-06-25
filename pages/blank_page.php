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
        <h1 class="h3 mb-0 text-gray-800">Transaksi Barang Masuk</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Collapsable Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary">Pembelian Barang: <?php echo date('D, d M Y'); ?></h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">

                        <!-- Input data -->
                        <form action="action/temp_insert_brg_masuk.php" method="POST">
                            <!-- Input Data -->
                            <div class="row row mt-4">
                                <!-- buat hidden kolom tampung id_user -->
                                <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>

                                <div class="col-lg-4">
                                    <!-- panggil fungsi no_trans_beli otomatis -->
                                    <?php require 'func/kode_trans_beli_auto.php'; ?>
                                    <p>Nomor Transaksi Pembelian</p>
                                    <input type="text" class="form-control" id="no_trans_beli" name="no_trans_beli" value="<?php echo $no_trans_beli; ?>" required readonly>
                                </div>

                                <div class="col-lg-4">
                                    <p>Kode Barang</p>
                                    <select class="form-control" id="kode_barang" name="kode_barang" onchange="getNamaBarang()">
                                        <option value="0">==Pilih Kode==</option>
                                        <?php
                                        $selectDataBarang   = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM databarang");
                                        while ($id = mysqli_fetch_array($selectDataBarang)) {
                                            echo '
                                            <option value="' . $id['kode_barang'] . '">' . $id['kode_barang'] . ' | ' . $id['nama_barang'] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <p>Nama Barang</p>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" required readonly>
                                </div>
                            </div>

                            <!-- Input Data -->
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <p>Harga Barang</p>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Rp." readonly required>
                                </div>
                                <div class="col-lg-4">
                                    <p>Qty Masuk</p>
                                    <input type="number" class="form-control" id="qty_masuk" name="qty_masuk" value="0" onkeyup="totalQtyMasuk(this.id)">
                                </div>
                                <div class="col-lg-4">
                                    <p>&nbsp;</p>
                                    <input type="submit" class="btn btn-info" name="oke" value="Oke">
                                    <a href="" class="btn btn-warning btn-dark">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- Data Tables -->
                        <div class="row row mt-4">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr class="after-add-more">
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Quantity Masuk</th>
                                        <th>Total Harga Beli</th>
                                        <th colspan="2">
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <form method="POST" action="action/fix_insert_brg_masuk.php">
                                    <tbody>
                                        <?php
                                        $selectTemp = mysqli_query($conn, "SELECT * FROM temp_masuk LEFT JOIN databarang ON temp_masuk.kode_barang=databarang.kode_barang WHERE temp_masuk.id_user='$id_user' ORDER BY id_masuk_temp DESC");
                                        $totalQty = $totalHargaBeli = $subtotalHargaBeli = 0;
                                        while ($id = mysqli_fetch_array($selectTemp)) {
                                            $id_masuk_temp = $id['id_masuk_temp'];
                                            $totalQty += $id['qty_masuk'];
                                            $subtotalHargaBeli = $id['harga_beli'] * $id['qty_masuk'];
                                            $totalHargaBeli += $subtotalHargaBeli;
                                        ?>
                                            <!-- buat hidden kolom tampung id_user -->
                                            <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>
                                            <input type="text" class="form-control" name="no_trans_beli" value="<?php echo $id['no_trans_beli'] ?>" readonly hidden>
                                            <tr>
                                                <td><input type="text" class="form-control" name="fix_kode_barang[]" readonly value="<?php echo $id['kode_barang'] ?>"></td>
                                                <td><?php echo $id['nama_barang'] ?></td>
                                                <td><?php echo $id['harga_beli'] ?></td>
                                                <td><input type="text" class="form-control" name="fix_qty_masuk[]" readonly value="<?php echo $id['qty_masuk'] ?>"></td>
                                                <td><input type="text" class="form-control" name="fix_totalHargaBeli[]" readonly value="<?php echo number_format($subtotalHargaBeli, 1) ?>"></td>
                                                <td>
                                                    <a href='#editTempMasuk' data-toggle='modal' data-id_masuk_temp='<?php echo $id_masuk_temp ?>'><i class="fas fa-fw fa-edit" aria-hidden="true"></i> Edit</a>
                                                </td>
                                                <td>
                                                    <a href="action/temp_delete_brg_masuk.php?id_masuk_temp=<?php echo $id['id_masuk_temp'] ?>" name="delete" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <p align="right">Total</p>
                                            </td>
                                            <td><input type="number" class="form-control" id="totalQty" name="totalQty" value="<?php echo $totalQty ?>" readonly></td>
                                            <td><input type="number" class="form-control" id="totalHargaBeli" name="totalHargaBeli" value="<?php echo $totalHargaBeli ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><input type="submit" class="btn btn-primary btn-block" name="simpan" value="Simpan"></td>
                                        </tr>
                                    </tfoot>
                                </form>
                            </table>
                        </div>
                        <!-- end table -->

                        <!--  -->
                    </div>
                </div>
            </div>

            <!-- end collapsable -->
        </div>
    </div>


</div>
<!-- /.container-fluid -->

<!-- Copyright from here -->
</div>
<!-- End of Main Content -->
<?php include 'layouts/copyright.php'; ?>

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->


<!-- javascript function -->
<!-- dynamic combobox -->
<script type="text/javascript">
    // getNamaBarang
    function getNamaBarang() {
        $(document).ready(function() {
            $kode_barang = $("#kode_barang").val();
            $.ajax({
                type: 'GET',
                url: "func/get_namabarang.php?kode_barang=" + $kode_barang,
                cache: false,
                success: function(msg) {
                    $("#nama_barang").val(msg);
                    getHargaBarang();
                }
            });
        });
    }

    // getHargaBarang
    function getHargaBarang() {
        $(document).ready(function() {
            $kode_barang = $("#kode_barang").val();
            $.ajax({
                type: 'GET',
                url: "func/get_harga_beli.php?kode_barang=" + $kode_barang,
                cache: false,
                success: function(msg) {
                    $("#harga_beli").val(msg);
                }
            });
        });
    }
</script>
<!-- script dynamic combo end -->


<!-- modal start -->
<div class="example-modal">
    <div id="editTempMasuk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!-- START MANGGIL MODAL -->
<script>
    $(document).ready(function() {
        $('#editTempMasuk').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var id_masuk_temp = $(e.relatedTarget).data('id_masuk_temp');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_temp_edit_brg_masuk.php',
                data: 'id_masuk_temp=' + id_masuk_temp,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!-- END -->