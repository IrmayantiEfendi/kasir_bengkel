<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (!empty($_GET['id_user'])) {
    $page_no        = $_GET['page_no'];
    $kolom_cari     = $_GET['kolom_cari'];
    $id_user    = $_GET['id_user'];

    $hapus          = mysqli_query($conn, "DELETE FROM tb_user WHERE id_user='$id_user' ");
    if ($hapus) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Data karyawan berhasil dihapus!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../data_karyawan.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
    }else{
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Error',
                text : 'Karyawan ini pernah melakukan transaksi, data gagal dihapus!',
                type : 'error',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../data_karyawan.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
    }
}else{
    header('location: ../data_karyawan.php');
}
?>