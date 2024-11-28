<?php
require_once '../../database/db_connection.php'; // Pastikan ini sesuai dengan lokasi db_connection.php
require_once __DIR__ . '/../../src/controller/JadwalBusController.php'; // Pastikan ini mengarah ke lokasi yang tepat untuk controller

// Membuat instance JadwalBusController dengan objek PDO
$jadwalBusController = new JadwalBusController($pdo);

// Mengecek apakah ada parameter id di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Menghapus jadwal bus berdasarkan ID
        $jadwalBusController->deleteSchedule($id);

        // Redirect ke halaman jadwalBus.php setelah berhasil menghapus
        header('Location: jadwalBus.php');
        exit;
    } catch (Exception $e) {
        // Menampilkan pesan error jika terjadi kesalahan
        echo "Gagal menghapus jadwal: " . $e->getMessage();
    }
}
?>