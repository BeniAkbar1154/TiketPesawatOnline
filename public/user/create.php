<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once __DIR__ . '/../../src/controller/UserController.php';

// Pastikan $pdo terhubung dengan database
$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'nama' => $_POST['nama'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'no_telepon' => $_POST['no_telepon'],
    'role' => $_POST['role'],
  ];

  if ($userController->createUser($data)) {
    header('Location: user.php');
    exit;
  } else {
    $error = "Gagal menambahkan user!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tambah User</title>
  <link rel="stylesheet" href="../adminlte/css/adminlte.min.css">
</head>

<body>
  <div class="container mt-5">
    <h2>Tambah User</h2>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="form-group">
        <label>No. Telepon</label>
        <input type="text" name="no_telepon" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
          <option value="customer">Customer</option>
          <option value="petugas">Petugas</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Tambah</button>
      <a href="user.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>

</html>