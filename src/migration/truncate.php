<?php
require_once __DIR__ . '/../../database/db_connection.php';

try {
    // Nonaktifkan sementara foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Hapus semua data di setiap tabel
    $tables = [
        'laporan_khusus',
        'laporan_harian',
        'tiket',
        'pemesanan',
        'jadwal_bus',
        'bus',
        'pemberhentian',
        'terminal',
        'user'
    ];

    foreach ($tables as $table) {
        $pdo->exec("TRUNCATE TABLE $table");
    }

    // Aktifkan kembali foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "All table data has been cleared successfully!";
} catch (PDOException $e) {
    echo "Failed to clear table data: " . $e->getMessage();
}
?>