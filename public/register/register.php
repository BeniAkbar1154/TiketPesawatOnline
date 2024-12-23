<?php
require_once __DIR__ . '/../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi input
    $errors = [];
    if (empty($username)) {
        $errors[] = 'Username tidak boleh kosong.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    if (empty($password)) {
        $errors[] = 'Password tidak boleh kosong.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Password dan Konfirmasi Password tidak cocok.';
    }

    // Periksa apakah email sudah terdaftar
    $query = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $query->execute([$email]);
    if ($query->rowCount() > 0) {
        $errors[] = 'Email sudah digunakan.';
    }

    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Simpan ke database dengan level default 'customer'
        $insert_query = $pdo->prepare("INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)");
        $isInserted = $insert_query->execute([$username, $email, $hashed_password, 'customer']);

        if ($isInserted) {
            echo "Registrasi berhasil. Silakan login.";
            // Redirect ke halaman login (opsional)
            header("Location: login.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
        }
    } else {
        // Tampilkan error
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
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
    <link href="../landing/img/favicon.ico" rel="icon">

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
    <link href="../landing/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../landing/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../landing/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../landing/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../landing/css/style.css" rel="stylesheet">
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
                    <a href="index.php"
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
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="index.php" class="nav-item nav-link active">Home</a>
                                <a href="../views/about.php" class="nav-item nav-link">About</a>
                                <a href="../views/service.php" class="nav-item nav-link">Services</a>
                                <a href="../views/tiket.php" class="nav-item nav-link">Tickets</a>
                                <a href="../views/contact.php" class="nav-item nav-link">Contact</a>
                            </div>


                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Header End -->

        <!-- main start -->


        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <h4 class="mb-4"><span class="text-primary text-uppercase">Register</span></h4>
                            <?php if (isset($error)): ?>
                                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
                            <?php endif; ?>
                            <form method="POST" action="register.php">
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <input class="form-control w-100 py-3 ps-4 pe-5 mb-3" type="text" name="username"
                                        id="username" placeholder="Masukkan Username" required>
                                </div>
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <input class="form-control w-100 py-3 ps-4 pe-5 mb-3" type="email" name="email"
                                        id="email" placeholder="Masukkan Email" required>
                                </div>
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <input class="form-control w-100 py-3 ps-4 pe-5 mb-3" type="password"
                                        name="password" id="password" placeholder="Masukkan Password" required>
                                </div>
                                <div class="position-relative mx-auto" style="max-width: 400px;">
                                    <input class="form-control w-100 py-3 ps-4 pe-5 mb-3" type="password"
                                        name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary py-2 px-4 mt-2">Daftar</button>
                            </form>
                            <div class="mt-4">
                                <a href="login.php" class="btn btn-secondary py-2 px-4">Login</a>
                                <a href="../../index.php" class="btn btn-outline-primary py-2 px-4">Kembali</a>
                            </div>
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