<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['oke'])) {
    $no_trans_beli  = $_POST['no_trans_beli'];
    $kode_barang    = $_POST['kode_barang'];
    $qty_masuk      = $_POST['qty_masuk'];
    $id_user        = $_POST['id_user'];

    $query          = mysqli_query($conn, "INSERT INTO temp_masuk(id_masuk_temp, no_trans_beli, tgl_masuk, kode_barang, qty_masuk, id_user) VALUES(NULL, '$no_trans_beli', NOW(), '$kode_barang', '$qty_masuk', '$id_user')");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Transaksi Barang Masuk berhasil diinput!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_masuk.php');
                    }, 1000);
                    </script>
                    ";
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Transaksi Barang Masuk Gagal Diinput, periksa data duplikat!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../barang_masuk.php');
                        }, 2000);
                        </script>
                        ";
    }
}
?>