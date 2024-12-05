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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = intval($_POST['id_user']);
    $pesan = trim($_POST['pesan']);

    if ($pesanController->create($id_user, $pesan)) {
        header("Location: pesan.php");
        exit();
    } else {
        echo "Gagal menambahkan pesan.";
    }
}
?>

<form method="POST" action="create.php">
    <label>ID User:</label>
    <input type="number" name="id_user" required>
    <br>
    <label>Pesan:</label>
    <textarea name="pesan" rows="5" required></textarea>
    <br>
    <button type="submit">Kirim</button>
</form>