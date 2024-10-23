<?php
function createRuteTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS rute (
        id INT AUTO_INCREMENT PRIMARY KEY,
        transit VARCHAR(100) DEFAULT NULL,
        rute_awal INT NOT NULL,
        rute_akhir INT NOT NULL,
        kedatangan TIMESTAMP NOT NULL,
        harga DECIMAL(10, 2) NOT NULL,
        id_pesawat INT NOT NULL,
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (rute_awal) REFERENCES bandara(id) ON DELETE CASCADE,
        FOREIGN KEY (rute_akhir) REFERENCES bandara(id) ON DELETE CASCADE,
        FOREIGN KEY (id_pesawat) REFERENCES pesawat(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
}
?>
