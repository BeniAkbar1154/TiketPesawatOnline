<?php
function createBandaraTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS bandara (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_destinasi INT NOT NULL,
        nama VARCHAR(100) NOT NULL,
        iso_9001 BOOLEAN DEFAULT 0,
        FOREIGN KEY (id_destinasi) REFERENCES destinasi(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
}
?>
