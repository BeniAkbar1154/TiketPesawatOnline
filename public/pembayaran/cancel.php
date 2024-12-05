<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/src/controller/PembayaranController.php';

$id_pemesanan = $_GET['id'] ?? null;
if ($id_pemesanan) {
    $pembayaranController = new PembayaranController($pdo);
    if ($pembayaranController->cancelPembayaran($id_pemesanan)) {
        header('Location: ../views/pesan.php');
        exit();
    } else {
        echo "Terjadi kesalahan dalam pembatalan pemesanan.";
    }
} else {
    echo "ID pemesanan tidak ditemukan.";
}
?>