<?php
// Include koneksi database
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';
session_start(); // Mulai sesi untuk memeriksa login pengguna

// Validasi jika `id_jadwal_bus` tidak ada di URL
if (!isset($_GET['id_jadwal_bus']) || empty($_GET['id_jadwal_bus'])) {
    echo "<h3>ID Jadwal Bus tidak ditemukan!</h3>";
    exit;
}

// Ambil ID dari URL
$id_jadwal_bus = $_GET['id_jadwal_bus'];

try {
    // Query untuk mendapatkan data tiket berdasarkan ID
    $stmt = $pdo->prepare("SELECT jb.*, b.nama AS nama_bus, b.gambar AS gambar_bus,
                            t1.nama_terminal AS rute_keberangkatan, t2.nama_terminal AS rute_tujuan
                       FROM jadwal_bus jb
                       JOIN bus b ON jb.id_bus = b.id_bus
                       LEFT JOIN terminal t1 ON jb.rute_keberangkatan = t1.id_terminal
                       LEFT JOIN terminal t2 ON jb.rute_tujuan = t2.id_terminal
                       WHERE jb.id_jadwal_bus = :id_jadwal_bus");
    $stmt->execute(['id_jadwal_bus' => $id_jadwal_bus]);
    $tiket = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data tidak ditemukan
    if (!$tiket) {
        echo "<h3>Detail tiket tidak ditemukan!</h3>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Proses ketika tombol "Pesan Tiket" ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        // Redirect ke halaman login jika belum login
        header("Location: /TiketTransportasiOnline/public/register/login.php");
        exit;
    }

    $id_user = $_SESSION['user']['id_user']; // Ambil ID pengguna yang login

    try {
        $pdo->beginTransaction();

        // Cari nomor kursi yang tersedia
        $stmtKursi = $pdo->prepare("
            SELECT id_kursi 
            FROM kursi 
            WHERE id_jadwal_bus = :id_jadwal_bus AND status = 'available'
            LIMIT 1
        ");
        $stmtKursi->execute(['id_jadwal_bus' => $id_jadwal_bus]);
        $kursi = $stmtKursi->fetch(PDO::FETCH_ASSOC);

        if (!$kursi) {
            echo "<h3>Kursi tidak tersedia untuk jadwal ini.</h3>";
            $pdo->rollBack();
            exit;
        }

        $id_kursi = $kursi['id_kursi'];

        // Tandai kursi sebagai terpakai
        $stmtUpdateKursi = $pdo->prepare("
            UPDATE kursi 
            SET status = 'booked' 
            WHERE id_kursi = :id_kursi
        ");
        $stmtUpdateKursi->execute(['id_kursi' => $id_kursi]);

        // Simpan pemesanan
        $stmtPemesanan = $pdo->prepare("
            INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi) 
            VALUES (:id_user, :id_jadwal_bus, NOW(), :nomor_kursi)
        ");
        $stmtPemesanan->execute([
            'id_user' => $id_user,
            'id_jadwal_bus' => $id_jadwal_bus,
            'nomor_kursi' => $id_kursi
        ]);

        $pdo->commit();
        echo "<h3>Pemesanan berhasil. Nomor kursi Anda: " . htmlspecialchars($id_kursi) . "</h3>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<h3>Terjadi kesalahan: " . $e->getMessage() . "</h3>";
    }
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="../landing/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="../landing/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="../landing/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../landing/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../landing/css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
      >
        <div
          class="spinner-border text-primary"
          style="width: 3rem; height: 3rem"
          role="status"
        >
          <span class="sr-only">Loading...</span>
        </div>
      </div> -->
        <!-- Spinner End -->

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
                        <a href="index.php" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase">Hotelier</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="../../index.php" class="nav-item nav-link">Home</a>
                                <a href="about.php" class="nav-item nav-link active">About</a>
                                <a href="service.php" class="nav-item nav-link">Services</a>
                                <a href="tiket.php" class="nav-item nav-link">Tickets</a>
                                <a href="contact.php" class="nav-item nav-link">Contact</a>
                            </div>
                            <!-- Ikon Notifikasi -->
                            <div class="navbar-nav ml-auto py-0">
                                <a href="pesan.php" class="nav-item nav-link position-relative">
                                    <i class="fa fa-bell text-white"></i>

                                </a>
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
                        Ticket
                    </h1>

                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- main start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- Bagian Gambar -->
                    <div class="col-lg-6">
                        <div class="rounded shadow">
                            <img class="img-fluid rounded"
                                src="<?= !empty($tiket['gambar']) ? '../gambar/bus/' . htmlspecialchars($tiket['gambar']) : '../gambar/bus/default.jpg'; ?>"
                                alt="Bus Image">
                        </div>
                    </div>

                    <!-- Bagian Detail -->
                    <div class="col-lg-6">
                        <div class="detail-content">
                            <h1 class="text-primary mb-4">
                                <?= htmlspecialchars($tiket['rute_keberangkatan']) . ' - ' . htmlspecialchars($tiket['rute_tujuan']); ?>
                            </h1>
                            <p class="mb-3"><strong>Nama Bus:</strong>
                                <?= htmlspecialchars($tiket['nama_bus'] ?? 'Tidak Diketahui'); ?>
                            </p>
                            <p class="mb-3"><strong>Harga Tiket:</strong> Rp.
                                <?= number_format($tiket['harga'] ?? 0, 0, ',', '.'); ?>
                            </p>
                            <p class="mb-3"><strong>Waktu Keberangkatan:</strong>
                                <?= isset($tiket['waktu_keberangkatan'])
                                    ? date('d M Y H:i', strtotime($tiket['waktu_keberangkatan']))
                                    : 'Belum Ditentukan'; ?>
                            </p>
                            <p class="mb-3"><strong>Waktu Kedatangan:</strong>
                                <?= isset($tiket['waktu_kedatangan'])
                                    ? date('d M Y H:i', strtotime($tiket['waktu_kedatangan']))
                                    : 'Belum Ditentukan'; ?>
                            </p>
                            <p class="mb-3"><strong>Rute Transit:</strong>
                                <?= !empty($tiket['rute_transit']) ? htmlspecialchars($tiket['rute_transit']) : 'Tidak Ada'; ?>
                            </p>
                            <p class="mb-4"><strong>Deskripsi:</strong> Tiket perjalanan yang nyaman dan aman dengan
                                fasilitas
                                lengkap, termasuk WiFi dan kursi yang nyaman.</p>

                            <!-- Tombol Aksi -->
                            <div class="d-flex">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <!-- Tombol Pesan Tiket untuk Pengguna yang Login -->
                                    <button class="btn btn-primary rounded py-2 px-4 me-2" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal"
                                        data-id-jadwal="<?= htmlspecialchars($tiket['id_jadwal_bus'] ?? '#') ?>">
                                        Pesan Tiket
                                    </button>
                                <?php else: ?>
                                    <!-- Tombol Login untuk Pengguna yang Belum Login -->
                                    <a href="/TiketTransportasiOnline/public/register/login.php"
                                        class="btn btn-warning rounded py-2 px-4 me-2">
                                        Login untuk Memesan
                                    </a>
                                <?php endif; ?>
                                <!-- Tombol Kembali -->
                                <a href="tiket.php" class="btn btn-secondary rounded py-2 px-4">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pemesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Dengan melanjutkan pemesanan, Anda menyetujui semua kebijakan kami.
                            Silakan pastikan data pemesanan sudah benar sebelum melanjutkan.</p>
                        <p><strong>Ketentuan:</strong> Tiket yang sudah dipesan dapat dibatalkan tapi anda akan kena
                            penalti dari itu, dan Anda
                            diwajibkan
                            untuk membayar sebelum tenggat waktu.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="button" class="btn btn-primary" id="confirmBooking">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- main end -->

        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <h4 class="mb-4">
                                Selamat Memesan
                                <span class="text-primary text-uppercase">Tiket</span>
                            </h4>

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
                                <h1 class="text-white text-uppercase mb-3">Hotelier</h1>
                            </a>
                            <p class="text-white mb-0">
                                Download
                                <a class="text-dark fw-medium"
                                    href="https://htmlcodex.com/hotel-html-template-pro">Hotelier – Premium
                                    Version</a>, build a professional website for your hotel business and
                                grab the attention of new visitors upon your site’s launch.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">
                            Contact
                        </h6>
                        <p class="mb-2">
                            <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York,
                            USA
                        </p>
                        <p class="mb-2">
                            <i class="fa fa-phone-alt me-3"></i>+628 1234 56780
                        </p>
                        <p class="mb-2">
                            <i class="fa fa-envelope me-3"></i>TicketTransportation@gmail.com
                        </p>
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
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">
                                    Company
                                </h6>
                                <a class="btn btn-link" href="">About Us</a>
                                <a class="btn btn-link" href="">Contact Us</a>
                                <a class="btn btn-link" href="">Privacy Policy</a>
                                <a class="btn btn-link" href="">Terms & Condition</a>
                                <a class="btn btn-link" href="">Support</a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">
                                    Services
                                </h6>
                                <a class="btn btn-link" href="">Food & Restaurant</a>
                                <a class="btn btn-link" href="">Spa & Fitness</a>
                                <a class="btn btn-link" href="">Sports & Gaming</a>
                                <a class="btn btn-link" href="">Event & Party</a>
                                <a class="btn btn-link" href="">GYM & Yoga</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All
                            Right Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By
                            <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const confirmButton = document.getElementById("confirmBooking");

            confirmButton.addEventListener("click", () => {
                // Ambil ID jadwal dari tombol data
                const idJadwal = document.querySelector("[data-id-jadwal]").getAttribute("data-id-jadwal");

                // Kirim request ke booking.php
                fetch(`booking.php?id_jadwal_bus=${idJadwal}`)
                    .then(response => response.text())
                    .then(result => {
                        // Tampilkan hasil pesan
                        alert(result);
                        location.reload(); // Refresh halaman untuk update status
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan saat memesan tiket.");
                    });
            });
        });
    </script>
</body>

</html>