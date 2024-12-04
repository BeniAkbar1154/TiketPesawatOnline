<?php
// Include koneksi database dan mulai sesi
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';
session_start(); // Untuk memeriksa sesi login pengguna

// Validasi jika `id_jadwal_bus` tidak ada di URL
if (!isset($_GET['id_jadwal_bus']) || empty($_GET['id_jadwal_bus'])) {
    echo "<h3>ID Jadwal Bus tidak ditemukan!</h3>";
    exit;
}

// Ambil ID dari URL
$id_jadwal_bus = $_GET['id_jadwal_bus'];

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: /TiketTransportasiOnline/public/register/login.php");
    exit;
}

// Ambil data pengguna yang login
$id_user = $_SESSION['user']['id_user'];

try {
    // Query untuk mendapatkan kursi yang tersedia untuk jadwal bus ini
    $stmtKursi = $pdo->prepare("
        SELECT id_kursi, nomor_kursi 
        FROM kursi 
        WHERE id_jadwal_bus = :id_jadwal_bus AND status = 'available'
    ");
    $stmtKursi->execute(['id_jadwal_bus' => $id_jadwal_bus]);
    $kursiList = $stmtKursi->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Menampilkan jumlah kursi yang ditemukan
    echo "<h3>Jumlah kursi tersedia: " . count($kursiList) . "</h3>";

    // Jika tidak ada kursi yang tersedia
    if (empty($kursiList)) {
        echo "<h3>Maaf, semua kursi untuk jadwal ini telah dipesan atau belum tersedia.</h3>";
        exit;
    }

    // Tampilkan pilihan kursi yang tersedia
    echo "<h3>Pilih Kursi Anda</h3>";
    echo "<form method='post'>";
    echo "<div class='list-kursi'>";
    foreach ($kursiList as $kursi) {
        echo "<input type='radio' name='id_kursi' value='" . $kursi['id_kursi'] . "'> Kursi " . $kursi['nomor_kursi'] . "<br>";
    }
    echo "</div>";

    // Tombol untuk memesan
    echo "<button type='submit' class='btn btn-primary'>Pesan Kursi</button>";
    echo "</form>";

    // Proses pemesanan setelah form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_kursi'])) {
        $id_kursi = $_POST['id_kursi'];

        // Debugging: Cek id_kursi yang dipilih
        echo "<h3>Anda memilih kursi dengan ID: " . htmlspecialchars($id_kursi) . "</h3>";

        // Tandai kursi sebagai terpesan
        $stmtUpdateKursi = $pdo->prepare("
            UPDATE kursi 
            SET status = 'booked' 
            WHERE id_kursi = :id_kursi
        ");
        $stmtUpdateKursi->execute(['id_kursi' => $id_kursi]);

        // Simpan data pemesanan ke tabel `pemesanan`
        $stmtPemesanan = $pdo->prepare("
            INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi) 
            VALUES (:id_user, :id_jadwal_bus, NOW(), :nomor_kursi)
        ");
        $stmtPemesanan->execute([
            'id_user' => $id_user,
            'id_jadwal_bus' => $id_jadwal_bus,
            'nomor_kursi' => $id_kursi
        ]);

        echo "<script>
            alert('Pemesanan berhasil! Nomor kursi Anda: " . htmlspecialchars($id_kursi) . "');
            window.location.href = '/TiketTransportasiOnline/public/tiket.php';
        </script>";
    }
} catch (Exception $e) {
    echo "<h3>Terjadi kesalahan: " . $e->getMessage() . "</h3>";
}
?>