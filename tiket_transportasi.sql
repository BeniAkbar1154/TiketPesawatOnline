-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Nov 2024 pada 14.01
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiket_transportasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus`
--

CREATE TABLE `bus` (
  `id_bus` int NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe` enum('ekonomi','vip','vvip') NOT NULL,
  `deskripsi` text,
  `kapasitas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bus`
--

INSERT INTO `bus` (`id_bus`, `gambar`, `nama`, `tipe`, `deskripsi`, `kapasitas`) VALUES
(1, '', 'Bus Ekonomi 1', 'ekonomi', 'Bus Ekonomi dengan kapasitas 40 penumpang', 40),
(2, '', 'Bus VIP 1', 'vip', 'Bus VIP dengan kapasitas 30 penumpang', 30),
(3, '', 'Bus VVIP 1', 'vvip', 'Bus VVIP dengan kapasitas 20 penumpang', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_bus`
--

CREATE TABLE `jadwal_bus` (
  `id_jadwal_bus` int NOT NULL,
  `id_bus` int NOT NULL,
  `rute_keberangkatan` int NOT NULL,
  `rute_transit` int DEFAULT NULL,
  `rute_tujuan` int NOT NULL,
  `jam_keberangkatan` time NOT NULL,
  `jam_sampai` time NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal_bus`
--

INSERT INTO `jadwal_bus` (`id_jadwal_bus`, `id_bus`, `rute_keberangkatan`, `rute_transit`, `rute_tujuan`, `jam_keberangkatan`, `jam_sampai`, `harga`) VALUES
(1, 1, 1, NULL, 2, '08:00:00', '12:00:00', 100000.00),
(2, 2, 2, 1, 3, '09:00:00', '13:00:00', 150000.00),
(3, 3, 3, NULL, 1, '10:00:00', '14:00:00', 200000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_harian`
--

CREATE TABLE `laporan_harian` (
  `id_laporan_harian` int NOT NULL,
  `id_bus` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `kondisi_teknis` text,
  `kondisi_kebersihan` text,
  `bahan_bakar` text,
  `kondisi_jalan` text,
  `ketepatan_jadwal` text,
  `keselamatan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `laporan_harian`
--

INSERT INTO `laporan_harian` (`id_laporan_harian`, `id_bus`, `tanggal`, `waktu`, `kondisi_teknis`, `kondisi_kebersihan`, `bahan_bakar`, `kondisi_jalan`, `ketepatan_jadwal`, `keselamatan`) VALUES
(1, 1, '2024-11-01', '08:00:00', 'Baik', 'Bersih', 'Cukup', 'Mulus', 'Tepat Waktu', 'Aman'),
(2, 2, '2024-11-02', '09:00:00', 'Baik', 'Bersih', 'Penuh', 'Banyak Lubang', 'Tepat Waktu', 'Aman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_khusus`
--

CREATE TABLE `laporan_khusus` (
  `id_laporan_khusus` int NOT NULL,
  `id_bus` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `masalah` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `laporan_khusus`
--

INSERT INTO `laporan_khusus` (`id_laporan_khusus`, `id_bus`, `id_user`, `tanggal`, `masalah`) VALUES
(1, NULL, NULL, '2024-11-25', 'Tidak ada masalah pada sistem.'),
(2, NULL, 1, '2024-11-25', 'Masalah dengan pengguna: Tidak hadir pada waktu keberangkatan.'),
(3, 2, NULL, '2024-11-25', 'Masalah dengan bus: Kerusakan mesin saat perjalanan.'),
(4, 1, 3, '2024-11-25', 'Masalah pada pengguna: Laporan kehilangan barang.'),
(5, NULL, NULL, '2024-11-25', 'Laporan rutin tanpa masalah yang tercatat.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemberhentian`
--

CREATE TABLE `pemberhentian` (
  `id_pemberhentian` int NOT NULL,
  `nama_pemberhentian` varchar(100) NOT NULL,
  `lokasi_pemberhentian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemberhentian`
--

INSERT INTO `pemberhentian` (`id_pemberhentian`, `nama_pemberhentian`, `lokasi_pemberhentian`) VALUES
(1, 'Pemberhentian 1', 'Lokasi 1'),
(2, 'Pemberhentian 2', 'Lokasi 2'),
(3, 'Pemberhentian 3', 'Lokasi 3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int NOT NULL,
  `id_user` int NOT NULL,
  `id_jadwal_bus` int NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL,
  `nomor_kursi` varchar(10) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `tenggat_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_user`, `id_jadwal_bus`, `tanggal_pemesanan`, `nomor_kursi`, `status`, `tenggat_waktu`) VALUES
(1, 4, 1, '2024-11-01 08:00:00', 'A1', 'pending', '2024-11-01 12:00:00'),
(2, 4, 2, '2024-11-02 09:00:00', 'B2', 'confirmed', '2024-11-02 13:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `terminal`
--

CREATE TABLE `terminal` (
  `id_terminal` int NOT NULL,
  `lokasi_terminal` varchar(255) NOT NULL,
  `nama_terminal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `terminal`
--

INSERT INTO `terminal` (`id_terminal`, `lokasi_terminal`, `nama_terminal`) VALUES
(1, 'Jakarta', 'Terminal Jakarta'),
(2, 'Bandung', 'Terminal Bandung'),
(3, 'Surabaya', 'Terminal Surabaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `id_user` int NOT NULL,
  `id_jadwal_bus` int NOT NULL,
  `nomor_kursi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `id_pemesanan`, `id_user`, `id_jadwal_bus`, `nomor_kursi`) VALUES
(1, 1, 4, 1, 'A1'),
(2, 2, 4, 2, 'B2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('customer','petugas','admin','superadmin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `level`) VALUES
(1, 'superadmin', 'superadmin@example.com', '$2y$10$VGsVoMyq182Oc8ViaqqLW.ae3wAs93G4d0zgIbu.VMmAswoic2V7a', 'superadmin'),
(2, 'admin', 'admin@example.com', '$2y$10$WaN5gWqwRZi3sXOeB0xa8.6c5HPhusM.FlzPCLsPVG5Cq4ZbzqoMS', 'admin'),
(3, 'petugas', 'petugas@example.com', '$2y$10$cUgGV2RnBDt.iEBPiQ2pmuwvNK8e/QU8Wzl/Zcs9C0Ac8H.w5nabe', 'petugas'),
(4, 'customer', 'customer@example.com', '$2y$10$3buZRgXWTEN//QdIOjUhHeTsXuMgQiwH.J33GU6J86rQ2sfObswF6', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id_bus`);

--
-- Indeks untuk tabel `jadwal_bus`
--
ALTER TABLE `jadwal_bus`
  ADD PRIMARY KEY (`id_jadwal_bus`),
  ADD KEY `id_bus` (`id_bus`),
  ADD KEY `rute_keberangkatan` (`rute_keberangkatan`),
  ADD KEY `rute_transit` (`rute_transit`),
  ADD KEY `rute_tujuan` (`rute_tujuan`);

--
-- Indeks untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD PRIMARY KEY (`id_laporan_harian`),
  ADD KEY `id_bus` (`id_bus`);

--
-- Indeks untuk tabel `laporan_khusus`
--
ALTER TABLE `laporan_khusus`
  ADD PRIMARY KEY (`id_laporan_khusus`),
  ADD KEY `id_bus` (`id_bus`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pemberhentian`
--
ALTER TABLE `pemberhentian`
  ADD PRIMARY KEY (`id_pemberhentian`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jadwal_bus` (`id_jadwal_bus`);

--
-- Indeks untuk tabel `terminal`
--
ALTER TABLE `terminal`
  ADD PRIMARY KEY (`id_terminal`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jadwal_bus` (`id_jadwal_bus`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bus`
--
ALTER TABLE `bus`
  MODIFY `id_bus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal_bus`
--
ALTER TABLE `jadwal_bus`
  MODIFY `id_jadwal_bus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  MODIFY `id_laporan_harian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `laporan_khusus`
--
ALTER TABLE `laporan_khusus`
  MODIFY `id_laporan_khusus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pemberhentian`
--
ALTER TABLE `pemberhentian`
  MODIFY `id_pemberhentian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `terminal`
--
ALTER TABLE `terminal`
  MODIFY `id_terminal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_bus`
--
ALTER TABLE `jadwal_bus`
  ADD CONSTRAINT `jadwal_bus_ibfk_1` FOREIGN KEY (`id_bus`) REFERENCES `bus` (`id_bus`),
  ADD CONSTRAINT `jadwal_bus_ibfk_2` FOREIGN KEY (`rute_keberangkatan`) REFERENCES `terminal` (`id_terminal`),
  ADD CONSTRAINT `jadwal_bus_ibfk_3` FOREIGN KEY (`rute_transit`) REFERENCES `pemberhentian` (`id_pemberhentian`),
  ADD CONSTRAINT `jadwal_bus_ibfk_4` FOREIGN KEY (`rute_tujuan`) REFERENCES `terminal` (`id_terminal`);

--
-- Ketidakleluasaan untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD CONSTRAINT `laporan_harian_ibfk_1` FOREIGN KEY (`id_bus`) REFERENCES `bus` (`id_bus`);

--
-- Ketidakleluasaan untuk tabel `laporan_khusus`
--
ALTER TABLE `laporan_khusus`
  ADD CONSTRAINT `laporan_khusus_ibfk_1` FOREIGN KEY (`id_bus`) REFERENCES `bus` (`id_bus`),
  ADD CONSTRAINT `laporan_khusus_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_jadwal_bus`) REFERENCES `jadwal_bus` (`id_jadwal_bus`);

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`),
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `tiket_ibfk_3` FOREIGN KEY (`id_jadwal_bus`) REFERENCES `jadwal_bus` (`id_jadwal_bus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
