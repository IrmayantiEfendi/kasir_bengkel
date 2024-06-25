<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['simpan'])) {
    $username       = $_POST['username'];
    $password       = md5($_POST["password"]);
    $no_hp          = $_POST['no_hp'];
    $alamat         = $_POST['alamat'];
    $tgl_mulai      = $_POST['tgl_mulai'];
    $hari_libur     = $_POST['hari_libur'];

    $query          = mysqli_query($conn, "INSERT INTO tb_user(id_user, username, password, no_hp, alamat, tgl_mulai, hari_libur, role) VALUES(NULL, '$username', '$password', '$no_hp', '$alamat', '$tgl_mulai', '$hari_libur', 'admin')");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Data anda berhasil diinput!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../data_karyawan.php');
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
                        window.location.replace('../data_karyawan.php');
                        }, 2000);
                        </script>
                        ";
    }
}
?>