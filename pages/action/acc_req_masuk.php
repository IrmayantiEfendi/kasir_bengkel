<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $kategori   = $_POST['kategori'];
    $page_no            = $_POST['page_no'];
    $kolom_cari         = $_POST['kolom_cari'];
    // 
    $id_req_masuk        = $_POST['id_req_masuk'];
    // 
    $id_masuk        = $_POST['id_masuk'];
    $req_qty_masuk      = $_POST['req_qty_masuk'];
    $alasan             = $_POST['alasan'];
    $id_user            = $_POST['id_user'];
    $username            = $_POST['username'];
    $today              = date('Y-m-d');

    // jika kategori edit, maka data diubah
    if ($kategori == 'EDIT') {
        $updateMasuk = mysqli_query($conn, "UPDATE pemasukan SET qty_masuk='$req_qty_masuk', id_user='$id_user' WHERE id_masuk='$id_masuk' ");
        if ($updateMasuk) {
            $updateReqMasuk = mysqli_query($conn, "UPDATE req_tb_masuk SET acc_admin='$username', status='APPROVE $today' WHERE id_req_masuk='$id_req_masuk' ");
            echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Permintaan ".$kategori." Sudah Disetujui!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../rincian_request_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
        }else{
            echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Permintaan ".$kategori." Gagal Disetujui!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../rincian_request_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                        }, 2000);
                        </script>
                        ";
        }

    // jika kategori hapus, maka data dihapus
    }elseif ($kategori == 'HAPUS') {
        $hapusMasuk = mysqli_query($conn, "DELETE FROM pemasukan WHERE id_masuk='$id_masuk' ");
        if ($hapusMasuk) {
            $updateReqMasuk = mysqli_query($conn, "UPDATE req_tb_masuk SET acc_admin='$username', status='APPROVE $today' WHERE id_req_masuk='$id_req_masuk' ");
            echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Permintaan ".$kategori." Sudah Disetujui!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../rincian_request_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                    }, 1000);
                    </script>
                    ";
        }else{
            echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Permintaan ".$kategori." Gagal Disetujui!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../rincian_request_masuk.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                        }, 2000);
                        </script>
                        ";
        }
    }
}
?>