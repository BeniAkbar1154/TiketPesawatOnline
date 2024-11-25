<?php
try {
    // Koneksi ke database
    require_once __DIR__ . '/../../database/db_connection.php';


    // Insert default data ke tabel user
    $pdo->exec("
        INSERT INTO user (username, email, password, level) VALUES
        ('superadmin', 'superadmin@example.com', '" . password_hash('superadminpassword', PASSWORD_DEFAULT) . "', 'superadmin'),
        ('admin', 'admin@example.com', '" . password_hash('adminpassword', PASSWORD_DEFAULT) . "', 'admin'),
        ('petugas', 'petugas@example.com', '" . password_hash('petugaspassword', PASSWORD_DEFAULT) . "', 'petugas'),
        ('customer', 'customer@example.com', '" . password_hash('customerpassword', PASSWORD_DEFAULT) . "', 'customer')
    ");

    // Insert default data ke tabel bus
    $pdo->exec("
        INSERT INTO bus (gambar, nama, tipe, deskripsi, kapasitas) VALUES
        ('', 'Bus Ekonomi 1', 'ekonomi', 'Bus Ekonomi dengan kapasitas 40 penumpang', 40),
        ('', 'Bus VIP 1', 'vip', 'Bus VIP dengan kapasitas 30 penumpang', 30),
        ('', 'Bus VVIP 1', 'vvip', 'Bus VVIP dengan kapasitas 20 penumpang', 20)
    ");

    // Insert default data ke tabel terminal
    $pdo->exec("
        INSERT INTO terminal (lokasi_terminal, nama_terminal) VALUES
        ('Jakarta', 'Terminal Jakarta'),
        ('Bandung', 'Terminal Bandung'),
        ('Surabaya', 'Terminal Surabaya')
    ");

    // Insert default data ke tabel pemberhentian
    $pdo->exec("
    INSERT INTO pemberhentian (nama_pemberhentian, lokasi_pemberhentian) VALUES
    ('Pemberhentian 1', 'Lokasi 1'),
    ('Pemberhentian 2', 'Lokasi 2'),
    ('Pemberhentian 3', 'Lokasi 3')
");


    // Insert default data ke tabel jadwal_bus
    $pdo->exec("
        INSERT INTO jadwal_bus (id_bus, rute_keberangkatan, rute_transit, rute_tujuan, jam_keberangkatan, jam_sampai, harga) VALUES
        (1, 1, NULL, 2, '08:00:00', '12:00:00', 100000),
        (2, 2, 1, 3, '09:00:00', '13:00:00', 150000),
        (3, 3, NULL, 1, '10:00:00', '14:00:00', 200000)
    ");

    // Insert default data ke tabel pemesanan
    $pdo->exec("
        INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tenggat_waktu) VALUES
        (4, 1, '2024-11-01 08:00:00', 'A1', 'pending', '2024-11-01 12:00:00'),
        (4, 2, '2024-11-02 09:00:00', 'B2', 'confirmed', '2024-11-02 13:00:00')
    ");

    // Insert default data ke tabel tiket
    $pdo->exec("
        INSERT INTO tiket (id_pemesanan, id_user, id_jadwal_bus, nomor_kursi) VALUES
        (1, 4, 1, 'A1'),
        (2, 4, 2, 'B2')
    ");

    // Insert default data ke tabel laporan_harian
    $pdo->exec("
        INSERT INTO laporan_harian (id_bus, tanggal, waktu, kondisi_teknis, kondisi_kebersihan, bahan_bakar, kondisi_jalan, ketepatan_jadwal, keselamatan) VALUES
        (1, '2024-11-01', '08:00:00', 'Baik', 'Bersih', 'Cukup', 'Mulus', 'Tepat Waktu', 'Aman'),
        (2, '2024-11-02', '09:00:00', 'Baik', 'Bersih', 'Penuh', 'Banyak Lubang', 'Tepat Waktu', 'Aman')
    ");

    // Insert default data ke tabel laporan_khusus
    $pdo->exec("
        INSERT INTO laporan_khusus (id_bus, id_user, tanggal, masalah) VALUES
(NULL, NULL, CURRENT_DATE, 'Tidak ada masalah pada sistem.'),
(NULL, 1, CURRENT_DATE, 'Masalah dengan pengguna: Tidak hadir pada waktu keberangkatan.'),
(2, NULL, CURRENT_DATE, 'Masalah dengan bus: Kerusakan mesin saat perjalanan.'),
(1, 3, CURRENT_DATE, 'Masalah pada pengguna: Laporan kehilangan barang.'),
(NULL, NULL, CURRENT_DATE, 'Laporan rutin tanpa masalah yang tercatat.');

    ");

    echo "Data default berhasil dimasukkan.";
} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>