<?php
require_once '../../database/db_connection.php'; // Pastikan ini sesuai dengan lokasi db_connection.php
require_once __DIR__ . '/../../src/controller/JadwalBusController.php'; // Pastikan ini mengarah ke lokasi yang tepat untuk controller

session_start();  // Mulai session

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil data level user dari session
$userLevel = $_SESSION['user']['level'];

// Periksa apakah level user adalah 'customer'
if ($userLevel !== 'admin' && $userLevel !== 'superAdmin') {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Membuat instance JadwalBusController dengan objek PDO
$jadwalBusController = new JadwalBusController($pdo);

// Mengecek apakah ada parameter id di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Menghapus jadwal bus berdasarkan ID
        $jadwalBusController->deleteSchedule($id);

        // Redirect ke halaman jadwalBus.php setelah berhasil menghapus
        header('Location: jadwalBus.php');
        exit;
    } catch (Exception $e) {
        // Menampilkan pesan error jika terjadi kesalahan
        echo "Gagal menghapus jadwal: " . $e->getMessage();
    }
}
?>