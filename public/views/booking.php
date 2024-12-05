<?php
session_start();
require_once '../../database/db_connection.php'; // Koneksi database
require_once '../../src/controller/PemesananController.php'; // Controller Pemesanan

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: ../register/login.php");
    exit;
}

// Ambil ID User dari sesi
$id_user = $_SESSION['user']['id_user'];

// Ambil ID Jadwal Bus dari URL
$id_jadwal_bus = $_GET['id_jadwal_bus'] ?? null;
if (!$id_jadwal_bus || !is_numeric($id_jadwal_bus)) {
    die("Jadwal bus tidak ditemukan atau parameter tidak valid.");
}

// Inisialisasi controller pemesanan
$pemesananController = new PemesananController($pdo);

// Ambil data jadwal bus untuk validasi
$jadwal = $pemesananController->getJadwalById($id_jadwal_bus);
if (!$jadwal) {
    die("Jadwal bus tidak ditemukan.");
}
// print_r($jadwal);


// Debug: Periksa apakah data jadwal ada
// echo "<pre>";
// print_r($jadwal);
// echo "</pre>";

// Ambil kursi yang tersedia
$kursiTersedia = $pemesananController->getKursiTersedia($jadwal['id_bus'], $jadwal['id_jadwal_bus']);
if (empty($kursiTersedia)) {
    die("Tidak ada kursi yang tersedia untuk bus ini.");
}

// Debug: Periksa data kursi yang tersedia
// echo "<pre>";
// print_r($kursiTersedia);
// echo "</pre>";

// Ambil nomor kursi pertama yang tersedia
$nomor_kursi = $kursiTersedia[0]['nomor_kursi'];

// Buat data pemesanan
$tanggal_pemesanan = date('Y-m-d H:i:s');
$status = "pending";
$tagihan = $jadwal['harga'];

// Hitung tenggat waktu (3 jam sebelum waktu keberangkatan)
$tenggat_waktu = null;
if (!empty($jadwal['datetime_keberangkatan'])) {
    $tenggat_waktu = date('Y-m-d H:i:s', strtotime($jadwal['datetime_keberangkatan']) - 3 * 60 * 60);
} else {
    die("Waktu keberangkatan tidak ditemukan dalam jadwal bus.");
}

$hasil = $pemesananController->buatPemesanan([
    'id_user' => $id_user,
    'id_bus' => $jadwal['id_bus'], // Tambahkan id_bus dari data jadwal
    'id_jadwal_bus' => $id_jadwal_bus,
    'tanggal_pemesanan' => $tanggal_pemesanan,
    'nomor_kursi' => $nomor_kursi,
    'status' => $status,
    'tagihan' => $tagihan,
    'tenggat_waktu' => $tenggat_waktu,
]);


if ($hasil) {
    echo "Tiket berhasil dipesan! Nomor kursi Anda: $nomor_kursi Silahkan Cek Icon Notifikasi Untuk Membayar";
} else {
    // Ambil error info jika ada masalah dalam penyimpanan
    $errorInfo = $pdo->errorInfo();
    echo "Terjadi kesalahan saat memesan tiket. Error: " . $errorInfo[2];
}
?>