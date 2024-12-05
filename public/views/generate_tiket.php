<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';

// Mengambil ID pemesanan dari URL parameter
$id_pemesanan = $_GET['id'] ?? null;

// Memastikan ID pemesanan ada
if ($id_pemesanan) {
    // Ambil detail pemesanan berdasarkan ID pemesanan
    $stmt = $pdo->prepare("
        SELECT p.id_pemesanan, u.username, b.nama AS bus, j.rute_keberangkatan, j.rute_tujuan, 
               p.nomor_kursi, p.status
        FROM pemesanan p
        JOIN user u ON p.id_user = u.id_user
        JOIN jadwal_bus j ON p.id_jadwal_bus = j.id_jadwal_bus
        JOIN bus b ON j.id_bus = b.id_bus
        WHERE p.id_pemesanan = :id_pemesanan
    ");
    $stmt->execute(['id_pemesanan' => $id_pemesanan]);
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek jika data pemesanan ditemukan
    if ($pemesanan) {
        // Generate nomor tiket unik
        $ticketNumber = strtoupper(uniqid('TKT')); // Buat nomor tiket unik

        // Menampilkan tiket
        echo "<h3>Tiket Anda</h3>";
        echo "<p>Nomor Tiket: " . htmlspecialchars($ticketNumber) . "</p>";
        echo "<p>Nama Pengguna: " . htmlspecialchars($pemesanan['username'] ?? 'Tidak Ditemukan') . "</p>";
        echo "<p>Bus: " . htmlspecialchars($pemesanan['bus'] ?? 'Tidak Ditemukan') . "</p>";
        echo "<p>Rute: " . htmlspecialchars($pemesanan['rute_keberangkatan'] ?? '-') . " - " . htmlspecialchars($pemesanan['rute_tujuan'] ?? '-') . "</p>";
        echo "<p>Nomor Kursi: " . htmlspecialchars($pemesanan['nomor_kursi'] ?? 'Tidak Ditemukan') . "</p>";
        echo "<p>Status Pemesanan: " . htmlspecialchars($pemesanan['status'] ?? 'Tidak Ditemukan') . "</p>";
    } else {
        echo "Pemesan dengan ID tersebut tidak ditemukan.";
    }
} else {
    echo "ID pemesanan tidak ditemukan.";
}
?>