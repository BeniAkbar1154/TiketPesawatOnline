<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once 'create_users_table.php';
require_once 'create_destinasi_table.php';
require_once 'create_halte_table.php';
require_once 'create_bus_table.php';
require_once 'create_rute_table.php';
require_once 'create_tiket_table.php';
require_once 'create_pemesanan_table.php';

try {
    // Menjalankan migrasi untuk setiap tabel
    createUsersTable($pdo);
    createDestinasiTable($pdo);
    createHalteTable($pdo);
    createBusTable($pdo);
    createRuteTable($pdo);
    createTiketTable($pdo);
    createPemesananTable($pdo);

    echo "All tables created successfully!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>