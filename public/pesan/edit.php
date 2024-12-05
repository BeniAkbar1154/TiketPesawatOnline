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
    $pesan = $pesanController->show($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pesan = intval($_POST['id_pesan']);
    $pesan_text = trim($_POST['pesan']);

    if ($pesanController->edit($id_pesan, $pesan_text)) {
        header("Location: pesan.php");
        exit();
    } else {
        echo "Gagal mengedit pesan.";
    }
}
?>

<form method="POST" action="edit.php">
    <input type="hidden" name="id_pesan" value="<?= $pesan['id_pesan'] ?>">
    <label>Pesan:</label>
    <textarea name="pesan" rows="5" required><?= $pesan['pesan'] ?></textarea>
    <br>
    <button type="submit">Simpan</button>
</form>