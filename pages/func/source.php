<?php
include '../config/koneksi.php';
// Deklarasi variable keyword search.
$search = $_GET["query"];

// Query ke database.
$query  = $conn->query("SELECT * FROM databarang WHERE kode_barang LIKE '%$search%' OR nama_barang LIKE '%$search%' ORDER BY kode_barang ASC");
$result = $query->fetch_all(MYSQLI_ASSOC);

// Format bentuk data untuk autocomplete.
foreach($result as $data) {
    $output['suggestions'][] = [
        'value' => $data['kode_barang']." | ".$data['nama_barang'],
        'id' => $data['kode_barang'],
        'kode_barang'  => $data['kode_barang']." | ".$data['nama_barang']
    ];
}

if (! empty($output)) {
    // Encode ke format JSON.
    echo json_encode($output);
}

?>