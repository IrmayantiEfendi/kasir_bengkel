<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (!empty($_GET['id_keluar_temp'])) {
    $id_keluar_temp    = $_GET['id_keluar_temp'];

    $hapus          = mysqli_query($conn, "DELETE FROM temp_keluar WHERE id_keluar_temp='$id_keluar_temp' ");
    if ($hapus) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Data anda berhasil dihapus!',
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
                text : 'Sudah ada transaksi untuk barang ini, data gagal dihapus!',
                type : 'error',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_keluar.php');
                    }, 1000);
                    </script>
                    ";
    }
}else{
    header('location: ../barang_keluar.php');
}
?>