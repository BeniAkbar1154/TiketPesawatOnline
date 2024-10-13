<?php
// Koneksi ke database
include_once('../../database/db_connection.php');

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data user berdasarkan ID
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User tidak ditemukan!";
    exit();
}

// Update data user jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    $sql = "UPDATE users SET username='$username', email='$email', level='$level' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: user.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Link CSS AdminLTE -->
    <link rel="stylesheet" href="/FinalProject/public/adminlte/css/adminlte.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <input type="number" class="form-control" id="level" name="level" value="<?= $user['level'] ?>" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    
    <!-- Script AdminLTE -->
    <script src="/FinalProject/public/adminlte/js/adminlte.min.js"></script>
</body>
</html>
