<?php
require_once __DIR__ . '/../../src/controller/PemberhentianController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new PemberhentianController($pdo);
$id = $_GET['id'];
$controller->deletePemberhentian($id);

header("Location: pemberhentian.php");
exit();
?>