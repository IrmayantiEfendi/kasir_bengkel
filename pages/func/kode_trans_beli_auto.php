<?php
require 'config/koneksi.php';

// mengambil data barang dengan kode paling besar
$query = mysqli_query($conn, "SELECT max(no_trans_beli) as kodeTerbesar FROM faktur_beli");
$data = mysqli_fetch_array($query);
$no_trans_beli = $data['kodeTerbesar'];

// mengambil angka dari kode barang terbesar, menggunakan fungsi substr
// dan diubah ke integer dengan (int)
$urutan = (int) substr($no_trans_beli, 4, 4);
 
// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
$urutan++;
 
// membentuk kode barang baru
// perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
// misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
$huruf          = "INV";
$no_trans_beli     = $huruf . sprintf("%04s", $urutan);
?>