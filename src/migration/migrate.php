<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once 'create_table.php';

try {
    // Memanggil fungsi untuk membuat semua tabel
    createUserTable($pdo);
    createBusTable($pdo);
    createTerminalTable($pdo);
    createPemberhentianTable($pdo);
    createJadwalBusTable($pdo);
    createPemesananTable($pdo);
    createTiketTable($pdo);
    createLaporanHarianTable($pdo);
    createLaporanKhususTable($pdo);

    echo "All tables created successfully!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>