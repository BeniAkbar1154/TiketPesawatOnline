<?php
function createHalteTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS halte (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_halte VARCHAR(100) NOT NULL,
        lokasi VARCHAR(100) NOT NULL,
        id_destinasi INT,
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_destinasi) REFERENCES destinasi(id) ON DELETE SET NULL
    );
    ";
    $pdo->exec($sql);
}
?>