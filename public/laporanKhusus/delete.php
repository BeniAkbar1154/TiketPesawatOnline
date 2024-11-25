<?php
require_once __DIR__ . '/../../src/controller/LaporanKhususController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new LaporanKhususController($pdo);
$id = $_GET['id'];

$controller->deleteLaporanKhusus($id);
header("Location: laporanKhusus.php");
exit();
?>