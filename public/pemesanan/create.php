<?php
require_once __DIR__ . '/../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $id_jadwal_bus = $_POST['id_jadwal_bus'];

    // Ambil data jadwal bus untuk menghitung tagihan dan tenggat waktu
    $stmt = $pdo->prepare("
        SELECT harga, DATE_SUB(datetime_keberangkatan, INTERVAL 2 HOUR) AS tenggat_waktu
        FROM jadwal_bus
        WHERE id_jadwal_bus = ?
    ");
    $stmt->execute([$id_jadwal_bus]);
    $jadwal_bus = $stmt->fetch();

    $tagihan = $jadwal_bus['harga'];
    $tenggat_waktu = $jadwal_bus['tenggat_waktu'];
    $tanggal_pemesanan = date('Y-m-d H:i:s'); // Waktu sekarang
    $nomor_kursi = $_POST['nomor_kursi'];

    // Insert data ke tabel pemesanan
    $stmt = $pdo->prepare("
        INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tagihan, tenggat_waktu)
        VALUES (?, ?, ?, ?, 'pending', ?, ?)
    ");
    $stmt->execute([$id_user, $id_jadwal_bus, $tanggal_pemesanan, $nomor_kursi, $tagihan, $tenggat_waktu]);

    header('Location: pemesanan.php');
    exit;
}

// Ambil data pengguna
$users = $pdo->query("SELECT id_user, username FROM user")->fetchAll();

// Ambil data jadwal bus beserta nama terminal keberangkatan, tujuan, dan harga
$jadwal_bus = $pdo->query("
    SELECT 
        j.id_jadwal_bus, 
        t1.nama_terminal AS terminal_keberangkatan, 
        t2.nama_terminal AS terminal_tujuan, 
        j.harga
    FROM jadwal_bus j
    JOIN terminal t1 ON j.rute_keberangkatan = t1.id_terminal
    JOIN terminal t2 ON j.rute_tujuan = t2.id_terminal
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemesanan</title>
    <script>
        function updateTagihan() {
            const jadwal = document.getElementById('id_jadwal_bus');
            const harga = jadwal.options[jadwal.selectedIndex].dataset.harga;
            document.getElementById('tagihan').value = harga;
        }
    </script>
</head>

<body>
    <h1>Tambah Pemesanan</h1>
    <form action="" method="POST">
        <label for="id_user">Pengguna:</label>
        <select name="id_user" id="id_user">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="id_jadwal_bus">Jadwal Bus:</label>
        <select name="id_jadwal_bus" id="id_jadwal_bus" onchange="updateTagihan()">
            <?php foreach ($jadwal_bus as $jadwal): ?>
                <option value="<?= $jadwal['id_jadwal_bus'] ?>" data-harga="<?= $jadwal['harga'] ?>">
                    <?= $jadwal['terminal_keberangkatan'] ?> ke <?= $jadwal['terminal_tujuan'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
        <input type="text" name="tanggal_pemesanan" id="tanggal_pemesanan" value="<?= date('Y-m-d H:i:s') ?>"
            readonly><br>

        <label for="nomor_kursi">Nomor Kursi:</label>
        <input type="text" name="nomor_kursi" id="nomor_kursi" required><br>

        <label for="tagihan">Tagihan:</label>
        <input type="number" name="tagihan" id="tagihan" readonly><br>

        <button type="submit">Simpan</button>
    </form>
</body>

</html>