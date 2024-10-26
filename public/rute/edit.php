<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Rute</title>
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
            <h1>Edit Rute</h1>
        </div>

        <section class="content">
            <form action="edit_process.php" method="POST">
                <input type="hidden" name="id" value="<?= $rute['id']; ?>">
                <div class="form-group">
                    <label>Transit</label>
                    <input type="text" name="transit" class="form-control" value="<?= $rute['transit']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Rute Awal</label>
                    <input type="text" name="rute_awal" class="form-control" value="<?= $rute['rute_awal']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Rute Akhir</label>
                    <input type="text" name="rute_akhir" class="form-control" value="<?= $rute['rute_akhir']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Kedatangan</label>
                    <input type="time" name="kedatangan" class="form-control" value="<?= $rute['kedatangan']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" value="<?= $rute['harga']; ?>" required>
                </div>
                <div class="form-group">
                    <label>ID Pesawat</label>
                    <input type="number" name="id_pesawat" class="form-control" value="<?= $rute['id_pesawat']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Dibuat</label>
                    <input type="date" name="tanggal_dibuat" class="form-control" value="<?= $rute['tanggal_dibuat']; ?>" required>
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
