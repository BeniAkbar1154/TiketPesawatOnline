<?php
// Mulai session dan koneksi ke database
session_start();
include_once('../../database/db_connection.php');

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $level = $_POST['level'];

    // Insert user baru ke database
    $sql = "INSERT INTO users (username, email, password, level) VALUES ('$username', '$email', '$password', '$level')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User berhasil dibuat!'); window.location.href='user.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User</title>
  <!-- Include Bootstrap & AdminLTE CSS -->
  <link rel="stylesheet" href="/FinalProject/public/adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/FinalProject/public/adminlte/dist/css/adminlte.min.css">
</head>
<body>
<div class="container mt-5">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Create New User</h3>
    </div>
    <!-- Form untuk membuat user baru -->
    <form method="POST">
      <div class="card-body">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
        </div>
        <div class="form-group">
          <label for="level">User Level</label>
          <select name="level" class="form-control" id="level">
            <option value="1">Customer</option>
            <option value="2">Petugas</option>
            <option value="3">Admin</option>
          </select>
        </div>
      </div>
      <!-- Submit button -->
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Create User</button>
      </div>
    </form>
  </div>
</div>

<!-- Include jQuery & Bootstrap JS -->
<script src="/FinalProject/public/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/FinalProject/public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/FinalProject/public/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
