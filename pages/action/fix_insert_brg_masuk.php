<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['simpan']) AND $_POST['totalQty']>0) {
    $id_user        = $_POST['id_user'];
    $today          = date('Y-m-d');
    // 
    $no_trans_beli  = $_POST['no_trans_beli'];
    $totalQty       = $_POST['totalQty'];
    $totalHargaBeli     = $_POST['totalHargaBeli'];

    $query          = mysqli_query($conn, "INSERT INTO pemasukan(id_masuk, no_trans_beli, tgl_masuk, kode_barang, qty_masuk, id_user) SELECT id_masuk_temp, no_trans_beli, tgl_masuk, kode_barang, qty_masuk, id_user FROM temp_masuk WHERE id_user=$id_user AND no_trans_beli='$no_trans_beli' ");
    if ($query) {
        // insert dulu semua data faktur
        $insertFaktur = mysqli_query($conn, "INSERT INTO faktur_beli(no_trans_beli, tgl_trans_beli, total_qty_beli, total_harga_beli, id_user) VALUE('$no_trans_beli', NOW(), '$totalQty', '$totalHargaBeli', '$id_user')");
        $deleteTemp = mysqli_query($conn, "DELETE FROM temp_masuk WHERE id_user=$id_user AND no_trans_beli='$no_trans_beli' ");
        if($deleteTemp){
            echo "
            <script type='text/javascript'>
            setTimeout(function(){
            swal({
                title :'Success',
                text : 'Transaksi Barang Masuk berhasil diinput!',
                type : 'success',
                timer : 1000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_masuk.php');
                    }, 1000);
                    </script>
                    ";
        }
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Transaksi Barang Masuk Gagal, periksa data duplikat!',
                    type : 'error',
                    timer : 2000,
                    showConfirmButton : true
                    });
                    },10);
                    window.setTimeout(function(){
                        window.location.replace('../barang_masuk.php');
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
                text : 'Transaksi Barang Masuk Gagal, Data tidak boleh kosong!',
                type : 'error',
                timer : 2000,
                showConfirmButton : true
                });
                },10);
                window.setTimeout(function(){
                    window.location.replace('../barang_masuk.php');
                    }, 2000);
                    </script>
                    ";
}
?>