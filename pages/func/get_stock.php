<?php
include '../config/koneksi.php';
$kode_barang = $_GET['kode_barang'];
    $query = mysqli_query($conn, "SELECT * FROM stockbarang WHERE kode_barang='$kode_barang'");
	while ($row = mysqli_fetch_array($query)) {
        echo $row['total_stock'];
	}
?>