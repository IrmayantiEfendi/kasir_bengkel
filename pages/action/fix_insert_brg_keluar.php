<?php
include '../config/koneksi.php';
include '../func/sweetalert.php';

if (isset($_POST['simpan']) AND $_POST['totalQty']>0) {
    $id_user        = $_POST['id_user'];
    $today          = date('Y-m-d');
    // 
    $no_trans_jual  = $_POST['no_trans_jual'];
    $totalQty       = $_POST['totalQty'];
    $totalHargaJual     = $_POST['totalHargaJual'];
    $bayar          = $_POST['bayar'];
    $diskon         = $_POST['diskon'];

    $query          = mysqli_query($conn, "INSERT INTO pengeluaran(id_keluar, no_trans_jual, tgl_keluar, kode_barang, qty_keluar, diskon, id_user) SELECT id_keluar_temp, no_trans_jual, tgl_keluar, kode_barang, qty_keluar, diskon, id_user FROM temp_keluar WHERE id_user='$id_user' AND no_trans_jual='$no_trans_jual' ");
    if ($query) {
        // insert dulu semua data faktur
        $insertFaktur = mysqli_query($conn, "INSERT INTO faktur_jual(no_trans_jual, tgl_trans_jual, total_qty_jual, total_harga_jual, uang_bayar, id_user) VALUE('$no_trans_jual', NOW(), '$totalQty', '$totalHargaJual', '$bayar', '$id_user')");
        if($insertFaktur) {
            $deleteTemp = mysqli_query($conn, "DELETE FROM temp_keluar WHERE id_user='$id_user' AND no_trans_jual='$no_trans_jual' ");
            if($deleteTemp){
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
                        window.open('../print_bill.php?no_trans_jual=".$no_trans_jual."');
                        window.location.replace('../barang_keluar.php');
                        }, 1000);
                        </script>
                        ";
            }
        }
    }else{
        echo "
                <script type='text/javascript'>
                setTimeout(function(){
                swal({
                    title :'Error',
                    text : 'Transaksi Barang keluar Gagal, periksa data duplikat!',
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
            text : 'Transaksi Barang keluar Gagal, data tidak boleh kosong!',
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