<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $id_masuk_temp      = $_POST['id_masuk_temp'];
    $qty_masuk          = $_POST['qty_masuk'];
    $id_user            = $_POST['id_user'];

    $query          = mysqli_query($conn, "UPDATE temp_masuk SET qty_masuk='$qty_masuk', id_user='$id_user' WHERE id_masuk_temp='$id_masuk_temp'");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Transaksi Barang Masuk Berhasil Diedit!',
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
                    text : 'Transaksi Barang Masuk Gagal Diedit, periksa data duplikat!',
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