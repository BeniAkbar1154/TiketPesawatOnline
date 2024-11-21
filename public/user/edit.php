<?php
require_once __DIR__ . '/../../src/controller/UserController.php';

$userController = new UserController($pdo);

if (!isset($_GET['id'])) {
    header('Location: user.php');
    exit;
}

$id = $_GET['id'];
$user = $userController->getUserById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'no_telepon' => $_POST['no_telepon'],
        'role' => $_POST['role'],
    ];

    if ($userController->updateUser($id, $data)) {
        header('Location: user.php');
        exit;
    } else {
        $error = "Gagal mengupdate user!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../adminlte/css/adminlte.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control" value="<?= $user['no_telepon'] ?>" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="petugas" <?= $user['role'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="user.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>