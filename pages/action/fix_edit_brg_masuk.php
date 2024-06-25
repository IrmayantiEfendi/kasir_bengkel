<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $page_no            = $_POST['page_no'];
    $kolom_cari         = $_POST['kolom_cari'];
    // 
    $id_masuk           = $_POST['id_masuk'];
    $qty_masuk          = $_POST['qty_masuk'];
    $id_user            = $_POST['id_user'];

    $query          = mysqli_query($conn, "UPDATE pemasukan SET qty_masuk='$qty_masuk', id_user='$id_user' WHERE id_masuk='$id_masuk'");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Barang Masuk Berhasil Diedit!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../rincian_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Barang Masuk Gagal Diedit!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../rincian_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                        }, 2000);
                        </script>
                        ";
    }
}
?>