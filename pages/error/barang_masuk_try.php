<?php 
require 'config/koneksi.php';
include 'layouts/main.php';
include 'func/auto_complete.php';
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

    <!-- Collapsable Card Example for Table -->
    <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Barang</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample2">
                <div class="card-body">
                <!-- Data Tables -->
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr class="after-add-more">
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Quantity Masuk</th>
                            <th><button class="btn btn-info" id="add"><i class="fa fa-plus"></i></button></th>
                        </tr>
                    </thead>
                    <form method="POST" action="action/insert_brg_masuk.php">
                    <tbody class="copyData">
                        <tr id="rowData1">
                            <td>
                                <select class="form-control" id="kode_barang1" name="kode_barang[]" onchange="DynamicCombo(this.id)">
                                    <option value="0">==Pilih Kode==</option>
                                    <?php
                                    $selectDataBarang   = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM databarang");
                                    while($id = mysqli_fetch_array($selectDataBarang)){
                                        echo '
                                        <option value="'.$id['kode_barang'].'">'.$id['kode_barang'].' | '.$id['nama_barang'].'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="nama_barang1" name="nama_barang[]" placeholder="Nama Barang" required readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control" id="harga1" name="harga[]" placeholder="Harga Rp." readonly required>
                            </td>
                            <td>
                                <input type="number" class="form-control sum" id="qty_masuk1" name="qty_masuk[]" value="0" onkeyup="totalQtyMasuk(this.id)">
                            </td>
                            <td>
                            <!-- diisi content remove -->
                                <div id="removeButton"></div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td colspan="3"><p align="right"><b>Total</b></p></td>
                        <td><input type="number" class="form-control" id="totalQty" name="totalQty" value="0" readonly></td>
                        <td><input type="submit" class="btn btn-primary btn-block" id="simpan" name="simpan" value="Simpan"></td>
                    </tfoot>
                    </form>
                </table>
                <!--  -->
                </div>
            </div>
    </div>
    <!-- end Collapsable Card Example for Table -->
    

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
<!-- script tambah element -->
<script type="text/javascript">
// karena data yg ditampilkan mulai dari 1, maka no seterusnya melanjutkan dari 2
var no = 2;
$("#add").click(function() {
    var copyData = $(".copyData").html();
    $(".after-add-more").after(copyData);
    $('#removeButton').after('<button class="btn btn-danger" onclick="deleteElement('+no+')"><i class="fa fa-minus"></i></button>');
    // code untuk mengupdate id seluruh element dalam table
    document.getElementById('rowData1').id = 'rowData'+no;
    document.getElementById('kode_barang1').id = 'kode_barang'+no;
    document.getElementById('nama_barang1').id = 'nama_barang'+no;
    document.getElementById('harga1').id = 'harga'+no;
    document.getElementById('qty_masuk1').id = 'qty_masuk'+no;
    // increment no ditulis dipaling bawah agar nomor copy sebelumnya dimulai dari 2
    no++;
})
</script>
<!-- script tambah element end -->

<!-- dynamic combobox -->
<script type="text/javascript">
// function Dynamic Combo
function DynamicCombo(id) {
    // ambil increment atau nomor urutnya saja dengan cara menghapus string
    $num         = id.replace('kode_barang','');
    getNamaBarang($num);
}

// getNamaBarang
function getNamaBarang(num) {
    $(document).ready(function(){
        $kode_barang = $("#kode_barang"+num).val();
        $.ajax({
            type: 'GET',
            url: "func/get_namabarang.php?kode_barang="+$kode_barang,
            cache: false,
            success: function(msg){
                $("#nama_barang"+num).val(msg);
                getHargaBarang(num);
            }
        });
    });
}

// getHargaBarang
function getHargaBarang(num) {
    $(document).ready(function(){
        $kode_barang = $("#kode_barang"+num).val();
        $.ajax({
            type: 'GET',
            url: "func/get_hargabarang.php?kode_barang="+$kode_barang,
            cache: false, 
            success: function(msg){
                $("#harga"+num).val(msg);
            }
        });
    });
}
</script>
<!-- script dynamic combo end -->

<!-- script menjumlahkan semua qty masuk -->
<script>
function totalQtyMasuk(get_id){ //get_id merupakan parameter dari this.id untuk menentukan id ke berapa yg sedang diisi
    // tentukan banyaknya range input type berdasarkan class form
    var itemCount = document.getElementsByClassName("form-control sum");
    var totalQty = 0;
    // looping untuk menghitung total qty masuk disetiap baris
    for(var i = 1; i <= itemCount.length; i++)
    {
    	var qty_masuk = "qty_masuk"+i;
    	totalQty += parseFloat(document.getElementById(qty_masuk).value);
    }
    // tampilkan hasil perhitungan total
    document.getElementById("totalQty").value = parseFloat(totalQty.toFixed(2));
}
</script>
<!-- script menjumlahkan semua qty masuk end -->

<!-- script remove data -->
<script>
function deleteElement(num) {
    // sebelum diremove, kosongkan data setiap id
    document.getElementById('kode_barang'+num).value = '0';
    document.getElementById('nama_barang'+num).value = '';
    document.getElementById('harga'+num).value = '';
    // sebelum diremove, kurangi total dengan qty masuk yg diremove
    var totalQty = document.getElementById('totalQty').value;
    var qty_masuk = document.getElementById('qty_masuk'+num).value;
    var totalQtyNew = parseFloat(totalQty)-parseFloat(qty_masuk);
    document.getElementById('totalQty').value = totalQtyNew;
    // setelah semua hitungan selesai, baru di remove
    $("#rowData"+num).remove();
}
</script>
<!-- script remove data end -->