<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daftar Bandara</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/FinalProject/public/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/FinalProject/public/adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar, Sidebar, dan Content Header -->
    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="content-wrapper">
        <div class="content-header">
            <h1>Daftar Bandara</h1>
            <a href="create.php" class="btn btn-success">Tambah Bandara</a>
        </div>
        
        <section class="content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Bandara</th>
                        <th>ISO 9001</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Looping data bandara dari database -->
                    <?php foreach ($bandaraData as $bandara): ?>
                        <tr>
                            <td><?= $bandara['id']; ?></td>
                            <td><?= $bandara['nama']; ?></td>
                            <td><?= $bandara['iso_9001'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $bandara['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $bandara['id']; ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <?php include '../includes/footer.php'; ?>
</div>
<script src="/FinalProject/public/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/FinalProject/public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/FinalProject/public/adminlte/dist/js/adminlte.js"></script>
</body>
</html>
