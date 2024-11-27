<?php
require_once __DIR__ . '/../../src/controller/TerminalController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TerminalController($pdo);
$terminals = $controller->index();
?>

<h1>Daftar Terminal</h1>
<a href="create.php">Tambah Terminal</a>
<table>
    <thead>
        <tr>
            <th>ID Terminal</th>
            <th>Lokasi Terminal</th>
            <th>Nama Terminal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($terminals as $terminal): ?>
            <tr>
                <td><?= htmlspecialchars($terminal['id_terminal']) ?></td>
                <td><?= htmlspecialchars($terminal['lokasi_terminal']) ?></td>
                <td><?= htmlspecialchars($terminal['nama_terminal']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $terminal['id_terminal'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $terminal['id_terminal'] ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>