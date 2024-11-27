<?php
require_once __DIR__ . '/../../src/controller/TiketController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TiketController($pdo);
$tickets = $controller->index();
?>

<h1>Daftar Tiket</h1>
<a href="create.php">Tambah Tiket</a>
<table>
    <thead>
        <tr>
            <th>ID Tiket</th>
            <th>Nomor Kursi</th>
            <th>Tanggal Pemesanan</th>
            <th>Terminal Asal</th>
            <th>Terminal Tujuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket['id_tiket']) ?></td>
                <td><?= htmlspecialchars($ticket['nomor_kursi']) ?></td>
                <td><?= htmlspecialchars($ticket['tanggal_pemesanan']) ?></td>
                <td><?= htmlspecialchars($ticket['terminal_asal']) ?></td>
                <td><?= htmlspecialchars($ticket['terminal_tujuan']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $ticket['id_tiket'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $ticket['id_tiket'] ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>