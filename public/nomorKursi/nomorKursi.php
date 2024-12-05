<?php
require_once '../../database/db_connection.php'; // File koneksi Anda
require_once '../../src/controller/NomorKursiController.php';

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

// Inisialisasi controller dengan $pdo dari db_connection.php
$nomorKursiController = new NomorKursiController($pdo);

// Ambil ID Bus dari URL
$id_bus = $_GET['id_bus'] ?? null;
if (!$id_bus) {
    die('Bus tidak ditemukan.');
}

// Ambil data kursi berdasarkan ID Bus
$kursi = $nomorKursiController->index($id_bus);
?>

<div class="container mt-5">
    <h1>Nomor Kursi untuk Bus ID: <?= htmlspecialchars($id_bus) ?></h1>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nomor Kursi</th>
                <th>Status</th>
                <th>Nama User</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kursi as $k): ?>
                <tr>
                    <td><?= htmlspecialchars($k['nomor_kursi']) ?></td>
                    <td><?= htmlspecialchars($k['status']) ?></td>
                    <td><?= htmlspecialchars($k['nama_user'] ?? 'Belum Dipesan') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>