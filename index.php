<?php
require_once __DIR__ . '/database/db_connection.php';
require_once __DIR__ . '/src/controller/PesanController.php'; // Perbaiki jalur file
require_once __DIR__ . '/src/controller/JadwalBusController.php'; // Perbaiki jalur file

session_start();

// Cek apakah user sudah login
$isLoggedIn = isset($_SESSION['username']); // Ganti 'username' sesuai dengan nama sesi yang Anda gunakan
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

// Menghitung jumlah bus
$stmtBus = $pdo->query("SELECT COUNT(*) AS total_bus FROM bus");
$totalBus = $stmtBus->fetch(PDO::FETCH_ASSOC)['total_bus'] ?? 0; // Jika tidak ada data, set default 0

// Menghitung jumlah staf (petugas, admin, superadmin)
$stmtStaff = $pdo->query("SELECT COUNT(*) AS total_staff FROM user WHERE level IN ('admin', 'petugas', 'superadmin')");
$totalStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC)['total_staff'] ?? 0; // Jika tidak ada data, set default 0

// Menghitung jumlah klien (customer)
$stmtClients = $pdo->query("SELECT COUNT(*) AS total_clients FROM user WHERE level = 'customer'");
$totalClients = $stmtClients->fetch(PDO::FETCH_ASSOC)['total_clients'] ?? 0; // Jika tidak ada data, set default 0

$pesanController = new PesanController($pdo);

// Logika untuk menangani pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form yang dikirimkan menggunakan AJAX
    $id_user = $_POST['id_user'] ?? '';  // Gunakan null coalescing operator untuk menghindari undefined index
    $pesan = $_POST['pesan'] ?? '';  // Gunakan null coalescing operator untuk menghindari undefined index

    // Cek jika id_user dan pesan tidak kosong
    if (!empty($id_user) && !empty($pesan)) {
        // Simpan pesan ke database
        if ($pesanController->create($id_user, $pesan)) {
            echo "Pesan berhasil dikirim!";
        } else {
            echo "Gagal mengirim pesan. Coba lagi.";
        }
    } else {
        echo "ID User dan Pesan tidak boleh kosong.";
    }
}

$jadwalBusController = new JadwalBusController($pdo);

// Ambil semua jadwal bus
$stmt_jadwal = $pdo->query("
    SELECT *, 
           b.nama AS nama_bus, 
           b.gambar AS gambar_bus,
           t1.nama_terminal AS rute_keberangkatan, 
           t2.nama_terminal AS rute_tujuan
    FROM jadwal_bus
    JOIN bus b ON jadwal_bus.id_bus = b.id_bus
    LEFT JOIN terminal t1 ON jadwal_bus.rute_keberangkatan = t1.id_terminal
    LEFT JOIN terminal t2 ON jadwal_bus.rute_tujuan = t2.id_terminal
");
$jadwalBuses = $stmt_jadwal->fetchAll(PDO::FETCH_ASSOC);

// Ambil jumlah notifikasi untuk user
$notificationCount = 0;
if ($isLoggedIn && isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    $stmt_notifikasi = $pdo->prepare("
        SELECT COUNT(*) AS count 
        FROM notifikasi 
        WHERE id_user = :id_user AND status = 'unread'
    ");
    $stmt_notifikasi->execute(['id_user' => $id_user]);
    $notificationCount = $stmt_notifikasi->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
}
?>


<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tiket Transportasi Online</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="public/landing/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public/landing/lib/animate/animate.min.css" rel="stylesheet">
    <link href="public/landing/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="public/landing/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="public/landing/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="public/landing/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="#"
                        class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase">Ticket Bus</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                <p class="mb-0">TicketTransport@gmail.com</p>
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2">
                                <i class="fa fa-phone-alt text-primary me-2"></i>
                                <p class="mb-0">+628 1234 5678</p>
                            </div>
                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                                <a class="" href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="index.html" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase">Hotelier</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="index.php" class="nav-item nav-link active">Home</a>
                                <a href="public/views/about.php" class="nav-item nav-link">About</a>
                                <a href="public/views/service.php" class="nav-item nav-link">Services</a>
                                <a href="public/views/tiket.php" class="nav-item nav-link">Tickets</a>

                                <a href="public/views/contact.php" class="nav-item nav-link">Contact</a>
                            </div>
                            <!-- Ikon Notifikasi -->
                            <div class="navbar-nav ml-auto py-0">
                                <a href="public/views/pesan.php" class="nav-item nav-link position-relative">
                                    <i class="fa fa-bell text-white"></i>
                                    <?php if ($notificationCount > 0): ?>
                                        <span class="badge bg-danger rounded-circle position-absolute"
                                            style="top: 5px; right: -5px;">
                                            <?= $notificationCount ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <a href="#" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">
                                <?php if ($isLoggedIn): ?>
                                    Selamat datang, <?= $username ?>!
                                <?php else: ?>
                                    Anda belum login
                                <?php endif; ?>
                            </a>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="public/landing/img/carousel-1.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">
                                    Tiket Bus Online</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Temukan Tiket Bus Yang
                                    Terbaik</h1>
                                <a href="public/register/register.php"
                                    class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Register</a>
                                <a href="public/register/login.php"
                                    class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Login</a>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="public/landing/img/carousel-2.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">
                                    Tiket Bus Online</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Temukan Tiket Bus Yang
                                </h1>
                                <a href="public/register/register.php"
                                    class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Register</a>
                                <a href="public/register/login.php"
                                    class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">
                                    Login</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->



        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">About Us</h6>
                        <h1 class="mb-4">Selamat Datang Di <br> <span class="text-primary text-uppercase">Ticket
                                Bus</span>
                        </h1>
                        <p class="mb-4"></p><span class="text-primary text-uppercase">Ticket
                            Bus</span> adalah website pemesanan tiket bus online yang terpercaya dan terjamin oleh
                        perusahaan bus
                        </p>
                        <div class="row g-3 pb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-bus fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= $totalBus ?></h2>
                                        <p class="mb-0">Bus</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-user-shield fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= $totalStaff ?></h2>
                                        <p class="mb-0">Staffs</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= $totalClients ?></h2>
                                        <p class="mb-0">Clients</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s"
                                    src="public/landing/img/about-1.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s"
                                    src="public/landing/img/about-2.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s"
                                    src="public/landing/img/about-3.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s"
                                    src="public/landing/img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Ticket Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Tickets</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Tickets</span></h1>
                </div>
                <div class="row g-4">
                    <?php
                    if (!empty($jadwalBuses)) {
                        // Ambil maksimal 3 data
                        $jadwalBuses = array_slice($jadwalBuses, 0, 3);

                        foreach ($jadwalBuses as $jadwal) {
                            // Validasi gambar bus
                            $gambarBus = !empty($jadwal['gambar']) ? 'public/landing/img/bus/' . $jadwal['gambar'] : 'public/landing/img/bus/default.jpg';

                            // Validasi waktu keberangkatan
                            $waktuKeberangkatan = !empty($jadwal['datetime_keberangkatan']) ? date('d M Y H:i', strtotime($jadwal['datetime_keberangkatan'])) : 'Belum ditentukan';

                            // Validasi waktu sampai
                            $waktuSampai = !empty($jadwal['datetime_sampai']) ? date('d M Y H:i', strtotime($jadwal['datetime_sampai'])) : 'Belum ditentukan';

                            // Informasi tambahan
                            $hargaTiket = !empty($jadwal['harga']) ? number_format($jadwal['harga'], 0, ',', '.') : 'N/A'; // Pastikan harga ada
                            $namaRute = $jadwal['rute_keberangkatan'] . ' - ' . $jadwal['rute_tujuan'];
                            ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="room-item shadow rounded overflow-hidden">
                                    <div class="position-relative">
                                        <img class="img-fluid" src="<?php echo $gambarBus; ?>" alt="Bus Image">
                                        <small
                                            class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">Rp.
                                            <?php echo $hargaTiket; ?>/Tiket</small>
                                    </div>
                                    <div class="p-4 mt-2">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0"><?php echo $namaRute; ?></h5>
                                            <div class="ps-2">
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>2
                                                Kursi
                                                Bersandingan</small>
                                            <?php if (!empty($jadwal['rute_transit'])) { ?>
                                                <small class="border-end me-3 pe-3"><i
                                                        class="fa fa-train text-primary me-2"></i>Transit</small>
                                            <?php } ?>
                                            <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                        </div>

                                        <p class="text-body mb-3">
                                            <?php echo $waktuKeberangkatan . ' - ' . $waktuSampai; ?>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <a class="btn btn-sm btn-primary rounded py-2 px-4"
                                                href="public/views/detail.php?id_jadwal_bus=<?php echo $jadwal['id_jadwal_bus']; ?>">View
                                                Detail</a>
                                            <a class="btn btn-sm btn-dark rounded py-2 px-4" href="booking.php">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Jika tidak ada tiket
                        ?>
                        <div class="text-center">
                            <h4 class="text-danger">Tiket Kosong</h4>
                            <p>Belum ada jadwal tiket yang tersedia saat ini.</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="text-center mt-4">
                    <a class="btn btn-primary rounded py-2 px-4" href="public/views/tiket.php">Lihat Semua Tiket</a>
                </div>
            </div>
        </div>



        <!-- Ticket End -->

        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Layanan Kami</h6>
                    <h1 class="mb-5">Jelajahi <span class="text-primary text-uppercase">Layanan</span> Kami</h1>
                </div>
                <div class="row g-4">
                    <!-- Poin 1: Reservasi Bus -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-bus fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Reservasi Bus</h5>
                            <p class="text-body mb-0">Pesan kursi Anda dengan mudah melalui layanan reservasi bus kami.
                            </p>
                        </a>
                    </div>
                    <!-- Poin 2: Jadwal Bus -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-clock fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Jadwal Bus</h5>
                            <p class="text-body mb-0">Lihat jadwal keberangkatan dan kedatangan bus secara real-time.
                            </p>
                        </a>
                    </div>
                    <!-- Poin 3: Rute Perjalanan -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-map-marker-alt fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Rute Perjalanan</h5>
                            <p class="text-body mb-0">Temukan informasi lengkap tentang rute perjalanan bus.</p>
                        </a>
                    </div>
                    <!-- Poin 4: Layanan Bus -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-concierge-bell fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Layanan Bus</h5>
                            <p class="text-body mb-0">Nikmati layanan bus dengan fasilitas terbaik dan nyaman.</p>
                        </a>
                    </div>
                    <!-- Poin 5: Tiket Online -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-ticket-alt fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Tiket Online</h5>
                            <p class="text-body mb-0">Pesan tiket secara online dengan mudah dan cepat.</p>
                        </a>
                    </div>
                    <!-- Poin 6: Pelacakan Bus -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div
                                    class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-route fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Pelacakan Bus</h5>
                            <p class="text-body mb-0">Pantau lokasi bus secara langsung melalui fitur pelacakan.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service End -->


        <!-- Testimonial Start -->
        <div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="owl-carousel testimonial-carousel py-5">
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet
                            diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="public/landing/img/testimonial-1.jpg"
                                style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet
                            diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="public/landing/img/testimonial-2.jpg"
                                style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet
                            diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="public/landing/img/testimonial-3.jpg"
                                style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <h4 class="mb-4">Hubungi <span class="text-primary text-uppercase">Kami</span></h4>
                            <form id="pesanForm">
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <!-- Input untuk ID User -->
                                    <input class="form-control w-100 py-3 ps-4 pe-5 mb-3" type="text" name="id_user"
                                        id="id_user" placeholder="Masukkan ID Anda" required>
                                </div>
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <!-- Input untuk Pesan -->
                                    <textarea class="form-control w-100 py-3 ps-4 pe-5 mb-3" name="pesan" id="pesan"
                                        placeholder="Masukkan pesan Anda" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary py-2 px-4 mt-2">Kirim Pesan</button>
                            </form>
                            <div id="responseMessage" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Handle form submission with AJAX
            document.getElementById('pesanForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Get form data
                var id_user = document.getElementById('id_user').value;
                var pesan = document.getElementById('pesan').value;

                // Prepare data for AJAX request
                var formData = new FormData();
                formData.append('id_user', id_user);
                formData.append('pesan', pesan);

                // AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php', true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Show response message from server
                        document.getElementById('responseMessage').innerHTML = xhr.responseText;
                    }
                };
                xhr.send(formData);
            });
        </script>


        <!-- Newsletter Start -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4">
                        <div class="bg-primary rounded p-4">
                            <a href="index.html">
                                <h1 class="text-white text-uppercase mb-3">Ticket Bus</h1>
                            </a>
                            <p class="text-white mb-0">
                                Ticket Bus adalah sebuah website yang menyediakan layanan untuk memesan tiket bus
                                secara online. Website ini memudahkan pengguna untuk memesan tiket bus dengan mudah dan
                                cepat.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Karawang, Jawa Barat</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+628123456789</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>TicketTransportation@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Company</h6>
                                <a class="btn btn-link" href="">About Us</a>
                                <a class="btn btn-link" href="">Contact Us</a>
                                <a class="btn btn-link" href="">Privacy Policy</a>
                                <a class="btn btn-link" href="">Terms & Condition</a>
                                <a class="btn btn-link" href="">Support</a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Services</h6>
                                <a class="btn btn-link" href="">Reservasi Bus</a>
                                <a class="btn btn-link" href="">Ticket Online</a>
                                <a class="btn btn-link" href="">Jadwal Bus</a>
                                <a class="btn btn-link" href="">Pelacakan Bus</a>
                                <a class="btn btn-link" href="">Rute Bus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->


            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="public/landing/lib/wow/wow.min.js"></script>
        <script src="public/landing/lib/easing/easing.min.js"></script>
        <script src="public/landing/lib/waypoints/waypoints.min.js"></script>
        <script src="public/landing/lib/counterup/counterup.min.js"></script>
        <script src="public/landing/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="public/landing/lib/tempusdominus/js/moment.min.js"></script>
        <script src="public/landing/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="public/landing/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="public/landing/js/main.js"></script>
</body>

</html>