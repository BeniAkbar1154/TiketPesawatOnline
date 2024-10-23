<?php
function createPesawatTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS pesawat (
        id INT AUTO_INCREMENT PRIMARY KEY,
        gambar VARCHAR(255),
        nama VARCHAR(100) NOT NULL,
        tipe VARCHAR(50) NOT NULL,
        deskripsi TEXT,
        kapasitas INT NOT NULL
    )";
    $pdo->exec($sql);
}
?>
