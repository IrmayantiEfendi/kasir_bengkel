<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['oke']) AND $_POST['qty_keluar']>0) {
    $no_trans_jual      = $_POST['no_trans_jual'];
    $kode_barang        = $_POST['kode_barang'];
    $qty_keluar         = $_POST['qty_keluar'];
    $diskon             = $_POST['diskon'];
    $id_user            = $_POST['id_user'];

    $query          = mysqli_query($conn, "INSERT INTO temp_keluar(id_keluar_temp, no_trans_jual, tgl_keluar, kode_barang, qty_keluar, diskon, id_user) VALUES(NULL, '$no_trans_jual', NOW(), '$kode_barang', '$qty_keluar', '$diskon', '$id_user')");
    if ($query) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Transaksi Barang keluar berhasil diinput!',
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
                    text : 'Transaksi Barang Keluar Gagal Diinput, periksa data duplikat!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../barang_keluar.php');
                        }, 2000);
                        </script>
                        ";
    }
}else{
    echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Error',
                text : 'Transaksi Barang Keluar Gagal Diinput, Qty Jual Tidak Boleh Kosong!',
                type : 'error',
                timer : 2000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_keluar.php');
                    }, 2000);
                    </script>
                    ";
}
?>