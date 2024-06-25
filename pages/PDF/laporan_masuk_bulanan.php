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
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'Laporan Pembelian Bulan '.$from.' - '.$to, 0, 1, 'C');
// membuat garis start
$pdf->Cell(198, 0, '', 1, 1);
$pdf->Cell(198, 1, '', 0, 1);
$pdf->Cell(198, 0, '', 1, 1);
// membuat garis end

$pdf->SetFont('Times', '', 8);
$pdf->Cell(6, 10, '', 0, 1);
$pdf->Cell(150, 5, 'Tanggal print', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' . date('d/M/Y'), 0, 1, 'L');
$pdf->Cell(150, 5, 'Print oleh', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' . $username, 0, 1, 'L');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(8, 7, 'NO', 1, 0, 'C');
$pdf->Cell(35, 7, 'BULAN BELI', 1, 0, 'C');
$pdf->Cell(20, 7, 'NO TRANS', 1, 0, 'C');
$pdf->Cell(25, 7, 'KODE BRG', 1, 0, 'C');
$pdf->Cell(30, 7, 'NAMA BARANG', 1, 0, 'C');
$pdf->Cell(25, 7, 'HARGA BELI', 1, 0, 'C');
$pdf->Cell(15, 7, 'QTY', 1, 0, 'C');
$pdf->Cell(20, 7, 'TTL HARGA', 1, 0, 'C');
$pdf->Cell(20, 7, 'ADMIN', 1, 0, 'C');

//  GARIS BARU
$pdf->Cell(10, 7, '', 0, 1);
//  GARIS BARU
$pdf->SetFont('Times', '', 8);
$jarak = 6;
$jarak2 = 7;
$subtotalMasuk = $grandtotalMasuk = 0;
$subtotalHarga = $grandtotalHarga = 0;
$no = 1;
$select = mysqli_query($conn, "SELECT *, concat(MONTH(tgl_masuk),'-',YEAR(tgl_masuk)) AS blnThn FROM pemasukan LEFT JOIN databarang ON pemasukan.kode_barang=databarang.kode_barang LEFT JOIN tb_user ON pemasukan.id_user=tb_user.id_user WHERE month(tgl_masuk) BETWEEN '$bln_mulai' AND '$bln_selesai' AND year(tgl_masuk) BETWEEN '$thn_mulai' AND '$thn_selesai' ORDER BY id_masuk DESC");
$result = $select->fetch_all(MYSQLI_ASSOC);
foreach ($result as $key => $id) {
    $ttl_harga = $id['harga_beli'] * $id['qty_masuk'];
    $subtotalMasuk += $id['qty_masuk'];
    $subtotalHarga += $ttl_harga;
    $grandtotalMasuk += $id['qty_masuk'];
    $grandtotalHarga += $ttl_harga;

    // mulai show data
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(8, $jarak, $no++, 1, 0, 'C');
    $pdf->Cell(35, $jarak, date('M y', strtotime($id['tgl_masuk'])), 1, 0, 'C');
    $pdf->Cell(20, $jarak, $id['no_trans_beli'], 1, 0, 'C');
    $pdf->Cell(25, $jarak, $id['kode_barang'], 1, 0, 'L');
    $pdf->Cell(30, $jarak, $id['nama_barang'], 1, 0, 'L');
    $pdf->Cell(25, $jarak, 'Rp. ' . number_format($id['harga_beli'], 1), 1, 0, 'C');
    $pdf->Cell(15, $jarak, $id['qty_masuk'], 1, 0, 'C');
    $pdf->Cell(20, $jarak, 'Rp. ' . number_format($ttl_harga, 1), 1, 0, 'C');
    $pdf->Cell(20, $jarak, $id['username'], 1, 1, 'C');
    if (@$result[$key + 1]['blnThn'] != $id['blnThn']) {
        $pdf->SetFont('Times','b',8);
        $pdf->Cell(143, $jarak2,'Total pembelian tanggal '.date('M y', strtotime($id['tgl_masuk'])),1,0,'R');
        $pdf->Cell(15, $jarak2, $subtotalMasuk, 1, 0, 'C');
        $pdf->Cell(20, $jarak2, 'Rp. ' .number_format($subtotalHarga,1), 1, 0, 'C');
        $pdf->Cell(20, $jarak2, '', 1, 1, 'C');

        // kembalikan nilai subtotal ke 0 agar tidak terjumlah dengan tanggal lain
        $subtotalMasuk = $subtotalHarga = 0;
    }
}
    $pdf->Cell(198, 3, '', 1, 1, 'C'); 
    $pdf->SetFont('Times','b',8);
    $pdf->Cell(143, $jarak2,'Total pembelian dari '.$from.' - '.$to,1,0,'R');
    $pdf->Cell(15, $jarak2, $grandtotalMasuk, 1, 0, 'C');
    $pdf->Cell(20, $jarak2, 'Rp. ' .number_format($grandtotalHarga,1), 1, 0, 'C');
    $pdf->Cell(20, $jarak2, '', 1, 1, 'C');

$pdf->Output();
