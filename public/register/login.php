<?php
session_start();  // Mulai session

require_once __DIR__ . '/../../src/controller/AuthController.php';
$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Melakukan login menggunakan AuthController
    $user = $authController->login($email, $password);

    if ($user) {
        $_SESSION['user'] = $user; // Simpan data user ke session
        if ($user['level'] === 'customer') {
            header('Location: ../../index.php'); // Customer diarahkan ke index
        } else {
            header('Location: ../dashboard/dashboard.php'); // Non-customer diarahkan ke dashboard
        }
        exit();
    } else {
        echo "Email atau password salah.";  // Tampilkan kesalahan jika login gagal
    }
}
?>


<!-- Form Login -->
<div class="container mt-5">
    <h1>Login</h1>
    <?php if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    } ?>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>