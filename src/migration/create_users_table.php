<?php
function createUsersTable($pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        level ENUM('customer', 'petugas', 'admin') NOT NULL
    )";
    $pdo->exec($sql);
}
?>
