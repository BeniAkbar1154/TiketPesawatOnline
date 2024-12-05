<?php
require_once '../../database/db_connection.php';
require_once '../../src/controller/PesanController.php';

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

$pesanController = new PesanController($pdo);

if (isset($_GET['id'])) {
    if ($pesanController->delete($_GET['id'])) {
        header("Location: pesan.php");
        exit();
    } else {
        echo "Gagal menghapus pesan.";
    }
}
?>