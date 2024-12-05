<?php
require_once '../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/UserController.php';

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

$userController = new UserController($pdo);

if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$id = $_GET['id'];

// Proses penghapusan data
if ($userController->deleteUser($id)) {
    header("Location: user.php?success=Pengguna berhasil dihapus.");
    exit;
} else {
    header("Location: user.php?error=Gagal menghapus pengguna.");
    exit;
}
