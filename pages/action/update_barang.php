<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['update'])) {
    $page_no        = $_POST['page_no'];
    $kolom_cari     = $_POST['kolom_cari'];
    $kode_barang    = $_POST['kode_barang'];
    $nama_barang    = $_POST['nama_barang'];
    $harga_beli     = $_POST['harga_beli'];
    $harga_jual     = $_POST['harga_jual'];
    $stock_awal     = $_POST['stock_awal'];
    $min_stock      = $_POST['min_stock'];
    $id_user        = $_POST['id_user'];

    // update data barang
    $updateDataBarang          = mysqli_query($conn, "UPDATE databarang SET nama_barang='$nama_barang', harga_beli='$harga_beli', harga_jual='$harga_jual', stock_awal='$stock_awal', min_stock='$min_stock', id_user='$id_user' WHERE kode_barang='$kode_barang' ");
    if ($updateDataBarang) {
        echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Data anda berhasil diubah!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../data_barang.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."');
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
                        window.location.replace('../edit_barang.php?page_no=".$page_no."&&kolom_cari=".$kolom_cari."&&kode_barang='".$kode_barang.");
                        }, 2000);
                        </script>
                        ";
    }
}
?>