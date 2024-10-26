<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Destinasi</title>
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
            <h1>Edit Destinasi</h1>
        </div>
        
        <section class="content">
            <form action="edit_process.php" method="POST">
                <input type="hidden" name="id" value="<?= $destinasi['id']; ?>">
                <div class="form-group">
                    <label>Nama Destinasi</label>
                    <input type="text" name="destinasi" class="form-control" value="<?= $destinasi['destinasi']; ?>" required>
                </div>
                <div class="form-group">
                    <label>ISO</label>
                    <input type="text" name="iso" class="form-control" value="<?= $destinasi['iso']; ?>" required>
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
