<?php
require_once __DIR__ . '/../../src/controller/PembayaranController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new PembayaranController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_pemesanan' => $_POST['id_pemesanan'],
        'jumlah_bayar' => $_POST['jumlah_bayar'],
        'tanggal_bayar' => date('Y-m-d H:i:s')
    ];
    $controller->buatPembayaran($data);
    echo "Pembayaran berhasil!";
}

// Ambil data pesanan
$id_pemesanan = $_GET['id_pemesanan'];
$totalBayar = $controller->totalPembayaran($id_pemesanan);
?>

<h1>Pembayaran</h1>
<p>Total Tagihan: Rp<?= htmlspecialchars($totalTagihan) ?></p>
<p>Total Dibayar: Rp<?= htmlspecialchars($totalBayar) ?></p>
<p>Sisa Tagihan: Rp<?= htmlspecialchars($totalTagihan - $totalBayar) ?></p>

<form method="POST">
    <input type="hidden" name="id_pemesanan" value="<?= htmlspecialchars($id_pemesanan) ?>">
    <label>Jumlah Bayar:</label>
    <input type="number" name="jumlah_bayar" required>
    <br>
    <button type="submit">Bayar</button>
</form>