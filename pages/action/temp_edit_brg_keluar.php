<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $id_keluar_temp      = $_POST['id_keluar_temp'];
    $qty_keluar          = $_POST['qty_keluar'];
    $diskon              = $_POST['diskon'];
    $id_user            = $_POST['id_user'];

    $query          = mysqli_query($conn, "UPDATE temp_keluar SET qty_keluar='$qty_keluar', diskon='$diskon', id_user='$id_user' WHERE id_keluar_temp='$id_keluar_temp'");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Transaksi Barang Keluar Berhasil Diedit!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_keluar.php');
                    }, 1000);
                    </script>
                    ";
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Transaksi Barang Keluar Gagal Diedit, periksa data duplikat!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../barang_keluar.php');
                        }, 2000);
                        </script>
                        ";
    }
}
?>