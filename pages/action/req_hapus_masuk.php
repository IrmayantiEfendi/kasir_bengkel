<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['hapus'])) {
    $page_no            = $_POST['page_no'];
    $kolom_cari         = $_POST['kolom_cari'];
    // 
    $id_masuk           = $_POST['id_masuk'];
    $alasan             = $_POST['alasan'];
    $username            = $_POST['username'];

    $query          = mysqli_query($conn, "INSERT INTO req_tb_masuk(id_req_masuk, id_masuk, no_trans_beli, tgl_masuk, kode_barang, qty_masuk, id_user_masuk, tgl_req, kategori, req_qty_masuk, alasan, req_admin) SELECT NULL, pemasukan.*, NOW(), 'HAPUS', '0', '$alasan', '$username' FROM pemasukan WHERE id_masuk='$id_masuk'");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Permintaan Edit Sudah Dikirim Ke Super Admin!',
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
                    text : 'Permintaan Edit Gagal Dikirim Ke Super Admin!',
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