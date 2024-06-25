<?php
session_start();
require '../config/koneksi.php';
$username       = $_GET['username'];
$thn_mulai      = $_GET['thn_mulai'];
$thn_selesai    = $_GET['thn_selesai'];
$bln_mulai      = $_GET['bln_mulai'];
$bln_selesai    = $_GET['bln_selesai'];
$bulan = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");
foreach ($bulan as $key => $value) {
    if ($bln_mulai == $key) {
        $nmBln_mulai = $value;
    }

    if ($bln_selesai == $key) {
        $nmBln_selesai = $value;
    }
}
// 
$from = $nmBln_mulai." ".$thn_mulai;
$to   = $nmBln_selesai." ".$thn_selesai;
// ganti ke indonesia
date_default_timezone_set("Asia/Jakarta");

// memanggil library FPDF
require('library/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(280, 10, 'Laporan Penjualan Bulan '.$from.' - '.$to, 0, 1, 'C');
// membuat garis start
$pdf->Cell(280, 0, '', 1, 1);
$pdf->Cell(280, 1, '', 0, 1);
$pdf->Cell(280, 0, '', 1, 1);
// membuat garis end

$pdf->SetFont('Times', '', 8);
$pdf->Cell(6, 10, '', 0, 1);
$pdf->Cell(220, 5, 'Tanggal print', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' . date('D, d/M/y H:i'), 0, 1, 'L');
$pdf->Cell(220, 5, 'Print oleh', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' . $username, 0, 1, 'L');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(8, 7, 'NO', 1, 0, 'C');
$pdf->Cell(25, 7, 'BULAN JUAL', 1, 0, 'C');
$pdf->Cell(20, 7, 'NO TRANS', 1, 0, 'C');
$pdf->Cell(15, 7, 'KD BRG', 1, 0, 'C');
$pdf->Cell(30, 7, 'NAMA BRG', 1, 0, 'C');
$pdf->Cell(15, 7, 'QTY', 1, 0, 'C');
$pdf->Cell(20, 7, 'HRG JUAL', 1, 0, 'C');
$pdf->Cell(20, 7, 'DISKON', 1, 0, 'C');
$pdf->Cell(30, 7, 'TTL JUAL', 1, 0, 'C');
$pdf->Cell(20, 7, 'HRG BELI', 1, 0, 'C');
$pdf->Cell(30, 7, 'TTL BELI', 1, 0, 'C');
$pdf->Cell(30, 7, 'KEUNTUNGAN', 1, 0, 'C');
$pdf->Cell(20, 7, 'ADMIN', 1, 0, 'C');

//  GARIS BARU
$pdf->Cell(10, 7, '', 0, 1);
//  GARIS BARU
$pdf->SetFont('Times', '', 8);
$jarak = 6;
$jarak2 = 7;
$subtotalKeluar = $grandtotalKeluar = 0;
$subtotalJual  = $grandtotalJual = 0;
$subtotalBeli = $grandtotalBeli = 0;
$keuntungan = 0;
$no = 1;
$select = mysqli_query($conn, "SELECT *, DATE_FORMAT(tgl_keluar, '%M') AS bln, DATE_FORMAT(tgl_keluar, '%y') AS thn, concat(MONTH(tgl_keluar),'-',YEAR(tgl_keluar)) AS blnThn FROM pengeluaran LEFT JOIN databarang ON pengeluaran.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pengeluaran.id_user=tb_user.id_user WHERE month(tgl_keluar) BETWEEN '$bln_mulai' AND '$bln_selesai' AND year(tgl_keluar) BETWEEN '$thn_mulai' AND '$thn_selesai' ORDER BY id_keluar DESC");
$result = $select->fetch_all(MYSQLI_ASSOC);
foreach ($result as $key => $id) {
    $subtotalKeluar += $id['qty_keluar'];
    $grandtotalKeluar += $id['qty_keluar'];
    // 
    $ttl_jual = ($id['harga_jual'] * $id['qty_keluar'])-$id['diskon'];
    $subtotalJual += $ttl_jual;
    $grandtotalJual += $ttl_jual;
    // 
    $ttl_beli = ($id['harga_beli'] * $id['qty_keluar']);
    $subtotalBeli += $ttl_beli;
    $grandtotalBeli += $ttl_beli;
    // 
    $keuntungan = $ttl_jual-$ttl_beli;

    // mulai show data
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(8, $jarak, $no++, 1, 0, 'C');
    $pdf->Cell(25, $jarak, date('M y', strtotime($id['tgl_keluar'])), 1, 0, 'C');
    $pdf->Cell(20, $jarak, $id['no_trans_jual'], 1, 0, 'C');
    $pdf->Cell(15, $jarak, $id['kode_barang'], 1, 0, 'L');
    $pdf->Cell(30, $jarak, $id['nama_barang'], 1, 0, 'L');
    $pdf->Cell(15, $jarak, $id['qty_keluar'], 1, 0, 'C');
    $pdf->Cell(20, $jarak, 'Rp. ' . number_format($id['harga_jual'], 1), 1, 0, 'R');
    $pdf->Cell(20, $jarak, 'Rp. ' . number_format($id['diskon'], 1), 1, 0, 'R');
    $pdf->Cell(30, $jarak, 'Rp. ' . number_format($ttl_jual, 1), 1, 0, 'R');
    $pdf->Cell(20, $jarak, 'Rp. ' . number_format($id['harga_beli'], 1), 1, 0, 'R');
    $pdf->Cell(30, $jarak, 'Rp. ' . number_format($ttl_beli, 1), 1, 0, 'R');
    $pdf->Cell(30, $jarak, 'Rp. ' . number_format($keuntungan, 1), 1, 0, 'R');
    $pdf->Cell(20, $jarak, $id['username'], 1, 1, 'C');
    if (@$result[$key + 1]['blnThn'] != $id['blnThn']) {
        $pdf->SetFont('Times','b',8);
        $pdf->Cell(98, $jarak2,'Total penjualan bulan '.$id['bln'].' '.$id['thn'],1,0,'R');
        $pdf->Cell(15, $jarak2, $subtotalKeluar, 1, 0, 'C');
        $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
        $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
        $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($subtotalJual,1), 1, 0, 'C');
        $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
        $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($subtotalBeli,1), 1, 0, 'C');
        $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($subtotalJual-$subtotalBeli,1), 1, 0, 'C');
        $pdf->Cell(20, $jarak2, '', 1, 1, 'C');

        // kembalikan nilai subtotal ke 0 agar tidak terjumlah dengan tanggal lain
        $subtotalKeluar = $subtotalJual = $subtotalBeli = 0;
    }
}
    // garis pemisah start
    $pdf->Cell(283, 3, '', 1, 1, 'C'); 
    // garis pemisah end
    $pdf->SetFont('Times','b',8);
    $pdf->Cell(98, $jarak2,'Total penjualan dari '.$from.' - '.$to,1,0,'R');
    $pdf->Cell(15, $jarak2, $grandtotalKeluar, 1, 0, 'C');
    $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
    $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
    $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($grandtotalJual,1), 1, 0, 'C');
    $pdf->Cell(20, $jarak2, '', 1, 0, 'C');
    $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($grandtotalBeli,1), 1, 0, 'C');
    $pdf->Cell(30, $jarak2, 'Rp. ' .number_format($grandtotalJual-$grandtotalBeli,1), 1, 0, 'C');
    $pdf->Cell(20, $jarak2, '', 1, 1, 'C');

$pdf->Output();
