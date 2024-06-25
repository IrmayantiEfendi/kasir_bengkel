<?php
require '../config/koneksi.php';
session_start();
$id_user = $_SESSION['id_user'];
// 
$kode_barang = $_GET['kode_barang'];
$page_no   = $_GET['page_no'];
$kolom_cari= $_GET['kolom_cari'];
$select         = mysqli_query($conn, "SELECT * FROM databarang WHERE kode_barang='$kode_barang' ");
$id             = mysqli_fetch_assoc($select);
?>
<!-- modal edit -->
<div class="modal-header">
    <h3 class="modal-title">Edit Data Barang</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <form method="POST" action="action/update_barang.php">
                            <div class="form-group row">
                                <!-- page no dan kolom cari -->
                                <input type="text" class="form-control" name="page_no" value="<?php echo $page_no ?>" readonly hidden>
                                <input type="text" class="form-control" name="kolom_cari" value="<?php echo $kolom_cari ?>" readonly hidden>
                                <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>

                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>KODE BARANG</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?php echo $kode_barang ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>NAMA BARANG</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="<?php echo $id['nama_barang'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>HARGA BELI</label>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli" value="<?php echo $id['harga_beli'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>HARGA JUAL</label>
                                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual" value="<?php echo $id['harga_jual'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>STOK AWAL</label>
                                    <input type="number" class="form-control" id="stock_awal" name="stock_awal" placeholder="Stock Awal" value="<?php echo $id['stock_awal'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <label>MINIMAL STOK</label>
                                    <input type="number" class="form-control" id="min_stock" name="min_stock" placeholder="Minimum Stock" value="<?php echo $id['min_stock'] ?>">
                                </div>
                            </div>
                            
                            
                            
                            <input type="submit" class="btn btn-info btn-user btn-block" name="update" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery for showHide -->
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>       
<script>
    const password = document.getElementById('oldPassword'); // id dari input password
    const showHide = document.getElementById('showHide1'); // id span showHide dalam input group password

    password.type = 'password'; // set type input password menjadi password
    showHide.innerHTML = '<i class="fas fa-fw fa-eye"></i>'; // masukan icon eye dalam icon bootstrap 5
    showHide.style.cursor = 'pointer'; // ubah cursor menjadi pointer
    // jadi ketika span di hover maka cursornya berubah pointer

    showHide.addEventListener('click', () => {
    // ketika span diclick
        if (password.type === 'password') {
            // jika type inputnya password
            password.type = 'text'; // ubah type menjadi text
            showHide.innerHTML = '<i class="fas fa-fw fa-eye-slash"></i>'; // ubah icon menjadi eye slash
        } else {
            // jika type bukan password (text)
            showHide.innerHTML = '<i class="fas fa-fw fa-eye"></i>'; // ubah icon menjadi eye
            password.type = 'password'; // ubah type menjadi password
        }
    });
</script>