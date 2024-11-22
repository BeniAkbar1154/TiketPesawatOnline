<?php
function createBusTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS bus (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        tipe VARCHAR(50) NOT NULL,
        deskripsi TEXT NOT NULL,
        kapasitas INT NOT NULL,
        gambar VARCHAR(255) NOT NULL
    );
    ";
    $pdo->exec($sql);
}
?>