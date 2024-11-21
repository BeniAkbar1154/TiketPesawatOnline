<?php
function createPemesananTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS pemesanan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_tiket INT NOT NULL,
        metode_pembayaran ENUM('transfer_bank', 'kartu_kredit', 'e-wallet') NOT NULL,
        status_pembayaran ENUM('lunas', 'belum_lunas') DEFAULT 'belum_lunas',
        tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (id_tiket) REFERENCES tiket(id) ON DELETE CASCADE
    );
    ";
    $pdo->exec($sql);
}
?>