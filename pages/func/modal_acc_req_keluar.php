<?php
require '../config/koneksi.php';
session_start();
// untuk update ke tb_req_keluar
$username = $_SESSION['username'];
// untuk update ke tb_keluar
$id_user  = $_SESSION['id_user'];
// 
$id_req_keluar  = $_GET['id_req_keluar'];
$kategori   = $_GET['kategori'];
$page_no    = $_GET['page_no'];
$kolom_cari = $_GET['kolom_cari'];
$select         = mysqli_query($conn, "SELECT * FROM req_tb_keluar LEFT JOIN databarang ON req_tb_keluar.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON req_tb_keluar.id_user_keluar=tb_user.id_user WHERE req_tb_keluar.id_req_keluar='$id_req_keluar'");
$id             = mysqli_fetch_assoc($select);
// 
if ($id['kategori'] == 'EDIT') {
  $text = 'Anda setuju untuk mengubah data <b>'.$id['nama_barang'].'</b><br> dari Qty Jual <b>'.$id['qty_keluar'].'</b> menjadi <b>'.$id['req_qty_keluar'].'</b> berdasarkan pengajuan dari <b>'.$id['req_admin'].'</b> dengan alasan <b>'.$id['alasan'].'</b>?';
  $btn = 'btn btn-primary';
  $btnText = 'Update';
}else{
  $text = 'Anda setuju untuk menghapus data data <b>'.$id['nama_barang'].'</b> berdasarkan pengajuan dari <b>'.$id['req_admin'].'</b> dengan alasan <b>'.$id['alasan'].'</b>?';
  $btn = 'btn btn-danger';
  $btnText ='Hapus';
}
?>
<!-- modal edit -->
        <div class="modal-header">
          <h3 class="modal-title">Approve Request Penjualan</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="action/acc_req_keluar.php">
            <div class="form-group">
                <input type="text" name="id_req_keluar" value="<?php echo $id_req_keluar ?>" readonly hidden>
                <input type="text" name="kategori" value="<?php echo $kategori ?>" readonly hidden>
                <input type="text" name="id_user" value="<?php echo $id_user ?>" readonly hidden>
                <input type="text" name="id_keluar" value="<?php echo $id['id_keluar'] ?>" readonly hidden>
                <input type="text" name="req_qty_keluar" value="<?php echo $id['req_qty_keluar'] ?>" readonly hidden>
                <input type="text" name="req_diskon" value="<?php echo $id['req_diskon'] ?>" readonly hidden>
                <input type="text" name="alasan" value="<?php echo $id['alasan'] ?>" readonly hidden>
                <input type="text" name="username" value="<?php echo $username?>" readonly hidden>
                <input type="text" name="page_no" value="<?php echo $page_no ?>" readonly hidden>
                <input type="text" name="kolom_cari" value="<?php echo $kolom_cari ?>" readonly hidden>
                
                <?php echo $text; ?>
            
            <div class="modal-footer">
              <input type="submit" class="<?php echo $btn ?>" name="update" value="<?php echo $btnText ?>">
              <button id="nosave" type="button" class="btn btn-dark pull-left" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
<!-- modal edit close -->