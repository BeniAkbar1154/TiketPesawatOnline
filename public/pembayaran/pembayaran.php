<?php
require_once __DIR__ . '/../../src/controller/PembayaranController.php';
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

$controller = new PembayaranController($pdo);

// Debug parameter ID
// var_dump($_GET);

if (isset($_GET['id'])) {
    $id_pemesanan = $_GET['id'];

    // Ambil total tagihan dan total pembayaran sebelumnya
    $totalTagihan = $controller->getTagihanById($id_pemesanan);
    $totalBayar = $controller->getTotalPembayaran($id_pemesanan);

    // Ambil id_user berdasarkan id_pemesanan
    $id_user = $controller->getUserByPemesananId($id_pemesanan);
    if (!$id_user) {
        die("ID Pemesanan tidak valid atau tidak ditemukan.");
    }
} else {
    die("ID Pemesanan tidak tersedia.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_pemesanan' => $_POST['id_pemesanan'],
        'id_user' => $_POST['id_user'],
        'jumlah_bayar' => $_POST['jumlah_bayar'],
        'metode_pembayaran' => $_POST['metode_pembayaran'],
        'tanggal_pembayaran' => date('Y-m-d H:i:s'),
        'tagihan' => $_POST['tagihan'], // Pastikan 'tagihan' dikirimkan
    ];

    // Debug data
    var_dump($data); // Pastikan data diterima dengan benar

    // Menyimpan pembayaran
    $controller->createPembayaran($data);
    echo "Pembayaran berhasil dibuat.";

    // Redirect kembali ke halaman pemesanan.php setelah pembayaran berhasil
    header('Location: ../pemesanan/pemesanan.php'); // Ganti dengan path yang sesuai ke halaman pemesanan.php
    exit();
}
?>

<div class="container mt-5">
    <h1>Pembayaran</h1>
    <p>Total Tagihan: Rp<?= htmlspecialchars($totalTagihan) ?></p>
    <p>Total Dibayar: Rp<?= htmlspecialchars($totalBayar) ?></p>
    <p>Sisa Tagihan: Rp<?= htmlspecialchars($totalTagihan - $totalBayar) ?></p>

    <form method="POST">
        <input type="hidden" name="id_pemesanan" value="<?= htmlspecialchars($id_pemesanan) ?>">
        <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user) ?>">
        <input type="hidden" name="tagihan" value="<?= htmlspecialchars($totalTagihan) ?>">
        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select id="metode_pembayaran" name="metode_pembayaran" class="form-control" required>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
                <option value="E-Wallet">E-Wallet</option>
            </select>
        </div>
        <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar:</label>
            <input type="number" id="jumlah_bayar" name="jumlah_bayar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Bayar</button>
    </form>
</div>