<?php
require_once __DIR__ . '/../../src/controller/TerminalController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TerminalController($pdo);

if (isset($_GET['id'])) {
    $id_terminal = $_GET['id'];
    $controller->deleteTerminal($id_terminal);
    header("Location: terminal.php");
    exit();
} else {
    die("Terminal tidak ditemukan.");
}
