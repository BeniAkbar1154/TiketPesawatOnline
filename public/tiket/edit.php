<?php
require_once __DIR__ . '/../../src/controller/TiketController.php';
require_once __DIR__ . '/../../src/controller/PemesananController.php';
require_once __DIR__ . '/../../src/controller/UserController.php';
require_once __DIR__ . '/../../src/controller/JadwalBusController.php';
require_once __DIR__ . '/../../database/db_connection.php';

// Inisialisasi controller
$tiketController = new TiketController($pdo);
$pemesananController = new PemesananController($pdo);
$userController = new UserController($pdo);
$jadwalBusController = new JadwalBusController($pdo);

// Ambil data tiket berdasarkan ID
$id_tiket = $_GET['id'] ?? null;
if (!$id_tiket) {
    die("ID Tiket tidak ditemukan.");
}

$tiket = $tiketController->getTiketById($id_tiket);
if (!$tiket) {
    die("Tiket dengan ID tersebut tidak ditemukan.");
}

// Ambil data untuk dropdown
$pemesananList = $pemesananController->index();
$userList = $userController->index();
$jadwalBusList = $jadwalBusController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_pemesanan' => $_POST['id_pemesanan'] ?? null,
        'id_user' => $_POST['id_user'] ?? null,
        'id_jadwal_bus' => $_POST['id_jadwal_bus'] ?? null,
        'nomor_kursi' => $_POST['nomor_kursi'] ?? null,
    ];

    // Validasi input
    if (!$data['id_pemesanan'] || !$data['id_user'] || !$data['id_jadwal_bus'] || !$data['nomor_kursi']) {
        die("Semua kolom wajib diisi.");
    }

    // Update tiket
    $tiketController->updateTiket($id_tiket, $data);

    // Redirect setelah berhasil update
    header("Location: tiket.php");
    exit();
}
?>

<h1>Edit Tiket</h1>

<form method="POST">
    <!-- Dropdown ID Pemesanan -->
    <label for="id_pemesanan">ID Pemesanan:</label>
    <select name="id_pemesanan" id="id_pemesanan" required>
        <option value="">-- Pilih ID Pemesanan --</option>
        <?php foreach ($pemesananList as $pemesanan): ?>
            <option value="<?= htmlspecialchars($pemesanan['id_pemesanan']) ?>"
                <?= $pemesanan['id_pemesanan'] == $tiket['id_pemesanan'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($pemesanan['id_pemesanan'] . ' - ' . $pemesanan['tanggal_pemesanan']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Dropdown ID User -->
    <label for="id_user">ID User:</label>
    <select name="id_user" id="id_user" required>
        <option value="">-- Pilih User --</option>
        <?php foreach ($userList as $user): ?>
            <option value="<?= htmlspecialchars($user['id_user']) ?>" <?= $user['id_user'] == $tiket['id_user'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($user['id_user'] . ' - ' . $user['username']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Dropdown ID Jadwal Bus -->
    <label for="id_jadwal_bus">ID Jadwal Bus:</label>
    <select name="id_jadwal_bus" id="id_jadwal_bus" required>
        <option value="">-- Pilih Jadwal Bus --</option>
        <?php foreach ($jadwalBusList as $jadwal): ?>
            <option value="<?= htmlspecialchars($jadwal['id_jadwal_bus']) ?>"
                <?= $jadwal['id_jadwal_bus'] == $tiket['id_jadwal_bus'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($jadwal['id_jadwal_bus'] . ' - ' . $jadwal['rute_keberangkatan'] . ' ke ' . $jadwal['rute_tujuan']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <!-- Input Nomor Kursi -->
    <label for="nomor_kursi">Nomor Kursi:</label>
    <input type="text" name="nomor_kursi" id="nomor_kursi" value="<?= htmlspecialchars($tiket['nomor_kursi']) ?>"
        required>
    <br>

    <button type="submit">Simpan</button>
</form>