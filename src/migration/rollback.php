<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {
    // Nonaktifkan foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

    // Hapus tabel secara berurutan
    $pdo->exec("DROP TABLE IF EXISTS tiket;");
    $pdo->exec("DROP TABLE IF EXISTS pemesanan;");
    $pdo->exec("DROP TABLE IF EXISTS jadwal_bus;");
    $pdo->exec("DROP TABLE IF EXISTS bus;");
    $pdo->exec("DROP TABLE IF EXISTS user;");
    $pdo->exec("DROP TABLE IF EXISTS laporan_harian;");
    $pdo->exec("DROP TABLE IF EXISTS laporan_khusus;");
    $pdo->exec("DROP TABLE IF EXISTS terminal;");
    $pdo->exec("DROP TABLE IF EXISTS pemberhentian;");

    // Aktifkan kembali foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "All tables have been rolled back successfully!";
} catch (PDOException $e) {
    echo "Rollback failed: " . $e->getMessage();
}
?>