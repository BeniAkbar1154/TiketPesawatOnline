<?php
// Koneksi ke database
require_once __DIR__ . '/../../database/db_connection.php';

// Cek apakah id_pemesanan ada di URL
if (isset($_GET['id'])) {
    $id_pemesanan = $_GET['id'];

    // Ambil data pemesanan berdasarkan id_pemesanan
    $stmt = $pdo->prepare("SELECT p.*, jb.harga, jb.datetime_keberangkatan FROM pemesanan p
                        JOIN jadwal_bus jb ON p.id_jadwal_bus = jb.id_jadwal_bus
                        WHERE p.id_pemesanan = ?");
    $stmt->execute([$id_pemesanan]);
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pemesanan) {
        die("Pemesanan tidak ditemukan.");
    }

    // Ambil daftar jadwal bus untuk pilihan baru
    $jadwalStmt = $pdo->query("SELECT id_jadwal_bus, rute_keberangkatan, rute_tujuan, datetime_keberangkatan FROM jadwal_bus");
    $jadwalBus = $jadwalStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    die("ID Pemesanan tidak tersedia.");
}

// Proses Update Pemesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang di-submit dari form
    $id_jadwal_bus = $_POST['id_jadwal_bus'];
    $nomor_kursi = $_POST['nomor_kursi'];

    // Ambil harga dan tenggat waktu baru berdasarkan jadwal bus yang dipilih
    $stmt = $pdo->prepare("SELECT harga, DATE_SUB(waktu_keberangkatan, INTERVAL 2 HOUR) AS tenggat_waktu FROM jadwal_bus WHERE id_jadwal_bus = ?");
    $stmt->execute([$id_jadwal_bus]);
    $jadwalData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($jadwalData) {
        $harga = $jadwalData['harga'];
        $tenggat_waktu = $jadwalData['tenggat_waktu'];

        // Update data pemesanan
        $updateStmt = $pdo->prepare("UPDATE pemesanan SET id_jadwal_bus = ?, nomor_kursi = ?, tanggal_pemesanan = NOW(), tagihan = ?, tenggat_waktu = ? WHERE id_pemesanan = ?");
        $updateStmt->execute([$id_jadwal_bus, $nomor_kursi, $harga, $tenggat_waktu, $id_pemesanan]);

        echo "Pemesanan berhasil diperbarui.";
    } else {
        echo "Data jadwal bus tidak ditemukan.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan</title>
</head>

<body>
    <h2>Edit Pemesanan</h2>

    <form action="edit.php?id_pemesanan=<?php echo $id_pemesanan; ?>" method="post">
        <div>
            <label for="id_jadwal_bus">Pilih Jadwal Bus:</label>
            <select name="id_jadwal_bus" id="id_jadwal_bus">
                <?php foreach ($jadwalBus as $jadwal): ?>
                    <option value="<?php echo $jadwal['id_jadwal_bus']; ?>" <?php echo $jadwal['id_jadwal_bus'] == $pemesanan['id_jadwal_bus'] ? 'selected' : ''; ?>>
                        <?php echo $jadwal['rute_keberangkatan']; ?> - <?php echo $jadwal['rute_tujuan']; ?>
                        (<?php echo $jadwal['datetime_keberangkatan']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="nomor_kursi">Nomor Kursi:</label>
            <input type="text" id="nomor_kursi" name="nomor_kursi" value="<?php echo $pemesanan['nomor_kursi']; ?>"
                required>
        </div>

        <div>
            <button type="submit">Update Pemesanan</button>
        </div>
    </form>

    <p><a href="index.php">Kembali ke Daftar Pemesanan</a></p>
</body>

</html>