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
if ($userLevel === 'customer') {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

$controller = new PemberhentianController($pdo);
$id = $_GET['id'];
$pemberhentian = $controller->getPemberhentianById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama_pemberhentian' => $_POST['nama_pemberhentian'],
        'lokasi_pemberhentian' => $_POST['lokasi_pemberhentian']
    ];
    $controller->updatePemberhentian($id, $data);
    header("Location: pemberhentian.php");
    exit();
}
?>

<h1>Edit Pemberhentian</h1>
<form method="POST">
    <label>Nama Pemberhentian:</label>
    <input type="text" name="nama_pemberhentian"
        value="<?= htmlspecialchars($pemberhentian['nama_pemberhentian'] ?? '') ?>" required>
    <br>
    <label>Lokasi Pemberhentian:</label>
    <input type="text" name="lokasi_pemberhentian"
        value="<?= htmlspecialchars($pemberhentian['lokasi_pemberhentian'] ?? '') ?>" required>
    <br>
    <button type="submit">Simpan</button>
</form>