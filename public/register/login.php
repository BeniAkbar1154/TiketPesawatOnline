<?php

require_once __DIR__ . '/../../src/controller/AuthController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header('Location: ../../index.php');
        exit();
    } else {
        echo "Email atau password salah.";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>