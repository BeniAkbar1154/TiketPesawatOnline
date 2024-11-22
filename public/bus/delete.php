<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/BusController.php';

$busController = new BusController($pdo);

if (isset($_GET['id'])) {
    $busId = $_GET['id'];

    if ($busController->deleteBus($busId)) {
        header('Location: bus.php');
        exit();
    } else {
        echo "Gagal menghapus data bus.";
    }
} else {
    header('Location: bus.php');
    exit();
}
?>