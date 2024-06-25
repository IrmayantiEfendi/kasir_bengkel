<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['hapus'])) {
    $page_no            = $_POST['page_no'];
    $kolom_cari         = $_POST['kolom_cari'];
    // 
    $id_keluar           = $_POST['id_keluar'];
    $alasan             = $_POST['alasan'];
    $username            = $_POST['username'];

    $query          = mysqli_query($conn, "INSERT INTO req_tb_keluar(id_req_keluar, id_keluar, no_trans_jual, tgl_keluar, kode_barang, qty_keluar, diskon_keluar, id_user_keluar, tgl_req, kategori, req_qty_keluar, req_diskon, alasan, req_admin) SELECT NULL, pengeluaran.*, NOW(), 'HAPUS', '0', '0', '$alasan', '$username' FROM pengeluaran WHERE id_keluar='$id_keluar'");
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
                    text : 'Permintaan Edit Gagal Dikirim Ke Super Admin!',
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