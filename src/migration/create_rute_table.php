<?php
function createRuteTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS rute (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_bus INT NOT NULL,
        rute_awal INT NOT NULL,
        rute_akhir INT NOT NULL,
        pemberhentian JSON,
        waktu_berangkat TIME NOT NULL,
        waktu_tiba TIME NOT NULL,
        harga DECIMAL(10, 2) NOT NULL,
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_bus) REFERENCES bus(id) ON DELETE CASCADE,
        FOREIGN KEY (rute_awal) REFERENCES destinasi(id) ON DELETE CASCADE,
        FOREIGN KEY (rute_akhir) REFERENCES destinasi(id) ON DELETE CASCADE
    );
    ";
    $pdo->exec($sql);
}
?>