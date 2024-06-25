<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['simpan'])) {
    $kode_barang    = $_POST['kode_barang'];
    $nama_barang    = $_POST['nama_barang'];
    $harga_beli     = $_POST['harga_beli'];
    $harga_jual     = $_POST['harga_jual'];
    $stock_awal     = $_POST['stock_awal'];
    $min_stock      = $_POST['min_stock'];
    $id_user        = $_POST['id_user'];

    $query          = mysqli_query($conn, "INSERT INTO databarang(kode_barang, tgl_input, nama_barang, harga_beli, harga_jual, stock_awal, min_stock, id_user) VALUES('$kode_barang', NOW(), '$nama_barang', '$harga_beli', '$harga_jual', '$stock_awal', '$min_stock', '$id_user')");
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
                    window.location.replace('../data_barang.php');
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
                        window.location.replace('../data_barang.php');
                        }, 2000);
                        </script>
                        ";
    }
}
?>