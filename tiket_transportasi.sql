-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Des 2024 pada 03.12
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
(1, 'public/gambar/bus/6751b03f05752.jpg', 'Ekonomi1', 'ekonomi', 'Bus ekonomi adalah jenis transportasi umum dengan harga tiket yang terjangkau dan fasilitas dasar untuk kenyamanan penumpang. Bus ini biasanya dilengkapi dengan kursi standar tanpa fitur tambahan seperti sandaran kaki atau pengatur suhu individu. Kapasitas bus dirancang untuk mengangkut penumpang dalam jumlah besar, sehingga cocok untuk perjalanan jarak dekat hingga menengah dengan anggaran yang ekonomis. Meskipun fasilitasnya sederhana, bus ekonomi tetap memperhatikan keselamatan dengan sistem keamanan standar dan jadwal keberangkatan yang terorganisir.', 30),
(2, 'public/gambar/bus/6751b0a08ae36.jpg', 'VIP1', 'vip', 'Bus VIP adalah layanan transportasi premium yang dirancang untuk memberikan kenyamanan dan pengalaman perjalanan yang lebih eksklusif. Fasilitas di dalam bus VIP mencakup kursi yang lebih lebar dan empuk, sering kali dilengkapi dengan pengatur sandaran dan sandaran kaki untuk kenyamanan maksimal. Beberapa bus juga menyediakan hiburan individu, seperti layar TV pribadi, Wi-Fi, dan colokan listrik. Penumpang juga biasanya mendapatkan layanan tambahan seperti air mineral gratis dan pendingin udara yang lebih baik. Dengan ruang kaki yang lebih luas dan suasana yang lebih tenang, bus VIP menjadi pilihan ideal untuk perjalanan jarak jauh dengan kenyamanan setara kelas bisnis.', 30),
(3, 'public/gambar/bus/6751b1063e6bf.jpg', 'VVIP', 'vvip', 'Bus VVIP adalah kelas transportasi paling mewah yang menawarkan pengalaman perjalanan eksklusif dan penuh kenyamanan. Dilengkapi dengan kursi ergonomis berbahan premium yang dapat direbahkan hingga hampir 180 derajat, bus VVIP memberikan sensasi perjalanan seperti berada di kabin kelas satu. Setiap kursi dilengkapi dengan layar hiburan pribadi, colokan USB atau listrik, meja lipat, dan fasilitas tambahan seperti selimut, bantal, serta headphone.\r\n\r\nLayanan di dalam bus meliputi Wi-Fi berkecepatan tinggi, pendingin udara canggih, serta minuman dan makanan ringan gratis. Beberapa bus VVIP juga menawarkan kabin pribadi atau partisi untuk menjaga privasi penumpang. Dengan interior elegan dan layanan prima, bus VVIP adalah pilihan sempurna untuk perjalanan jarak jauh yang mewah dan bebas stres.', 30),
(4, 'public/gambar/bus/6751b139a7af3.jpg', 'ekonomi2', 'ekonomi', 'Bus ekonomi adalah jenis transportasi umum dengan harga tiket yang terjangkau dan fasilitas dasar untuk kenyamanan penumpang. Bus ini biasanya dilengkapi dengan kursi standar tanpa fitur tambahan seperti sandaran kaki atau pengatur suhu individu. Kapasitas bus dirancang untuk mengangkut penumpang dalam jumlah besar, sehingga cocok untuk perjalanan jarak dekat hingga menengah dengan anggaran yang ekonomis. Meskipun fasilitasnya sederhana, bus ekonomi tetap memperhatikan keselamatan dengan sistem keamanan standar dan jadwal keberangkatan yang terorganisir.', 30),
(5, 'public/gambar/bus/6751b15f8284a.jpg', 'ekonomi3', 'ekonomi', 'Bus ekonomi adalah jenis transportasi umum dengan harga tiket yang terjangkau dan fasilitas dasar untuk kenyamanan penumpang. Bus ini biasanya dilengkapi dengan kursi standar tanpa fitur tambahan seperti sandaran kaki atau pengatur suhu individu. Kapasitas bus dirancang untuk mengangkut penumpang dalam jumlah besar, sehingga cocok untuk perjalanan jarak dekat hingga menengah dengan anggaran yang ekonomis. Meskipun fasilitasnya sederhana, bus ekonomi tetap memperhatikan keselamatan dengan sistem keamanan standar dan jadwal keberangkatan yang terorganisir.', 30),
(6, 'public/gambar/bus/6751b1a4659a3.jpg', 'VIP2', 'vip', 'Bus VIP adalah layanan transportasi premium yang dirancang untuk memberikan kenyamanan dan pengalaman perjalanan yang lebih eksklusif. Fasilitas di dalam bus VIP mencakup kursi yang lebih lebar dan empuk, sering kali dilengkapi dengan pengatur sandaran dan sandaran kaki untuk kenyamanan maksimal. Beberapa bus juga menyediakan hiburan individu, seperti layar TV pribadi, Wi-Fi, dan colokan listrik. Penumpang juga biasanya mendapatkan layanan tambahan seperti air mineral gratis dan pendingin udara yang lebih baik. Dengan ruang kaki yang lebih luas dan suasana yang lebih tenang, bus VIP menjadi pilihan ideal untuk perjalanan jarak jauh dengan kenyamanan setara kelas bisnis.', 30),
(7, 'public/gambar/bus/6751b1d5b350d.jpg', 'VVIP2', 'vvip', 'Bus VVIP adalah kelas transportasi paling mewah yang menawarkan pengalaman perjalanan eksklusif dan penuh kenyamanan. Dilengkapi dengan kursi ergonomis berbahan premium yang dapat direbahkan hingga hampir 180 derajat, bus VVIP memberikan sensasi perjalanan seperti berada di kabin kelas satu. Setiap kursi dilengkapi dengan layar hiburan pribadi, colokan USB atau listrik, meja lipat, dan fasilitas tambahan seperti selimut, bantal, serta headphone.', 30);

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
  `harga` decimal(10,2) NOT NULL,
  `datetime_keberangkatan` datetime NOT NULL,
  `datetime_sampai` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal_bus`
--

INSERT INTO `jadwal_bus` (`id_jadwal_bus`, `id_bus`, `rute_keberangkatan`, `rute_transit`, `rute_tujuan`, `harga`, `datetime_keberangkatan`, `datetime_sampai`) VALUES
(1, 1, 1, 3, 3, 200000.00, '2025-01-22 21:04:00', '2025-01-31 21:05:00'),
(2, 2, 1, 2, 4, 300000.00, '2025-01-14 21:05:00', '2025-01-31 21:05:00'),
(3, 3, 1, 3, 3, 400000.00, '2025-01-22 21:06:00', '2025-01-31 21:06:00'),
(4, 3, 1, NULL, 3, 400000.00, '2025-01-22 21:06:00', '2025-01-31 21:06:00'),
(5, 4, 2, 4, 1, 300000.00, '2025-01-23 21:07:00', '2025-02-03 21:07:00'),
(6, 5, 3, 6, 4, 400000.00, '2025-01-15 21:08:00', '2025-01-31 21:08:00');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `nomor_kursi`
--

CREATE TABLE `nomor_kursi` (
  `id` int NOT NULL,
  `id_bus` int NOT NULL,
  `id_jadwal_bus` int NOT NULL,
  `nomor_kursi` varchar(10) NOT NULL,
  `status` enum('available','booked','occupied') DEFAULT 'available',
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `nomor_kursi`
--

INSERT INTO `nomor_kursi` (`id`, `id_bus`, `id_jadwal_bus`, `nomor_kursi`, `status`, `id_user`) VALUES
(86, 2, 2, '1', 'available', NULL),
(87, 2, 2, '2', 'available', NULL),
(88, 2, 2, '3', 'available', NULL),
(89, 2, 2, '4', 'available', NULL),
(90, 2, 2, '5', 'available', NULL),
(91, 2, 2, '6', 'available', NULL),
(92, 2, 2, '7', 'available', NULL),
(93, 2, 2, '8', 'available', NULL),
(94, 2, 2, '9', 'available', NULL),
(95, 2, 2, '10', 'available', NULL),
(96, 2, 2, '11', 'available', NULL),
(97, 2, 2, '12', 'available', NULL),
(98, 2, 2, '13', 'available', NULL),
(99, 2, 2, '14', 'available', NULL),
(100, 2, 2, '15', 'available', NULL),
(101, 2, 2, '16', 'available', NULL),
(102, 2, 2, '17', 'available', NULL),
(103, 2, 2, '18', 'available', NULL),
(104, 2, 2, '19', 'available', NULL),
(105, 2, 2, '20', 'available', NULL),
(106, 2, 2, '21', 'available', NULL),
(107, 2, 2, '22', 'available', NULL),
(108, 2, 2, '23', 'available', NULL),
(109, 2, 2, '24', 'available', NULL),
(110, 2, 2, '25', 'available', NULL),
(111, 2, 2, '26', 'available', NULL),
(112, 2, 2, '27', 'available', NULL),
(113, 2, 2, '28', 'available', NULL),
(114, 2, 2, '29', 'available', NULL),
(115, 2, 2, '30', 'available', NULL),
(116, 1, 1, '1', 'available', NULL),
(117, 1, 1, '2', 'available', NULL),
(118, 1, 1, '3', 'available', NULL),
(119, 1, 1, '4', 'available', NULL),
(120, 1, 1, '5', 'available', NULL),
(121, 1, 1, '6', 'available', NULL),
(122, 1, 1, '7', 'available', NULL),
(123, 1, 1, '8', 'available', NULL),
(124, 1, 1, '9', 'available', NULL),
(125, 1, 1, '10', 'available', NULL),
(126, 1, 1, '11', 'available', NULL),
(127, 1, 1, '12', 'available', NULL),
(128, 1, 1, '13', 'available', NULL),
(129, 1, 1, '14', 'available', NULL),
(130, 1, 1, '15', 'available', NULL),
(131, 1, 1, '16', 'available', NULL),
(132, 1, 1, '17', 'available', NULL),
(133, 1, 1, '18', 'available', NULL),
(134, 1, 1, '19', 'available', NULL),
(135, 1, 1, '20', 'available', NULL),
(136, 1, 1, '21', 'available', NULL),
(137, 1, 1, '22', 'available', NULL),
(138, 1, 1, '23', 'available', NULL),
(139, 1, 1, '24', 'available', NULL),
(140, 1, 1, '25', 'available', NULL),
(141, 1, 1, '26', 'available', NULL),
(142, 1, 1, '27', 'available', NULL),
(143, 1, 1, '28', 'available', NULL),
(144, 1, 1, '29', 'available', NULL),
(145, 1, 1, '30', 'available', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `id_user` int NOT NULL,
  `tagihan` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah_bayar` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `id_user`, `tagihan`, `metode_pembayaran`, `tanggal_pembayaran`, `jumlah_bayar`) VALUES
(8, 1, 5, 300000.00, 'Transfer Bank', '2024-12-05 15:10:36', 300000.00);

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
(1, 'Rest Area Jogja 1', 'Jogja'),
(2, 'Rest Area Bandung 1', 'Bandung'),
(3, 'Rest Area Karawang 1', 'Karawang'),
(4, 'Rest Area Jogja 2', 'Jogja'),
(5, 'Rest Area Bali 1', 'Bali'),
(6, 'Rest Area Bandung 2', 'Bandung');

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
  `tagihan` decimal(10,2) NOT NULL,
  `tenggat_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_user`, `id_jadwal_bus`, `tanggal_pemesanan`, `nomor_kursi`, `status`, `tagihan`, `tenggat_waktu`) VALUES
(1, 5, 2, '2024-12-05 14:28:53', '1', 'confirmed', 0.00, '2025-01-14 18:05:00'),
(2, 5, 2, '2024-12-05 14:31:02', '2', 'pending', 300000.00, '2025-01-14 18:05:00'),
(3, 5, 2, '2024-12-05 14:31:19', '3', 'pending', 300000.00, '2025-01-14 18:05:00'),
(4, 5, 2, '2024-12-05 14:31:46', '4', 'pending', 300000.00, '2025-01-14 18:05:00'),
(5, 5, 2, '2024-12-05 14:32:49', '5', 'pending', 300000.00, '2025-01-14 18:05:00'),
(6, 5, 2, '2024-12-05 14:33:32', '6', 'pending', 300000.00, '2025-01-14 18:05:00'),
(7, 5, 1, '2024-12-05 15:03:25', '1', 'cancelled', 200000.00, '2025-01-22 18:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int NOT NULL,
  `id_user` int NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca') DEFAULT 'baru',
  `tanggal_kirim` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 'Karawang', 'Terminal Karawang'),
(2, 'Jogja', 'Terminal Jogja'),
(3, 'Jakarta', 'Terminal Jakarta'),
(4, 'Bandung', 'Terminal Bandung');

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
(1, 1, 5, 2, '1');

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
(5, 'beni', 'benibeni@gmail.com', '$2y$10$E2WPuawJcVdctNLgLPWaGez/3OgfpD1u.1Ew1cFm1upsnodkf/UWG', 'customer'),
(6, 'admin', 'admin@gmail.com', '$2y$10$hh6X5v1DNZIUdAVFDBMHlOAa9B57AMkQLvwH3u/y4t6zw0eSYdkAe', 'admin'),
(7, 'petugas', 'petugas@gmail.com', '$2y$10$Hs1wQTf29xDXpfnsW6.SoOUBMqHvltY/mZWBlE6EyZ1zeI9g/9taS', 'petugas'),
(8, 'superadmin', 'superadmin@gmail.com', '$2y$10$oqpCTHyMC0.FP3MAX36KpuxyHP5ERmmqNeH.oaDl6i2DYC24QHcxa', 'superadmin');

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
-- Indeks untuk tabel `nomor_kursi`
--
ALTER TABLE `nomor_kursi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bus` (`id_bus`),
  ADD KEY `id_jadwal_bus` (`id_jadwal_bus`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
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
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id_bus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jadwal_bus`
--
ALTER TABLE `jadwal_bus`
  MODIFY `id_jadwal_bus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  MODIFY `id_laporan_harian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_khusus`
--
ALTER TABLE `laporan_khusus`
  MODIFY `id_laporan_khusus` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nomor_kursi`
--
ALTER TABLE `nomor_kursi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pemberhentian`
--
ALTER TABLE `pemberhentian`
  MODIFY `id_pemberhentian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `terminal`
--
ALTER TABLE `terminal`
  MODIFY `id_terminal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Ketidakleluasaan untuk tabel `nomor_kursi`
--
ALTER TABLE `nomor_kursi`
  ADD CONSTRAINT `nomor_kursi_ibfk_1` FOREIGN KEY (`id_bus`) REFERENCES `bus` (`id_bus`),
  ADD CONSTRAINT `nomor_kursi_ibfk_2` FOREIGN KEY (`id_jadwal_bus`) REFERENCES `jadwal_bus` (`id_jadwal_bus`),
  ADD CONSTRAINT `nomor_kursi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_jadwal_bus`) REFERENCES `jadwal_bus` (`id_jadwal_bus`);

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

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
