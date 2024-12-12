<?php
require_once __DIR__ . '/../../src/controller/BusController.php';
require_once __DIR__ . '/../../database/db_connection.php';

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

$busController = new BusController($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $busController->deleteBus($id);
        header('Location: bus.php');
        exit;
    } catch (Exception $e) {
        echo "Gagal menghapus bus: " . $e->getMessage();
    }
}
?>