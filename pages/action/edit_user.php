<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $id_user        = $_POST['id_user'];
    $username       = $_POST['username'];
    $no_hp          = $_POST['no_hp'];
    $alamat         = $_POST['alamat'];
    $tgl_mulai      = $_POST['tgl_mulai'];
    $hari_libur     = $_POST['hari_libur'];
    // 
    $page_no        = $_POST['page_no'];
    $kolom_cari     = $_POST['kolom_cari'];

    $query          = mysqli_query($conn, "UPDATE tb_user SET username='$username', no_hp='$no_hp', alamat='$alamat', tgl_mulai='$tgl_mulai', hari_libur='$hari_libur' WHERE id_user='$id_user' ");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Data karyawan berhasil diubah!',
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
                    text : 'Data anda gagal diinput, periksa data duplikat!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../data_karyawan.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
                        }, 2000);
                        </script>
                        ";
    }
}
?>