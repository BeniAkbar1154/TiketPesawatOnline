<?php
require_once __DIR__ . '/../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi input
    $errors = [];
    if (empty($username)) {
        $errors[] = 'Username tidak boleh kosong.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    if (empty($password)) {
        $errors[] = 'Password tidak boleh kosong.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Password dan Konfirmasi Password tidak cocok.';
    }

    // Periksa apakah email sudah terdaftar
    $query = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $query->execute([$email]);
    if ($query->rowCount() > 0) {
        $errors[] = 'Email sudah digunakan.';
    }

    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Simpan ke database dengan level default 'customer'
        $insert_query = $pdo->prepare("INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)");
        $isInserted = $insert_query->execute([$username, $email, $hashed_password, 'customer']);

        if ($isInserted) {
            echo "Registrasi berhasil. Silakan login.";
            // Redirect ke halaman login (opsional)
            header("Location: login.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
        }
    } else {
        // Tampilkan error
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!-- Form Registrasi -->
<form method="POST" action="register.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="confirm_password">Konfirmasi Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br>
    <button type="submit">Daftar</button>
</form>