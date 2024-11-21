<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {
    $pdo->exec("DROP TABLE IF EXISTS pemesanan;");
    $pdo->exec("DROP TABLE IF EXISTS tiket;");
    $pdo->exec("DROP TABLE IF EXISTS rute;");
    $pdo->exec("DROP TABLE IF EXISTS bus;");
    $pdo->exec("DROP TABLE IF EXISTS halte;");
    $pdo->exec("DROP TABLE IF EXISTS destinasi;");
    $pdo->exec("DROP TABLE IF EXISTS users;");
    echo "Tables dropped successfully!";
} catch (PDOException $e) {
    echo "Rollback failed: " . $e->getMessage();
}
?>