<?php
require_once __DIR__ . '/../../src/controller/PemberhentianController.php';
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
if ($userLevel !== 'admin' && $userLevel !== 'superAdmin') {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

$controller = new PemberhentianController($pdo);
$id = $_GET['id'];
$controller->deletePemberhentian($id);

header("Location: pemberhentian.php");
exit();
?>