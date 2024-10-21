<?php
require_once __DIR__ . '/../database/db_connection.php';
require_once __DIR__ . '/../src/controller/UserController.php';
require_once __DIR__ . '/../src/model/UserModel.php';

$action = $_GET['action'] ?? '';

$userModel = new User($pdo);
$userController = new UserController($userModel);
$controller = new UserController();

if ($_GET['action'] == 'register') {
    $controller->register();
}
