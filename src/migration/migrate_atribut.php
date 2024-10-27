<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {

    $pdo->exec("
        INSERT INTO users (username, email, password, level) VALUES
        ('admin', 'admin@example.com', 'adminpassword', 'admin'),
        ('petugas', 'petugas@example.com', 'petugaspassword', 'petugas'),
        ('customer', 'customer@example.com', 'customerpassword', 'customer')
    ");

    $pdo->exec("
        INSERT INTO destinasi (destinasi, iso) VALUES
        ('Jakarta', 'JKT'),
        ('Surabaya', 'SUB'),
        ('Bali', 'DPS')
    ");

    $pdo->exec("
        INSERT INTO bandara (id_destinasi, nama, iso_9001) VALUES
        (1, 'Soekarno-Hatta International Airport', 1),
        (2, 'Juanda International Airport', 1),
        (3, 'Ngurah Rai International Airport', 1)
    ");

    $pdo->exec("
        INSERT INTO pesawat (gambar, nama, tipe, deskripsi, kapasitas) VALUES
        ('plane1.jpg', 'Boeing 737', 'Passenger', 'Boeing 737 description', 150),
        ('plane2.jpg', 'Airbus A320', 'Passenger', 'Airbus A320 description', 180)
    ");

    $pdo->exec("
        INSERT INTO rute (transit, rute_awal, rute_akhir, kedatangan, harga, id_pesawat) VALUES
        ('Direct', 1, 2, '2024-10-12 08:30:00', 500000, 1),
        ('Direct', 2, 3, '2024-10-12 12:45:00', 750000, 2)
    ");

    $pdo->exec("
        INSERT INTO pemesanan (id_user, tanggal_pemesanan, nomor_kursi, id_rute, status) VALUES
        (3, '2024-10-12 10:00:00', 'A1', 1, 'confirmed'),
        (3, '2024-10-12 14:00:00', 'B2', 2, 'pending')
    ");

    echo "Default data has been inserted successfully!";
} catch (PDOException $e) {
    echo "Failed to insert default data: " . $e->getMessage();
}
?>