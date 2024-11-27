<?php
require_once __DIR__ . '/../../src/controller/TiketController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TiketController($pdo);

if (isset($_GET['id'])) {
    $id_tiket = $_GET['id'];
    $controller->deleteTiket($id_tiket);
    header("Location: tiket.php");
    exit();
} else {
    die("Tiket tidak ditemukan.");
}
