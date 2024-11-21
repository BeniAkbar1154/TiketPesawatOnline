<?php
function createTiketTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS tiket (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_rute INT NOT NULL,
        nomor_kursi INT NOT NULL,
        status ENUM('aktif', 'dibatalkan') DEFAULT 'aktif',
        tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (id_rute) REFERENCES rute(id) ON DELETE CASCADE
    );
    ";
    $pdo->exec($sql);
}
?>