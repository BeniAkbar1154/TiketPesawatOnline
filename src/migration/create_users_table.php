<?php
function createUsersTable($pdo)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        no_telepon VARCHAR(15) NOT NULL,
        role ENUM('customer','petugas','admin') DEFAULT 'customer',
        tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($sql);
}
?>