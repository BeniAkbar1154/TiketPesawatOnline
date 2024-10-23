<?php
function createDestinasiTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS destinasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        destinasi VARCHAR(100) NOT NULL,
        iso VARCHAR(10) NOT NULL
    )";
    $pdo->exec($sql);
}
?>
