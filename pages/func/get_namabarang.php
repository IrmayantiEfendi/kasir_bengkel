<?php
include '../config/koneksi.php';
$kode_barang = $_GET['kode_barang'];
    $query = mysqli_query($conn, "SELECT * FROM databarang WHERE kode_barang='$kode_barang'");
	while ($row = mysqli_fetch_array($query)) {
        echo $row['nama_barang'];
	}
?>