<?php
require_once __DIR__ . '/../../src/controller/BusController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$busController = new BusController($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $busController->deleteBus($id);
        header('Location: bus.php');
        exit;
    } catch (Exception $e) {
        echo "Gagal menghapus bus: " . $e->getMessage();
    }
}
?>