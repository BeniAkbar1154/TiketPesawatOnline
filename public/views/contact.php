<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/src/controller/PesanController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/src/controller/JadwalBusController.php';

session_start();

// Cek apakah user sudah login
$isLoggedIn = isset($_SESSION['user']); // Periksa apakah user ada dalam sesi
$username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : null; // Ambil username dari sesi
$id_user = $isLoggedIn ? $_SESSION['user']['id_user'] : null; // Ambil id_user dari sesi jika login

// Menghitung jumlah bus
$stmtBus = $pdo->query("SELECT COUNT(*) AS total_bus FROM bus");
$totalBus = $stmtBus->fetch(PDO::FETCH_ASSOC)['total_bus'];

// Menghitung jumlah staf (petugas, admin, superadmin)
$stmtStaff = $pdo->query("SELECT COUNT(*) AS total_staff FROM user WHERE level IN ('admin', 'petugas', 'superadmin')");
$totalStaff = $stmtStaff->fetch(PDO::FETCH_ASSOC)['total_staff'];

// Menghitung jumlah klien (customer)
$stmtClients = $pdo->query("SELECT COUNT(*) AS total_clients FROM user WHERE level = 'customer'");
$totalClients = $stmtClients->fetch(PDO::FETCH_ASSOC)['total_clients'];

$pesanController = new PesanController($pdo);

// Logika untuk menangani pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_user = $_POST['id_user'] ?? '';
  $pesan = $_POST['pesan'] ?? '';

  if (!empty($id_user) && !empty($pesan)) {
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
$jadwalBuses = $jadwalBusController->getAllSchedules();

$notificationCount = 0;
if ($isLoggedIn && isset($_SESSION['id_user'])) {
  $id_user = $_SESSION['id_user'];

  // Query untuk mengambil jumlah pesan yang belum dibaca
  $stmt_notifikasi = $pdo->prepare("
        SELECT COUNT(*) AS count 
        FROM pesan 
        WHERE id_user = :id_user AND status = 'unread'
    ");
  $stmt_notifikasi->execute(['id_user' => $id_user]);
  $notificationCount = $stmt_notifikasi->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Tiket Transportasi Online</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="../landing/lib/animate/animate.min.css" rel="stylesheet" />
  <link href="../landing/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
  <link href="../landing/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="../landing/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="../landing/css/style.css" rel="stylesheet" />
</head>

<body>
  <div class="container-xxl bg-white p-0">


    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0">
      <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
          <a href="../../index.php"
            class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
            <h1 class="m-0 text-primary text-uppercase">Ticket Bus</h1>
          </a>
        </div>
        <div class="col-lg-9">
          <div class="row gx-0 bg-white d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
              <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                <i class="fa fa-envelope text-primary me-2"></i>
                <p class="mb-0">TicketTransportation@gmail.com</p>
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
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
              <div class="navbar-nav mr-auto py-0">
                <a href="../../index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="service.php" class="nav-item nav-link">Services</a>
                <a href="tiket.php" class="nav-item nav-link">Tickets</a>
                <a href="contact.php" class="nav-item nav-link active">Contact</a>
              </div>
              <!-- Ikon Notifikasi -->
              <div class="navbar-nav ml-auto py-0">
                <a href="public/views/pesan.php" class="nav-item nav-link position-relative">
                  <i class="fa fa-bell text-white"></i>
                  <?php if ($notificationCount > 0): ?>
                    <span class="badge bg-danger rounded-circle position-absolute" style="top: 5px; right: -5px;">
                      <?= $notificationCount ?>
                    </span>
                  <?php endif; ?>
                </a>
              </div>

              <div class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">
                <span class="text-white me-3">
                  <?php if ($username): ?>
                    Selamat datang, <?= htmlspecialchars($username) ?>!
                  <?php else: ?>
                    Anda belum login
                  <?php endif; ?>
                </span>

                <?php if ($username): ?>
                  <a href="public/register/logout.php" class="btn btn-danger btn-sm">
                    Logout
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg)">
      <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
          <h1 class="display-3 text-white mb-3 animated slideInDown">
            Contact
          </h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Pages</a></li>
              <li class="breadcrumb-item text-white active" aria-current="page">
                Contact
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title text-center text-primary text-uppercase">
            Contact Us
          </h6>
          <h1 class="mb-5">
            <span class="text-primary text-uppercase">Contact</span> For Any
            Query
          </h1>
        </div>
        <div class="row g-4">
          <div class="col-12">
            <div class="row gy-4">
              <div class="col-md-4">
                <h6 class="section-title text-start text-primary text-uppercase">
                  Booking
                </h6>
                <p>
                  <i class="fa fa-envelope-open text-primary me-2"></i>book@example.com
                </p>
              </div>
              <div class="col-md-4">
                <h6 class="section-title text-start text-primary text-uppercase">
                  General
                </h6>
                <p>
                  <i class="fa fa-envelope-open text-primary me-2"></i>info@example.com
                </p>
              </div>
              <div class="col-md-4">
                <h6 class="section-title text-start text-primary text-uppercase">
                  Technical
                </h6>
                <p>
                  <i class="fa fa-envelope-open text-primary me-2"></i>tech@example.com
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
            <iframe class="position-relative rounded w-100 h-100"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
              frameborder="0" style="min-height: 350px; border: 0" allowfullscreen="" aria-hidden="false"
              tabindex="0"></iframe>
          </div>
          <div class="col-md-6">
            <div class="wow fadeInUp" data-wow-delay="0.2s">
              <form>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="name" placeholder="Your Name" />
                      <label for="name">Your Name</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="email" class="form-control" id="email" placeholder="Your Email" />
                      <label for="email">Your Email</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="subject" placeholder="Subject" />
                      <label for="subject">Subject</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating">
                      <textarea class="form-control" placeholder="Leave a message here" id="message"
                        style="height: 150px"></textarea>
                      <label for="message">Message</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit">
                      Send Message
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Contact End -->

    <!-- Newsletter Start -->
    <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
      <div class="row justify-content-center">
        <div class="col-lg-10 border rounded p-1">
          <div class="border rounded text-center p-1">
            <div class="bg-white rounded text-center p-5">
              <h4 class="mb-4">
                Subscribe Our
                <span class="text-primary text-uppercase">Newsletter</span>
              </h4>
              <div class="position-relative mx-auto" style="max-width: 400px">
                <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email" />
                <button type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../landing/lib/wow/wow.min.js"></script>
  <script src="../landing/lib/easing/easing.min.js"></script>
  <script src="../landing/lib/waypoints/waypoints.min.js"></script>
  <script src="../landing/lib/counterup/counterup.min.js"></script>
  <script src="../landing/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="../landing/lib/tempusdominus/js/moment.min.js"></script>
  <script src="../landing/lib/tempusdominus/js/moment-timezone.min.js"></script>
  <script src="../landing/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

  <!-- Template Javascript -->
  <script src="../landing/js/main.js"></script>
</body>

</html>