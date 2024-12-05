<?php
require_once __DIR__ . '/../../database/db_connection.php';

session_start();  // Mulai session

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil data level user dan username dari session
$userLevel = $_SESSION['user']['level'];
$userName = $_SESSION['user']['username']; // Ambil username dari session

// Periksa apakah level user adalah 'customer'
if ($userLevel === 'customer') {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $id_jadwal_bus = $_POST['id_jadwal_bus'];

    // Ambil data jadwal bus untuk menghitung tagihan dan tenggat waktu
    $stmt = $pdo->prepare("
        SELECT harga, DATE_SUB(datetime_keberangkatan, INTERVAL 2 HOUR) AS tenggat_waktu
        FROM jadwal_bus
        WHERE id_jadwal_bus = ?
    ");
    $stmt->execute([$id_jadwal_bus]);
    $jadwal_bus = $stmt->fetch();

    $tagihan = $jadwal_bus['harga'];
    $tenggat_waktu = $jadwal_bus['tenggat_waktu'];
    $tanggal_pemesanan = date('Y-m-d H:i:s'); // Waktu sekarang
    $nomor_kursi = $_POST['nomor_kursi'];

    // Insert data ke tabel pemesanan
    $stmt = $pdo->prepare("
        INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tagihan, tenggat_waktu)
        VALUES (?, ?, ?, ?, 'pending', ?, ?)
    ");
    $stmt->execute([$id_user, $id_jadwal_bus, $tanggal_pemesanan, $nomor_kursi, $tagihan, $tenggat_waktu]);

    header('Location: pemesanan.php');
    exit;
}

// Ambil data pengguna
$users = $pdo->query("SELECT id_user, username FROM user")->fetchAll();

// Ambil data jadwal bus beserta nama terminal keberangkatan, tujuan, dan harga
$jadwal_bus = $pdo->query("
    SELECT 
        j.id_jadwal_bus, 
        t1.nama_terminal AS terminal_keberangkatan, 
        t2.nama_terminal AS terminal_tujuan, 
        j.harga
    FROM jadwal_bus j
    JOIN terminal t1 ON j.rute_keberangkatan = t1.id_terminal
    JOIN terminal t2 ON j.rute_tujuan = t2.id_terminal
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket Transportation</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
    <script>
        function updateTagihan() {
            const jadwal = document.getElementById('id_jadwal_bus');
            const harga = jadwal.options[jadwal.selectedIndex].dataset.harga;
            document.getElementById('tagihan').value = harga;
        }
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../dashboard/dashboard.php" class="nav-link">Home</a>
                </li>

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Tampilan User Panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= htmlspecialchars($userName) ?></a>
                        <!-- Menampilkan nama user -->
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Menu User -->
                        <li class="nav-item">
                            <a href="../user/user.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i> <!-- Ikon User -->
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pesan/pesan.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i> <!-- Ikon User -->
                                <p>Pesan</p>
                            </a>
                        </li>

                        <!-- Menu Bus -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-bus"></i> <!-- Ikon Bus -->
                                <p>
                                    Bus
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../bus/bus.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bus</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../terminal/terminal.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Terminal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pemberhentian/pemberhentian.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pemberhentian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../jadwalBus/jadwalBus.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jadwal Bus</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Menu Administrasi -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-cogs"></i> <!-- Ikon Administrasi -->
                                <p>
                                    Administrasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../pemesanan/pemesanan.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pemesanan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pembayaran/pembayaran.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pembayaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../tiket/tiket.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tiket</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Menu Laporan -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-chart-line"></i> <!-- Ikon Laporan -->
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../laporanHarian/laporanHarian.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Harian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../laporanKhusus/laporanKhusus.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Khusus</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <a href="../register/logout.php" class="btn btn-danger">Logout</a>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v3</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pemesanan</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="id_user">Pengguna:</label>
                                <select name="id_user" id="id_user" class="form-control" required>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_jadwal_bus">Jadwal Bus:</label>
                                <select name="id_jadwal_bus" id="id_jadwal_bus" class="form-control"
                                    onchange="updateTagihan()" required>
                                    <?php foreach ($jadwal_bus as $jadwal): ?>
                                        <option value="<?= $jadwal['id_jadwal_bus'] ?>"
                                            data-harga="<?= $jadwal['harga'] ?>">
                                            <?= $jadwal['terminal_keberangkatan'] ?> ke <?= $jadwal['terminal_tujuan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
                                <input type="text" name="tanggal_pemesanan" id="tanggal_pemesanan" class="form-control"
                                    value="<?= date('Y-m-d H:i:s') ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="nomor_kursi">Nomor Kursi:</label>
                                <input type="text" name="nomor_kursi" id="nomor_kursi" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="tagihan">Tagihan:</label>
                                <input type="number" name="tagihan" id="tagihan" class="form-control" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
        </footer>
    </div>

    <!-- jQuery -->
    <script src="../adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="../adminlte/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="../adminlte/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../adminlte/dist/js/demo.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../adminlte/dist/js/pages/dashboard3.js"></script>
</body>

</html>