<?php
require_once __DIR__ . '/   ../db_connection.php';

$sql = "CREATE TABLE IF NOT EXISTS tickets (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    flight_number VARCHAR(50) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    departure_time DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Eksekusi query
$pdo->exec($sql);
echo "Tabel 'tickets' berhasil dibuat atau sudah ada.";
