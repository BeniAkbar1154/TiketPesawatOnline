<?php
require_once __DIR__ . '/../../database/db_connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: pemesanan.php?message=notfound');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pemesanan WHERE id_pemesanan = :id");
    $stmt->execute(['id' => $id]);
    header('Location: pemesanan.php?message=deleted');
    exit;
} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>