<?php
require_once __DIR__ . '/../../src/controller/LaporanHarianController.php';
require_once __DIR__ . '/../../database/db_connection.php';

session_start();  // Mulai session

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil data level user dan username dari session
$userLevel = $_SESSION['user']['level'];
$userName = $_SESSION['user']['username']; // Ambil username dari session

// Periksa apakah level user adalah 'customer'
if ($userLevel === 'customer') {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Membuat objek controller dengan PDO yang sudah ada
$controller = new LaporanHarianController($pdo);

// Memeriksa apakah id laporan harian ada di query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Memanggil fungsi delete untuk menghapus laporan
    $controller->deleteLaporanHarian($id);

    // Redirect setelah delete berhasil
    header("Location: laporanHarian.php");
    exit();
} else {
    echo "ID laporan tidak ditemukan!";
    exit();
}
?>