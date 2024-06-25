<?php
require '../config/koneksi.php';
session_start();
$id_user = $_SESSION['id_user'];
// 
$id_keluar_temp  = $_GET['id_keluar_temp'];
$select         = mysqli_query($conn, "SELECT * FROM temp_keluar LEFT JOIN databarang ON temp_keluar.kode_barang=databarang.kode_barang WHERE temp_keluar.id_keluar_temp='$id_keluar_temp' ");
$id             = mysqli_fetch_assoc($select);
?>
<!-- modal edit -->
        <div class="modal-header">
          <h3 class="modal-title">Edit data barang keluar</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="action/temp_edit_brg_keluar.php">
            <div class="form-group">
                <input type="text" name="id_keluar_temp" value="<?php echo $id_keluar_temp ?>" readonly hidden>
                <input type="text" name="id_user" value="<?php echo $id_user ?>" readonly hidden>
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
                <label class="col-sm-3 control-label text-right">Harga Jual</label>         
                <div class="col-sm-8"><input type="number" class="form-control" name="harga_jual" value="<?php echo $id['harga_jual'] ?>" readonly></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Qty Jual</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="qty_keluar" value="<?php echo $id['qty_keluar'] ?>"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="col-sm-3 control-label text-right">Diskon (Rp.)</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="diskon" value="<?php echo $id['diskon'] ?>"></div>
              </div>
            </div>
            
            <div class="modal-footer">
              <input type="submit" class="btn btn-info" name="update" value="Update">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
<!-- modal edit close -->