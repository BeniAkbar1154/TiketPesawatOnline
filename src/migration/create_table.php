<?php
function createUserTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS user (
        id_user INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        level ENUM('customer', 'petugas', 'admin', 'superadmin') DEFAULT 'customer'
    );
    ";
    $pdo->exec($sql);
}

function createBusTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS bus (
        id_bus INT AUTO_INCREMENT PRIMARY KEY,
        gambar VARCHAR(255) DEFAULT NULL,
        nama VARCHAR(100) NOT NULL,
        tipe ENUM('ekonomi', 'vip', 'vvip') NOT NULL,
        deskripsi TEXT DEFAULT NULL,
        kapasitas INT NOT NULL
    );
    ";
    $pdo->exec($sql);
}

function createTerminalTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS terminal (
        id_terminal INT AUTO_INCREMENT PRIMARY KEY,
        lokasi_terminal VARCHAR(255) NOT NULL,
        nama_terminal VARCHAR(100) NOT NULL
    );
    ";
    $pdo->exec($sql);
}

function createPemberhentianTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS pemberhentian (
        id_pemberhentian INT AUTO_INCREMENT PRIMARY KEY,
        nama_pemberhentian VARCHAR(100) NOT NULL
    );
    ";
    $pdo->exec($sql);
}

function createJadwalBusTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS jadwal_bus (
        id_jadwal_bus INT AUTO_INCREMENT PRIMARY KEY,
        id_bus INT NOT NULL,
        rute_keberangkatan INT NOT NULL,
        rute_transit INT DEFAULT NULL,
        rute_tujuan INT NOT NULL,
        jam_keberangkatan TIME NOT NULL,
        jam_sampai TIME NOT NULL,
        harga DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (id_bus) REFERENCES bus(id_bus),
        FOREIGN KEY (rute_keberangkatan) REFERENCES terminal(id_terminal),
        FOREIGN KEY (rute_transit) REFERENCES pemberhentian(id_pemberhentian),
        FOREIGN KEY (rute_tujuan) REFERENCES terminal(id_terminal)
    );
    ";
    $pdo->exec($sql);
}

function createPemesananTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS pemesanan (
        id_pemesanan INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_jadwal_bus INT NOT NULL,
        tanggal_pemesanan DATETIME NOT NULL,
        nomor_kursi VARCHAR(10) NOT NULL,
        status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
        tenggat_waktu DATETIME NOT NULL,
        FOREIGN KEY (id_user) REFERENCES user(id_user),
        FOREIGN KEY (id_jadwal_bus) REFERENCES jadwal_bus(id_jadwal_bus)
    );
    ";
    $pdo->exec($sql);
}

function createTiketTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS tiket (
        id_tiket INT AUTO_INCREMENT PRIMARY KEY,
        id_pemesanan INT NOT NULL,
        id_user INT NOT NULL,
        id_jadwal_bus INT NOT NULL,
        nomor_kursi VARCHAR(10) NOT NULL,
        FOREIGN KEY (id_pemesanan) REFERENCES pemesanan(id_pemesanan),
        FOREIGN KEY (id_user) REFERENCES user(id_user),
        FOREIGN KEY (id_jadwal_bus) REFERENCES jadwal_bus(id_jadwal_bus)
    );
    ";
    $pdo->exec($sql);
}

function createLaporanHarianTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS laporan_harian (
        id_laporan_harian INT AUTO_INCREMENT PRIMARY KEY,
        id_bus INT NOT NULL,
        tanggal DATE NOT NULL,
        waktu TIME NOT NULL,
        kondisi_teknis TEXT DEFAULT NULL,
        kondisi_kebersihan TEXT DEFAULT NULL,
        bahan_bakar TEXT DEFAULT NULL,
        kondisi_jalan TEXT DEFAULT NULL,
        ketepatan_jadwal TEXT DEFAULT NULL,
        keselamatan TEXT DEFAULT NULL,
        FOREIGN KEY (id_bus) REFERENCES bus(id_bus)
    );
    ";
    $pdo->exec($sql);
}

function createLaporanKhususTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS laporan_khusus (
        id_laporan_khusus INT AUTO_INCREMENT PRIMARY KEY,
        id_bus INT DEFAULT NULL,
        id_user INT DEFAULT NULL,
        tanggal DATE NOT NULL,
        jadwal VARCHAR(255) NOT NULL,
        masalah TEXT DEFAULT NULL,
        FOREIGN KEY (id_bus) REFERENCES bus(id_bus),
        FOREIGN KEY (id_user) REFERENCES user(id_user)
    );
    ";
    $pdo->exec($sql);
}
?>