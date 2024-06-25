<?php
session_start();
require '../config/koneksi.php';
$username       = $_SESSION['username'];
$kolom_cari     = $_GET['kolom_cari'];
// ganti ke indonesia
date_default_timezone_set("Asia/Jakarta");
$today = date('D, d/m/y');

// memanggil library FPDF
require('library/fpdf.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(198, 10, 'Laporan Stock '.$today, 0, 1, 'C');
// membuat garis start
$pdf->Cell(198, 0, '', 1, 1);
$pdf->Cell(198, 1, '', 0, 1);
$pdf->Cell(198, 0, '', 1, 1);
// membuat garis end

$pdf->SetFont('Times', '', 8);
$pdf->Cell(6, 10, '', 0, 1);
$pdf->Cell(220, 5, 'Tanggal print', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' .date('D, d/M/y H:i'), 0, 1, 'L');
$pdf->Cell(220, 5, 'Print oleh', 0, 0, 'R');
$pdf->Cell(30, 5, ': ' . $username, 0, 1, 'L');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(8, 7, 'NO', 1, 0, 'C');
$pdf->Cell(25, 7, 'KODE BRG', 1, 0, 'C');
$pdf->Cell(40, 7, 'NAMA BRG', 1, 0, 'C');
$pdf->Cell(20, 7, 'HRG BELI', 1, 0, 'C');
$pdf->Cell(20, 7, 'HRG JUAL', 1, 0, 'C');
$pdf->Cell(30, 7, 'TOTAL STOCK', 1, 0, 'C');
$pdf->Cell(40, 7, 'ESTIMASI KEUNTUNGAN', 1, 0, 'C');

//  GARIS BARU
$pdf->Cell(10, 7, '', 0, 1);
//  GARIS BARU
$pdf->SetFont('Times', '', 8);
$no = 1;
$keuntungan = 0;
if(empty($_GET['kolom_cari']))
{
    $select = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang");
}else{
    $select = mysqli_query($conn, "SELECT * FROM stockbarang LEFT JOIN databarang ON stockbarang.kode_barang=databarang.kode_barang WHERE databarang.kode_barang LIKE '%$kolom_cari%' OR databarang.nama_barang LIKE '%$kolom_cari%'");
}
$result = $select->fetch_all(MYSQLI_ASSOC);
foreach ($result as $key => $id) {
    $keuntungan = ($id['harga_jual']*$id['total_stock'])-($id['harga_beli']*$id['total_stock']);

	$cellWidth = 40;
	$maxLength = 30;
	$textWidth = $pdf->GetStringWidth($id['nama_barang']);

	// jika panjang kalimat dalam nama barang < maxLength, maka jarak akan tetap menggunakan default
	if($textWidth < $maxLength){
		$akumulasiJarak = 4;
	}else{
		$div 		= ceil($textWidth / $maxLength);
		$jarak = 4;
		$akumulasiJarak = $jarak * $div;
	}

    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(8, $akumulasiJarak, $no++, 1, 0, 'C');
    $pdf->Cell(25, $akumulasiJarak, $id['kode_barang'], 1, 0, 'C');
    // merge cell
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
    $pdf->MultiCell(40, $jarak, $id['nama_barang'], 1, 'L');

    // // kembalikan baris ke bagian atas
    $pdf->SetXY($xPos + $cellWidth , $yPos);

    $pdf->Cell(20, $akumulasiJarak, 'Rp. '.number_format($id['harga_beli'],1), 1, 0, 'R');
    $pdf->Cell(20, $akumulasiJarak, 'Rp. '.number_format($id['harga_jual'],1), 1, 0, 'R');
    $pdf->Cell(30, $akumulasiJarak, $id['total_stock'], 1, 0, 'C');
    $pdf->Cell(40, $akumulasiJarak, 'Rp. '.number_format($keuntungan,1), 1, 1, 'R');

    // $cellWidth=30; //lebar sel
	// $cellHeight=1; //tinggi sel satu baris normal

    // //periksa apakah teksnya melibihi kolom?
	// if($pdf->GetStringWidth($id['nama_barang']) < $cellWidth){
	// 	//jika tidak, maka tidak melakukan apa-apa
	// 	$line=2;
	// }else{
    //     //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
	// 	//dengan memisahkan teks agar sesuai dengan lebar sel
	// 	//lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
	// 	$textLength=strlen($id['nama_barang']);	//total panjang teks
	// 	$errMargin=5;		//margin kesalahan lebar sel, untuk jaga-jaga
	// 	$startChar=0;		//posisi awal karakter untuk setiap baris
	// 	$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
	// 	$textArray=array();	//untuk menampung data untuk setiap baris
	// 	$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)

    //     while($startChar < $textLength){ //perulangan sampai akhir teks
	// 		//perulangan sampai karakter maksimum tercapai
	// 		while( 
	// 		$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
	// 		($startChar+$maxChar) < $textLength ) {
	// 			$maxChar++;
	// 			$tmpString=substr($id['nama_barang'],$startChar,$maxChar);
	// 		}
	// 		//pindahkan ke baris berikutnya
	// 		$startChar=$startChar+$maxChar;
	// 		//kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
	// 		array_push($textArray,$tmpString);
	// 		//reset variabel penampung
	// 		$maxChar=0;
	// 		$tmpString='';
			
	// 	}
	// 	//dapatkan jumlah baris
	// 	$line=count($textArray);
	// }
    //     //tulis selnya
	// 	$pdf->SetFillColor(255,255,255);
    //     $pdf->SetFont('Times', '', 8);
    //     $pdf->Cell(8, ($line * $cellHeight), $no++, 1, 0, 'C');
    //     $pdf->Cell(25, ($line * $cellHeight), $id['kode_barang'], 1, 0, 'C');
        
    //     //memanfaatkan MultiCell sebagai ganti Cell
	// 	//atur posisi xy untuk sel berikutnya menjadi di sebelahnya.
	// 	//ingat posisi x dan y sebelum menulis MultiCell
	// 	$xPos=$pdf->GetX();
	// 	$yPos=$pdf->GetY();
	// 	$pdf->MultiCell($cellWidth,$cellHeight,$line,1);

	// 	//kembalikan posisi untuk sel berikutnya di samping MultiCell 
	// 	//dan offset x dengan lebar MultiCell
	// 	$pdf->SetXY($xPos + $cellWidth , $yPos);
	// 	$pdf->Cell(25, ($line * $cellHeight), 'Rp. '.number_format($id['harga_beli'],1), 1, 0, 'C');
	// 	$pdf->Cell(25, ($line * $cellHeight), 'Rp. '.number_format($id['harga_jual'],1), 1, 0, 'C');
	// 	$pdf->Cell(30, ($line * $cellHeight), $id['total_stock'], 1, 0, 'C');
	// 	$pdf->Cell(40, ($line * $cellHeight), 'Rp. '.number_format($keuntungan,1), 1, 1, 'C');

}

$pdf->Output();
