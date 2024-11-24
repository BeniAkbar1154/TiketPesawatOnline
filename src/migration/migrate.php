<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once 'create_table.php';

try {
    createUserTable($pdo);
    createBusTable($pdo);
    createTerminalTable($pdo);
    createPemberhentianTable($pdo);
    createJadwalBusTable($pdo);
    createPemesananTable($pdo);
    createTiketTable($pdo);
    createLaporanHarianTable($pdo);
    createLaporanKhususTable($pdo);
    echo "Semua tabel berhasil dibuat.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>