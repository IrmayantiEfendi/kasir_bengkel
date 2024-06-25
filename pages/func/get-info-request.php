<?php
require '../config/koneksi.php';
$sql    = mysqli_query($conn, "SELECT * FROM req_tb_masuk WHERE status=''");
$array  = mysqli_num_rows($sql);
// 
$sql2   = mysqli_query($conn, "SELECT * FROM req_tb_keluar WHERE status=''");
$array2 = mysqli_num_rows($sql2);
// 
$totalArray = $array+$array2;

$output     = '';
// Tampilkan 3 pesan terakhir
$showData = mysqli_query($conn, "
                                SELECT d.tipe, d.no_trans, d.kode_barang, d.kategori, d.req_admin, d.alasan FROM
                                (SELECT 'masuk' AS tipe, req_tb_masuk.id_req_masuk AS id_req, req_tb_masuk.no_trans_beli AS no_trans, req_tb_masuk.kode_barang, req_tb_masuk.kategori, req_tb_masuk.req_admin, req_tb_masuk.alasan FROM req_tb_masuk WHERE req_tb_masuk.status=''
                                UNION
                                SELECT 'keluar' AS tipe, req_tb_keluar.id_req_keluar AS id_req, req_tb_keluar.no_trans_jual AS no_trans, req_tb_keluar.kode_barang, req_tb_keluar.kategori, req_tb_keluar.req_admin, req_tb_keluar.alasan FROM req_tb_keluar WHERE req_tb_keluar.status='') AS d ORDER BY id_req DESC LIMIT 3");
while($row = mysqli_fetch_array($showData))
{
    if ($row['tipe'] == 'masuk') {
        $link = 'rincian_request_masuk.php';
        $namaTipe = 'Pembelian';
    }elseif ($row['tipe'] == 'keluar') {
        $link = 'rincian_request_keluar.php';
        $namaTipe = 'Penjualan';
    }
    $cari      = $row['no_trans'];
    $output .= '
    <a class="dropdown-item d-flex align-items-center" href="'.$link.'?kolom_cari='.$cari.'&&tombol_cari="Cari"">
        <div class="mr-3">
            <div class="icon-circle bg-success">
                <i class="fas fa-file-alt text-white"></i>
            </div>
        </div>
        <div>
            <div class="small text-black-500">'.$row['no_trans'].' <b>'.$namaTipe.'</b></div>
            <span class="font-weight-bold">'.$row['kode_barang'].' request '.$row['kategori'].' <br>direquest oleh '.$row['req_admin'].' karena '.$row['alasan'].'</span>
        </div>
    </a>
    ';
}
$data = array(
'notification'   => $output,
'unseen_notification' => $totalArray,
'totalMasuk' => $array,
'totalKeluar' => $array2
);
echo json_encode($data);
?>