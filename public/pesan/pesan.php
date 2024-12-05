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
$pesan_list = $pesanController->index();
?>

<h2>Daftar Pesan</h2>
<a href="create.php">Tambah Pesan</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Pesan</th>
        <th>Status</th>
        <th>Tanggal Kirim</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($pesan_list as $pesan): ?>
        <tr>
            <td><?= $pesan['id_pesan'] ?></td>
            <td><?= $pesan['username'] ?></td>
            <td><?= $pesan['pesan'] ?></td>
            <td><?= $pesan['status'] ?></td>
            <td><?= $pesan['tanggal_kirim'] ?></td>
            <td>
                <a href="edit.php?id=<?= $pesan['id_pesan'] ?>">Edit</a>
                <a href="delete.php?id=<?= $pesan['id_pesan'] ?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>