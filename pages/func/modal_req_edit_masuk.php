<?php
require '../config/koneksi.php';
session_start();
$username = $_SESSION['username'];
// 
$page_no    = $_GET['page_no'];
$kolom_cari = $_GET['kolom_cari'];
$id_masuk  = $_GET['id_masuk'];
$select         = mysqli_query($conn, "SELECT * FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang WHERE pemasukan.id_masuk='$id_masuk' ");
$id             = mysqli_fetch_assoc($select);
?>
<!-- modal edit -->
        <div class="modal-header">
          <h3 class="modal-title">Request Edit Penjualan</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="action/req_edit_masuk.php">
            <div class="form-group">
                <input type="text" name="id_masuk" value="<?php echo $id_masuk ?>" readonly hidden>
                <input type="text" name="username" value="<?php echo $username ?>" readonly hidden>
                <input type="text" name="page_no" value="<?php echo $page_no ?>" readonly hidden>
                <input type="text" name="kolom_cari" value="<?php echo $kolom_cari ?>" readonly hidden>
              <div class="row">
                <label class="col-sm-3 control-label text-right">Kode Barang</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="kode_barang" value="<?php echo $id['kode_barang'] ?>" readonly></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Nama Barang</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="nama_barang" value="<?php echo $id['nama_barang'] ?>" readonly></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Harga Beli</label>         
                <div class="col-sm-8"><input type="number" class="form-control" name="harga_beli" value="<?php echo $id['harga_beli'] ?>" readonly></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Qty Masuk</label>         
                <div class="col-sm-8"><input type="text" class="form-control" value="<?php echo $id['qty_masuk'] ?>" readonly></div>
              </div>
            </div>
            <!-- bagian request -->
            <hr>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Request Edit Qty Masuk</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="req_qty_masuk" value="<?php echo $id['qty_masuk'] ?>"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Alasan Request</label>         
                <div class="col-sm-8"><textarea class="form-control" name="alasan" id="alasan"></textarea></div>
              </div>
            </div>
            
            
            <div class="modal-footer">
              <input type="submit" class="btn btn-warning" name="update" value="Kirim Request Edit">
              <button id="nosave" type="button" class="btn btn-dark pull-left" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
<!-- modal edit close -->