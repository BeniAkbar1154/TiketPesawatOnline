<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Pemesanan</title>
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
            <h1>Edit Pemesanan</h1>
        </div>

        <section class="content">
            <form action="edit_process.php" method="POST">
                <input type="hidden" name="id" value="<?= $pemesanan['id']; ?>">
                <div class="form-group">
                    <label>User Pemesan</label>
                    <input type="text" name="id_user" class="form-control" value="<?= $pemesanan['id_user']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" class="form-control" value="<?= $pemesanan['tanggal_pemesanan']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Nomor Kursi</label>
                    <input type="text" name="nomor_kursi" class="form-control" value="<?= $pemesanan['nomor_kursi']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Rute</label>
                    <input type="text" name="id_rute" class="form-control" value="<?= $pemesanan['id_rute']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="<?= $pemesanan['status']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </section>
    </div>
    <?php include '../includes/footer.php'; ?>
</div>
<script src="/FinalProject/public/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/FinalProject/public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/FinalProject/public/adminlte/dist/js/adminlte.js"></script>
</body>
</html>
