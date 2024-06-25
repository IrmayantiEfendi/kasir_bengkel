<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (!empty($_GET['kode_barang'])) {
    $page_no        = $_GET['page_no'];
    $kolom_cari     = $_GET['kolom_cari'];
    $kode_barang    = $_GET['kode_barang'];

    $hapus          = mysqli_query($conn, "DELETE FROM databarang WHERE kode_barang='$kode_barang' ");
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
                    window.location.replace('../data_barang.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
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
                    window.location.replace('../data_barang.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
    }
}else{
    header('location: ../data_barang.php');
}
?>