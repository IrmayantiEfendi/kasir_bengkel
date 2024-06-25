<?php
require 'config/koneksi.php';
include 'layouts/main.php';
include 'func/auto_complete.php';

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi Penjualan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Collapsable Card Example for Table -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan Barang: <?php echo date('D, d M Y') ?></h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">
                        <!-- Input data -->
                        <form action="action/temp_insert_brg_keluar.php" method="POST">
                            <!-- Input Data -->
                            <div class="row row mt-4">
                                <!-- buat hidden kolom tampung id_user -->
                                <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>
                                <div class="col-lg-4">
                                    <!-- panggil fungsi no_trans_jual otomatis -->
                                    <?php require 'func/kode_trans_jual_auto.php'; ?>
                                    <p>Nomor Transaksi Penjualan</p>
                                    <input type="text" class="form-control" id="no_trans_jual" name="no_trans_jual" value="<?php echo $no_trans_jual; ?>" required readonly>
                                </div>
                                
                                <div class="col-lg-4">
                                <p>Kode Barang</p>
                                <select class="selectpicker form-control show-tick is-valid form-control-lg" id="kode_barang" name="kode_barang" data-hide-disabled="true" data-live-search="true" required="" onchange="getNamaBarang()">
                                    <option value=""></option>
                                    <optgroup label="Kode Barang | Nama Barang">
                                    <?php
                                    $selectDataBarang   = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM databarang ORDER BY kode_barang DESC");
                                    while ($id = mysqli_fetch_array($selectDataBarang)) {
                                        echo '
                                                <option value="' . $id['kode_barang'] . '">' . $id['kode_barang'] . ' | ' . $id['nama_barang'] . '</option>
                                                ';
                                    }
                                    ?>
                                    </optgroup>
                                </select>	
                                </div>

                                <div class="col-lg-4">
                                    <p>Nama Barang</p>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" required readonly>
                                </div>
                            </div>

                            <!-- Input Data -->
                            <div class="row mt-4">
                                <div class="col-lg-2">
                                    <p>Harga Barang</p>
                                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Rp." readonly required>
                                </div>
                                <div class="col-lg-2">
                                    <p>Total Stock Barang</p>
                                    <input type="number" class="form-control" id="total_stock" name="total_stock" placeholder="Total Stock Barang" readonly required>
                                </div>
                                <div class="col-lg-2">
                                    <p>Qty keluar</p>
                                    <input type="number" class="form-control" id="qty_keluar" name="qty_keluar" value="0" onkeyup="totalQtyKeluar()">
                                </div>
                                <div class="col-lg-2">
                                    <p>Total Harga</p>
                                    <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <p>Diskon (Rp.)</p>
                                    <input type="number" class="form-control" id="diskon" name="diskon" value="0" onkeyup="totalQtyKeluar()">
                                </div>
                                <div class="col-lg-2">
                                    <p>&nbsp;</p>
                                    <input type="submit" class="btn btn-info" name="oke" value="Oke">
                                    <a href="" class="btn btn-dark btn-reset">Reset</a>
                                </div>
                                <div class="col-lg-2">
                                    <p>&nbsp;</p>
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
                                        <th>Harga Jual</th>
                                        <th>Quantity keluar</th>
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
                                        <th colspan="2">
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <form method="POST" action="action/fix_insert_brg_keluar.php">
                                    <tbody>
                                        <?php
                                        $selectTemp = mysqli_query($conn, "SELECT * FROM temp_keluar LEFT JOIN databarang ON temp_keluar.kode_barang=databarang.kode_barang WHERE temp_keluar.id_user='$id_user' ORDER BY id_keluar_temp DESC");
                                        $totalQty = $totalHargaJual = 0;
                                        while ($id = mysqli_fetch_array($selectTemp)) {
                                            $id_keluar_temp = $id['id_keluar_temp'];
                                            $totalQty += $id['qty_keluar'];
                                            $subtotalHargaJual = ($id['harga_jual'] * $id['qty_keluar'])-$id['diskon'];
                                            $totalHargaJual += $subtotalHargaJual;
                                        ?>
                                            <!-- buat hidden kolom tampung id_user -->
                                            <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>
                                            <input type="text" class="form-control" name="no_trans_jual" value="<?php echo $id['no_trans_jual'] ?>" readonly hidden>
                                            <tr>
                                                <td><input type="text" class="form-control" name="fix_kode_barang[]" readonly value="<?php echo $id['kode_barang'] ?>"></td>
                                                <td><?php echo $id['nama_barang'] ?></td>
                                                <td><?php echo number_format($id['harga_jual'], 1) ?></td>
                                                <td><input type="text" class="form-control" name="fix_qty_keluar[]" readonly value="<?php echo $id['qty_keluar'] ?>"></td>
                                                <td><input type="text" class="form-control" name="diskon[]" readonly value="<?php echo number_format($id['diskon'],1) ?>"></td>
                                                <td><input type="text" class="form-control" name="fix_totalHargaJual[]" readonly value="<?php echo number_format($subtotalHargaJual, 1) ?>"></td>
                                                <td>
                                                    <a href='#editTempKeluar' data-toggle='modal' data-id_keluar_temp='<?php echo $id_keluar_temp ?>'><i class="fas fa-fw fa-edit" aria-hidden="true"></i> Edit</a>
                                                </td>
                                                <td>
                                                    <a href="action/temp_delete_brg_keluar.php?id_keluar_temp=<?php echo $id['id_keluar_temp'] ?>" name="delete" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-fw fa-trash" aria-hidden="true"></i> Hapus</a>
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
                                            <td></td>
                                            <td><input type="number" class="form-control" id="totalHargaJual" name="totalHargaJual" value="<?php echo $totalHargaJual; ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <p align="right">Bayar</p>
                                            </td>
                                            <td><input type="number" class="form-control" id="bayar" name="bayar" onkeyup="hitungKembalian()" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <p align="right"><b>Kembali</b></p>
                                            </td>
                                            <td><input type="text" class="form-control" id="kembalian" name="kembalian" readonly value="0"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
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

<!-- Copyright from here -->
</div>
<!-- End of Main Content -->
<?php
include 'layouts/jqueryModal.php'; 
include 'layouts/jsSelectPicker.php'; 
include 'layouts/copyright.php'; ?>

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- SCRIPT FUNCTION -->
<!-- modal start -->
<div class="example-modal">
    <div id="editTempKeluar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $('#editTempKeluar').on('show.bs.modal', function(e) {
            // variabel diambil dari "data-" pada button
            var id_keluar_temp = $(e.relatedTarget).data('id_keluar_temp');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'GET',
                url: 'func/modal_temp_edit_brg_keluar.php',
                data: 'id_keluar_temp=' + id_keluar_temp,
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!-- END -->
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
                    getStockBarang()
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
                url: "func/get_harga_jual.php?kode_barang=" + $kode_barang,
                cache: false,
                success: function(msg) {
                    $("#harga_jual").val(msg);
                }
            });
        });
    }

    // getStockBarang
    function getStockBarang() {
        $(document).ready(function() {
            $kode_barang = $("#kode_barang").val();
            $.ajax({
                type: 'GET',
                url: "func/get_stock.php?kode_barang=" + $kode_barang,
                cache: false,
                success: function(msg) {
                    $("#total_stock").val(msg);
                }
            });
        });
    }
</script>
<!-- script dynamic combo end -->

<!-- fungsi pemisah ribuan start -->
<script>
function Rupiah(bilangan){
    var	number_string = bilangan.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
            
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}    
</script>
<!-- fungsi pemisah ribuan end -->

<!-- script totalQtyKeluar -->
<script>
    function totalQtyKeluar(){
        var total_stock = $("#total_stock").val();
        var qty_keluar  = $("#qty_keluar").val();
        var harga_jual = $("#harga_jual").val();
        var diskon = $("#diskon").val();
        var totalHarga = 0;
        if(parseFloat(qty_keluar) > parseFloat(total_stock)){
            alert('Stock Kurang! Cek Kembali Qty Jual!');
            $("#qty_keluar").val("");
        }else{
            if(diskon == 0){
                totalHarga = parseFloat(harga_jual)*parseFloat(qty_keluar);
            }else{
                totalHarga = (parseFloat(harga_jual)*parseFloat(qty_keluar))-parseFloat(diskon);
            }
                $("#total_harga").val('Rp. '+Rupiah(totalHarga));
        }
    }
</script>
<!-- script totalQtyKeluar end -->

<!-- script hitung kembalian -->
<script>
    function hitungKembalian() {
        var totalHargaJual = $("#totalHargaJual").val();
        var bayar = $("#bayar").val();
        var kembalian = parseFloat(bayar) - (parseFloat(totalHargaJual));
        $("#kembalian").val('Rp. '+Rupiah(kembalian));
    }
</script>