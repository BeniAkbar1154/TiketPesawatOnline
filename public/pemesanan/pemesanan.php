<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daftar Pemesanan</title>
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
            <h1>Daftar Pemesanan</h1>
            <a href="create.php" class="btn btn-success">Tambah Pemesanan</a>
        </div>

        <section class="content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Pemesan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Nomor Kursi</th>
                        <th>Rute</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Looping data pemesanan dari database -->
                    <?php foreach ($pemesananData as $pemesanan): ?>
                        <tr>
                            <td><?= $pemesanan['id']; ?></td>
                            <td><?= $pemesanan['id_user']; ?></td>
                            <td><?= $pemesanan['tanggal_pemesanan']; ?></td>
                            <td><?= $pemesanan['nomor_kursi']; ?></td>
                            <td><?= $pemesanan['id_rute']; ?></td>
                            <td><?= $pemesanan['status']; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $pemesanan['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $pemesanan['id']; ?>" class="btn btn-danger">Hapus</a>
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
