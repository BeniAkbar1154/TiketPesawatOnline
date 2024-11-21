<?php
function createDestinasiTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS destinasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_kota VARCHAR(100) NOT NULL,
        nama_terminal VARCHAR(100) NOT NULL,
        iso VARCHAR(10),
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($sql);
}
?>