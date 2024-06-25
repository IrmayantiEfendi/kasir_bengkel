-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2024 pada 07.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_bengkel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `databarang`
--

CREATE TABLE `databarang` (
  `kode_barang` varchar(10) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `nama_barang` varchar(250) NOT NULL,
  `harga_beli` double NOT NULL,
  `harga_jual` double NOT NULL,
  `stock_awal` double NOT NULL,
  `min_stock` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `databarang`
--
DELIMITER $$
CREATE TRIGGER `add_stock_awal` AFTER INSERT ON `databarang` FOR EACH ROW BEGIN
	INSERT INTO stockbarang(id_stock, kode_barang, total_stock, id_user) VALUES(NULL, NEW.kode_barang, NEW.stock_awal, NEW.id_user);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_stock_awal` AFTER DELETE ON `databarang` FOR EACH ROW BEGIN
	DELETE FROM stockbarang WHERE kode_barang=OLD.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_stock_awal` AFTER UPDATE ON `databarang` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=(total_stock-OLD.stock_awal)+NEW.stock_awal WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur_beli`
--

CREATE TABLE `faktur_beli` (
  `no_trans_beli` varchar(15) NOT NULL,
  `tgl_trans_beli` datetime NOT NULL,
  `total_qty_beli` double NOT NULL,
  `total_harga_beli` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur_jual`
--

CREATE TABLE `faktur_jual` (
  `no_trans_jual` varchar(15) NOT NULL,
  `tgl_trans_jual` datetime NOT NULL,
  `total_qty_jual` double NOT NULL,
  `total_harga_jual` double NOT NULL,
  `uang_bayar` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id_masuk` int(11) NOT NULL,
  `no_trans_beli` varchar(15) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty_masuk` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `pemasukan`
--
DELIMITER $$
CREATE TRIGGER `add_stock` AFTER INSERT ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=total_stock+NEW.qty_masuk WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_stock` AFTER DELETE ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=total_stock-OLD.qty_masuk WHERE kode_barang=OLD.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_stock` AFTER UPDATE ON `pemasukan` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=(total_stock-OLD.qty_masuk)+NEW.qty_masuk WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_keluar` int(11) NOT NULL,
  `no_trans_jual` varchar(15) NOT NULL,
  `tgl_keluar` datetime NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty_keluar` double NOT NULL,
  `diskon` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `edit_minus_stock` AFTER UPDATE ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=(total_stock+OLD.qty_keluar)-NEW.qty_keluar WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `minus_stock` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=total_stock-NEW.qty_keluar WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rollback_stock` AFTER DELETE ON `pengeluaran` FOR EACH ROW BEGIN
	UPDATE stockbarang SET total_stock=total_stock+OLD.qty_keluar WHERE kode_barang=OLD.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `req_tb_keluar`
--

CREATE TABLE `req_tb_keluar` (
  `id_req_keluar` int(11) NOT NULL,
  `id_keluar` int(11) NOT NULL,
  `no_trans_jual` varchar(15) NOT NULL,
  `tgl_keluar` datetime NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty_keluar` double NOT NULL,
  `diskon_keluar` double NOT NULL,
  `id_user_keluar` int(11) NOT NULL,
  `tgl_req` datetime NOT NULL,
  `kategori` varchar(25) NOT NULL,
  `req_qty_keluar` double NOT NULL,
  `req_diskon` double NOT NULL,
  `alasan` text NOT NULL,
  `req_admin` varchar(50) NOT NULL,
  `acc_admin` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `req_tb_masuk`
--

CREATE TABLE `req_tb_masuk` (
  `id_req_masuk` int(11) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `no_trans_beli` varchar(15) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `qty_masuk` double NOT NULL,
  `id_user_masuk` int(11) NOT NULL,
  `tgl_req` datetime NOT NULL,
  `kategori` varchar(25) NOT NULL,
  `req_qty_masuk` double NOT NULL,
  `alasan` text NOT NULL,
  `req_admin` varchar(50) NOT NULL,
  `acc_admin` varchar(15) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stockbarang`
--

CREATE TABLE `stockbarang` (
  `id_stock` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `total_stock` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `hari_libur` varchar(25) NOT NULL,
  `role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `alamat`, `no_hp`, `tgl_mulai`, `hari_libur`, `role`) VALUES
(1, 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'Tasikmalaya', '085123541165', '2023-05-04', 'Minggu', 'admin'),
(2, 'Super Admin', '17c4520f6cfd1ab53d8745e84681eb49', '', '', NULL, '', 'super admin'),
(6, 'Fitri', '534a0b7aa872ad1340d0071cbfa38697', 'Kp. Karangsari', '082321523645', '2022-03-02', 'Sabtu', 'admin'),
(7, 'encep', '70ce187d0bd84a44921d303c1ffab592', 'karanglayung', '087839006492', '2024-05-13', 'Jumat', 'admin'),
(8, 'encep', '70ce187d0bd84a44921d303c1ffab592', 'karanglayung', '087839006492', '2024-05-13', 'Jumat', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_keluar`
--

CREATE TABLE `temp_keluar` (
  `id_keluar_temp` int(11) NOT NULL,
  `no_trans_jual` varchar(15) NOT NULL,
  `tgl_keluar` datetime NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty_keluar` double NOT NULL,
  `diskon` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_masuk`
--

CREATE TABLE `temp_masuk` (
  `id_masuk_temp` int(11) NOT NULL,
  `no_trans_beli` varchar(15) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty_masuk` double NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `nama_toko` varchar(250) NOT NULL,
  `alamat_toko` text NOT NULL,
  `no_telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`nama_toko`, `alamat_toko`, `no_telp`) VALUES
('SANG TULODHO MOTOR', 'JL. Raya Karangnunggal, Kp. Sukahurip, Bantarkalong Tasik Selatan', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `databarang`
--
ALTER TABLE `databarang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD UNIQUE KEY `nama_barang` (`nama_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `faktur_beli`
--
ALTER TABLE `faktur_beli`
  ADD PRIMARY KEY (`no_trans_beli`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `faktur_jual`
--
ALTER TABLE `faktur_jual`
  ADD PRIMARY KEY (`no_trans_jual`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`kode_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `kode_barang` (`kode_barang`),
  ADD KEY `no_trans_jual` (`no_trans_jual`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `req_tb_keluar`
--
ALTER TABLE `req_tb_keluar`
  ADD PRIMARY KEY (`id_req_keluar`),
  ADD KEY `kode_masuk` (`id_keluar`),
  ADD KEY `id_user` (`req_admin`);

--
-- Indeks untuk tabel `req_tb_masuk`
--
ALTER TABLE `req_tb_masuk`
  ADD PRIMARY KEY (`id_req_masuk`),
  ADD KEY `kode_masuk` (`id_masuk`);

--
-- Indeks untuk tabel `stockbarang`
--
ALTER TABLE `stockbarang`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `temp_keluar`
--
ALTER TABLE `temp_keluar`
  ADD PRIMARY KEY (`id_keluar_temp`),
  ADD KEY `kode_barang` (`kode_barang`),
  ADD KEY `no_trans_jual` (`no_trans_jual`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `temp_masuk`
--
ALTER TABLE `temp_masuk`
  ADD PRIMARY KEY (`id_masuk_temp`),
  ADD KEY `id_barang` (`kode_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`nama_toko`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `req_tb_keluar`
--
ALTER TABLE `req_tb_keluar`
  MODIFY `id_req_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `req_tb_masuk`
--
ALTER TABLE `req_tb_masuk`
  MODIFY `id_req_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `stockbarang`
--
ALTER TABLE `stockbarang`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `temp_keluar`
--
ALTER TABLE `temp_keluar`
  MODIFY `id_keluar_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `temp_masuk`
--
ALTER TABLE `temp_masuk`
  MODIFY `id_masuk_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `databarang`
--
ALTER TABLE `databarang`
  ADD CONSTRAINT `databarang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `faktur_beli`
--
ALTER TABLE `faktur_beli`
  ADD CONSTRAINT `faktur_beli_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `faktur_jual`
--
ALTER TABLE `faktur_jual`
  ADD CONSTRAINT `faktur_jual_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD CONSTRAINT `pemasukan_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `databarang` (`kode_barang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pemasukan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `databarang` (`kode_barang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pengeluaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stockbarang`
--
ALTER TABLE `stockbarang`
  ADD CONSTRAINT `stockbarang_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `databarang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stockbarang_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `temp_keluar`
--
ALTER TABLE `temp_keluar`
  ADD CONSTRAINT `temp_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `temp_masuk`
--
ALTER TABLE `temp_masuk`
  ADD CONSTRAINT `temp_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
