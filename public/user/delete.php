<?php
require_once __DIR__ . '/../../src/controller/UserController.php';

if (!isset($_GET['id'])) {
    header('Location: user.php');
    exit;
}

$userController = new UserController($pdo);

if ($userController->deleteUser($_GET['id'])) {
    header('Location: user.php');
    exit;
} else {
    echo "Gagal menghapus user.";
}
?>