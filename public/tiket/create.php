<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/TiketController.php';
require_once __DIR__ . '/../../src/controller/PemesananController.php';
require_once __DIR__ . '/../../src/controller/UserController.php';
require_once __DIR__ . '/../../src/controller/JadwalBusController.php';

// Inisialisasi controller
$tiketController = new TiketController($pdo);
$pemesananController = new PemesananController($pdo);
$userController = new UserController($pdo);
$jadwalBusController = new JadwalBusController($pdo);

// Ambil data untuk dropdown
$pemesananList = $pemesananController->index();
$userList = $userController->index();
$jadwalBusList = $jadwalBusController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Data dari form
    $data = [
        'id_pemesanan' => $_POST['id_pemesanan'],
        'id_user' => $_POST['id_user'],
        'id_jadwal_bus' => $_POST['id_jadwal_bus'],
        'nomor_kursi' => $_POST['nomor_kursi'],
    ];

    // Buat tiket baru
    $tiketController->createTiket($data);

    // Redirect setelah berhasil membuat tiket
    header('Location: tiket.php');
    exit;
}
?>

<h1>Buat Tiket Baru</h1>

<form method="POST">
    <!-- Dropdown ID Pemesanan -->
    <label for="id_pemesanan">Pilih ID Pemesanan:</label>
    <select name="id_pemesanan" id="id_pemesanan" required>
        <?php foreach ($pemesananList as $pemesanan): ?>
            <option value="<?= htmlspecialchars($pemesanan['id_pemesanan']) ?>">
                <?= htmlspecialchars('Pemesanan #' . $pemesanan['id_pemesanan']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Dropdown ID User -->
    <label for="id_user">Pilih User:</label>
    <select name="id_user" id="id_user" required>
        <?php foreach ($userList as $user): ?>
            <option value="<?= htmlspecialchars($user['id_user']) ?>">
                <?= htmlspecialchars($user['username']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Dropdown ID Jadwal Bus -->
    <label for="id_jadwal_bus">Pilih Jadwal Bus:</label>
    <select name="id_jadwal_bus" id="id_jadwal_bus" required>
        <?php foreach ($jadwalBusList as $jadwal): ?>
            <option value="<?= htmlspecialchars($jadwal['id_jadwal_bus']) ?>">
                <?= htmlspecialchars($jadwal['rute_keberangkatan'] . ' - ' . $jadwal['rute_tujuan'] . ' (' . $jadwal['datetime_keberangkatan'] . ')') ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Input Nomor Kursi -->
    <label for="nomor_kursi">Nomor Kursi:</label>
    <input type="text" name="nomor_kursi" id="nomor_kursi" required>
    <br>

    <button type="submit">Buat Tiket</button>
</form>