<?php
function createBusTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS bus (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        tipe ENUM('ekonomi', 'eksekutif', 'VIP') NOT NULL,
        deskripsi TEXT,
        kapasitas INT NOT NULL,
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($sql);
}
?>