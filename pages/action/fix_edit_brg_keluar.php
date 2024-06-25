<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $page_no            = $_POST['page_no'];
    $kolom_cari         = $_POST['kolom_cari'];
    // 
    $id_keluar           = $_POST['id_keluar'];
    $qty_keluar          = $_POST['qty_keluar'];
    $diskon              = $_POST['diskon'];
    $id_user                = $_POST['id_user'];

    $query          = mysqli_query($conn, "UPDATE pengeluaran SET qty_keluar='$qty_keluar', diskon='$diskon', id_user='$id_user' WHERE id_keluar='$id_keluar'");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Barang Keluar Berhasil Diedit!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../rincian_keluar.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Barang Keluar Gagal Diedit!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../rincian_keluar.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                        }, 2000);
                        </script>
                        ";
    }
}
?>