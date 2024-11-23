<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {
    // Insert default data into `user` table
    $pdo->exec("
        INSERT INTO user (username, email, password, level) VALUES
        ('superadmin', 'superadmin@example.com', '" . password_hash('superadminpassword', PASSWORD_DEFAULT) . "', 'superadmin'),
        ('admin', 'admin@example.com', '" . password_hash('adminpassword', PASSWORD_DEFAULT) . "', 'admin'),
        ('petugas', 'petugas@example.com', '" . password_hash('petugaspassword', PASSWORD_DEFAULT) . "', 'petugas'),
        ('customer', 'customer@example.com', '" . password_hash('customerpassword', PASSWORD_DEFAULT) . "', 'customer')
    ");

    // Insert default data into `bus` table
    $pdo->exec("
        INSERT INTO bus (gambar, nama, tipe, deskripsi, kapasitas) VALUES
        (NULL, 'Bus Ekonomi 1', 'ekonomi', 'Bus ekonomi dengan AC dan 40 kursi', 40),
        (NULL, 'Bus VIP 1', 'vip', 'Bus VIP dengan fasilitas nyaman dan 30 kursi', 30),
        (NULL, 'Bus VVIP 1', 'vvip', 'Bus sleeper VVIP dengan fasilitas premium dan 20 kursi', 20)
    ");

    // Insert default data into `terminal` table
    $pdo->exec("
        INSERT INTO terminal (lokasi_terminal, nama_terminal) VALUES
        ('Jakarta', 'Terminal Pulo Gadung'),
        ('Bandung', 'Terminal Leuwi Panjang'),
        ('Surabaya', 'Terminal Bungurasih')
    ");

    // Insert default data into `pemberhentian` table
    $pdo->exec("
        INSERT INTO pemberhentian (nama_pemberhentian) VALUES
        ('Rest Area Km 10'),
        ('Rest Area Km 50'),
        ('Rest Area Km 100')
    ");

    // Insert default data into `jadwal_bus` table
    $pdo->exec("
        INSERT INTO jadwal_bus (id_bus, rute_keberangkatan, rute_transit, rute_tujuan, jam_keberangkatan, jam_sampai, harga) VALUES
        (1, 1, 2, 3, '08:00:00', '12:00:00', 100000),
        (2, 2, NULL, 3, '09:00:00', '13:00:00', 150000),
        (3, 1, NULL, 2, '10:00:00', '14:00:00', 200000)
    ");

    // Insert default data into `pemesanan` table
    $pdo->exec("
        INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tenggat_waktu) VALUES
        (4, 1, '2024-11-22 08:30:00', 'A1', 'pending', '2024-11-22 10:30:00'),
        (4, 2, '2024-11-22 09:00:00', 'B2', 'confirmed', '2024-11-22 11:00:00')
    ");

    // Insert default data into `tiket` table
    $pdo->exec("
        INSERT INTO tiket (id_pemesanan, id_user, id_jadwal_bus, nomor_kursi) VALUES
        (1, 4, 1, 'A1'),
        (2, 4, 2, 'B2')
    ");

    // Insert default data into `laporan_harian` table
    $pdo->exec("
        INSERT INTO laporan_harian (id_bus, tanggal, waktu, kondisi_teknis, kondisi_kebersihan, bahan_bakar, kondisi_jalan, ketepatan_jadwal, keselamatan) VALUES
        (1, '2024-11-22', '08:00:00', 'Baik', 'Bersih', 'Cukup', 'Lancar', 'Tepat Waktu', 'Aman'),
        (2, '2024-11-22', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL)
    ");

    // Insert default data into `laporan_khusus` table
    $pdo->exec("
        INSERT INTO laporan_khusus (id_bus, id_user, tanggal, jadwal, masalah) VALUES
        (1, 3, '2024-11-22', '08:00:00', 'Kerusakan kecil pada AC'),
        (NULL, NULL, '2024-11-22', '10:00:00', 'Kecelakaan ringan di rest area')
    ");

    echo "Default data has been inserted successfully!";
} catch (PDOException $e) {
    echo "Failed to insert default data: " . $e->getMessage();
}
?>