<?php
require_once '../../database/db_connection.php';
require_once '../../src/controller/PesanController.php';

$pesanController = new PesanController($pdo);

if (isset($_GET['id'])) {
    if ($pesanController->delete($_GET['id'])) {
        header("Location: pesan.php");
        exit();
    } else {
        echo "Gagal menghapus pesan.";
    }
}
?>