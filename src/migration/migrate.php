<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once 'create_users_table.php';
require_once 'create_destinasi_table.php';
require_once 'create_bandara_table.php';
require_once 'create_pesawat_table.php';
require_once 'create_rute_table.php';
require_once 'create_pemesanan_table.php';

try {
    // Menjalankan migrasi untuk setiap tabel
    createUsersTable($pdo);
    createDestinasiTable($pdo);
    createBandaraTable($pdo);
    createPesawatTable($pdo);
    createRuteTable($pdo);
    createPemesananTable($pdo);

    echo "All tables created successfully!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
