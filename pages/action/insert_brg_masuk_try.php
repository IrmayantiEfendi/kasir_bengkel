<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['simpan'])) {
    $kode_barang    = $_POST['kode_barang'];
    $qty_masuk      = $_POST['qty_masuk'];
    $id_user        = 1;

    foreach ($qty_masuk as $key => $value) {
        echo $qty_masuk[$key]."</br>";
        // validasi, hanya kode barang yg terpilih boleh masuk ke database
        // if($kode_barang[$key] != "0"){
        //     $query          = mysqli_query($conn, "INSERT INTO pemasukan(id_masuk, tgl_masuk, kode_barang, qty_masuk, id_user) VALUES(NULL, NOW(), '$kode_barang[$key]', '$qty_masuk[$key]', '$id_user')");
        //     if ($query) {
        //         echo "
        //             <script type='text/javascript'>
        //             setTimeout(function(){
        //             swal({
        //                 title :'Success',
        //                 text : 'Transaksi Barang Masuk berhasil diinput!',
        //                 type : 'success',
        //                 timer : 1000,
        //                 showConfirmButton : true
        //                 });
        //                 },10);
        //                 window.setTimeout(function(){
        //                     window.location.replace('../barang_masuk.php');
        //                     }, 1000);
        //                     </script>
        //                     ";
        //     }else{
        //         echo "
        //                 <script type='text/javascript'>
        //                 setTimeout(function(){
        //                 swal({
        //                     title :'Error',
        //                     text : 'Transaksi Barang Masuk, periksa data duplikat!',
        //                     type : 'error',
        //                     timer : 2000,
        //                     showConfirmButton : true
        //                     });
        //                     },10);
        //                     window.setTimeout(function(){
        //                         window.location.replace('../barang_masuk.php');
        //                         }, 2000);
        //                         </script>
        //                         ";
        //     }
        // }
    }
}
?>