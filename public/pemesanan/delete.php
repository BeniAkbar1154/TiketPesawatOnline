<?php
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

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: pemesanan.php?message=notfound');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pemesanan WHERE id_pemesanan = :id");
    $stmt->execute(['id' => $id]);
    header('Location: pemesanan.php?message=deleted');
    exit;
} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>