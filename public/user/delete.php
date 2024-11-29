<?php
require_once '../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/UserController.php';

$userController = new UserController($pdo);

if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$id = $_GET['id'];

// Proses penghapusan data
if ($userController->deleteUser($id)) {
    header("Location: user.php?success=Pengguna berhasil dihapus.");
    exit;
} else {
    header("Location: user.php?error=Gagal menghapus pengguna.");
    exit;
}
