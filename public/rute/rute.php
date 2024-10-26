<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daftar Rute</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/FinalProject/public/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/FinalProject/public/adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <h1>Daftar Rute</h1>
            <a href="create.php" class="btn btn-success">Tambah Rute</a>
        </div>

        <section class="content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transit</th>
                        <th>Rute Awal</th>
                        <th>Rute Akhir</th>
                        <th>Kedatangan</th>
                        <th>Harga</th>
                        <th>ID Pesawat</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Looping data rute dari database -->
                    <?php foreach ($ruteData as $rute): ?>
                        <tr>
                            <td><?= $rute['id']; ?></td>
                            <td><?= $rute['transit']; ?></td>
                            <td><?= $rute['rute_awal']; ?></td>
                            <td><?= $rute['rute_akhir']; ?></td>
                            <td><?= $rute['kedatangan']; ?></td>
                            <td><?= $rute['harga']; ?></td>
                            <td><?= $rute['id_pesawat']; ?></td>
                            <td><?= $rute['tanggal_dibuat']; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $rute['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $rute['id']; ?>" class="btn btn-danger">Hapus</a>
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
