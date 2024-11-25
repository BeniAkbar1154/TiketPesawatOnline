<?php
require_once __DIR__ . '/../../src/controller/PemberhentianController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new PemberhentianController($pdo);
$pemberhentianList = $controller->getAllPemberhentian();
?>

<h1>Daftar Pemberhentian</h1>
<a href="create.php">Tambah Pemberhentian</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pemberhentianList as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_pemberhentian'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['nama_pemberhentian'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['lokasi_pemberhentian'] ?? '') ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_pemberhentian'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id_pemberhentian'] ?>"
                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>