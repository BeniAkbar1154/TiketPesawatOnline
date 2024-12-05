<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/AuthController.php';

// Inisialisasi AuthController
$authController = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data login dari form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Panggil fungsi login dari controller
    if ($authController->login($email, $password)) {
        // Jika login berhasil, arahkan ke halaman dashboard atau halaman yang sesuai
        header("Location: ../dashboard/dashboard.php");
        exit;
    } else {
        // Tampilkan pesan error jika login gagal
        $error = "Email atau password salah.";
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