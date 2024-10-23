<?php
function createPemesananTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS pemesanan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        nomor_kursi VARCHAR(10) NOT NULL,
        id_rute INT NOT NULL,
        status ENUM('pending', 'confirmed', 'cancelled') NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (id_rute) REFERENCES rute(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
}
?>
