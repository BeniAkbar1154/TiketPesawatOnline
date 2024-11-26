<?php
require_once __DIR__ . '/../../database/db_connection.php';

// Ambil data pemesanan
$stmt = $pdo->prepare("
    SELECT p.id_pemesanan, u.username, b.nama AS bus, j.rute_keberangkatan, j.rute_tujuan, p.tanggal_pemesanan, 
           p.nomor_kursi, p.status, p.tagihan, p.tenggat_waktu
    FROM pemesanan p
    JOIN user u ON p.id_user = u.id_user
    JOIN jadwal_bus j ON p.id_jadwal_bus = j.id_jadwal_bus
    JOIN bus b ON j.id_bus = b.id_bus
");
$stmt->execute();
$pemesanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan</title>
</head>

<body>
    <h1>Daftar Pemesanan</h1>
    <a href="create.php">Tambah Pemesanan</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID Pemesanan</th>
                <th>Nama Pengguna</th>
                <th>Bus</th>
                <th>Keberangkatan</th>
                <th>Tujuan</th>
                <th>Tanggal Pemesanan</th>
                <th>Nomor Kursi</th>
                <th>Status</th>
                <th>Tagihan</th>
                <th>Tenggat Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pemesanan as $item): ?>
                <tr>
                    <td><?= $item['id_pemesanan'] ?></td>
                    <td><?= $item['username'] ?></td>
                    <td><?= $item['bus'] ?></td>
                    <td><?= $item['rute_keberangkatan'] ?></td>
                    <td><?= $item['rute_tujuan'] ?></td>
                    <td><?= $item['tanggal_pemesanan'] ?></td>
                    <td><?= $item['nomor_kursi'] ?></td>
                    <td><?= $item['status'] ?></td>
                    <td>Rp <?= number_format($item['tagihan'], 0, ',', '.') ?></td>
                    <td><?= $item['tenggat_waktu'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $item['id_pemesanan'] ?>">Edit</a> |
                        <a href="delete.php?id=<?= $item['id_pemesanan'] ?>"
                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</a> |
                        <?php if ($item['status'] === 'pending'): ?>
                            <a href="../Pembayaran/pembayaran.php?id=<?= $item['id_pemesanan'] ?>">Bayar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>