<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {
    $pdo->exec("DROP TABLE IF EXISTS flights;");
    $pdo->exec("DROP TABLE IF EXISTS airlines;");
    $pdo->exec("DROP TABLE IF EXISTS users;");
    echo "Tables dropped successfully!";
} catch (PDOException $e) {
    echo "Rollback failed: " . $e->getMessage();
}
?>
