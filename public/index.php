<?php
// public/index.php
require_once '../src/controller/UserController.php';
require_once '../database/db_connection.php';

$action = $_GET['action'] ?? '';

$userController = new UserController($pdo);

if ($action === 'register') {
    $userController->register();
} else {
    echo "Page not found";
}
?>
