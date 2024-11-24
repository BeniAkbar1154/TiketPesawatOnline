<?php
require_once __DIR__ . '/../../src/controller/LaporanHarianController.php';
require_once __DIR__ . '/../../database/db_connection.php';

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