<?php
require_once __DIR__ . '/database/db_connection.php';
require_once __DIR__ . '/src/controller/PesanController.php'; // Perbaiki jalur file
require_once __DIR__ . '/src/controller/JadwalBusController.php'; // Perbaiki jalur file

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

// Pengambilan jadwal bus
$jadwalBusController = new JadwalBusController($pdo);
$jadwalBuses = $jadwalBusController->getAllSchedules();

// Cek apakah ada jadwal bus yang ditemukan
if (!$jadwalBuses) {
    echo "<p>Tidak ada jadwal bus yang tersedia.</p>";
}


$stmt = $pdo->prepare("SELECT jb.*, b.nama AS nama_bus, b.gambar AS gambar_bus,
                            t1.nama_terminal AS rute_keberangkatan, t2.nama_terminal AS rute_tujuan
                       FROM jadwal_bus jb
                       JOIN bus b ON jb.id_bus = b.id_bus
                       LEFT JOIN terminal t1 ON jb.rute_keberangkatan = t1.id_terminal
                       LEFT JOIN terminal t2 ON jb.rute_tujuan = t2.id_terminal
                       WHERE jb.id_jadwal_bus = :id_jadwal_bus");
$stmt->execute(['id_jadwal_bus' => $id_jadwal_bus]);
$tiket = $stmt->fetch(PDO::FETCH_ASSOC);

// Cek jika tiket ditemukan
if ($tiket) {
    $gambarBus = !empty($tiket['gambar_bus']) ? 'public/landing/img/bus/' . $tiket['gambar_bus'] : 'public/landing/img/bus/default.jpg';
    $hargaTiket = !empty($tiket['harga']) ? number_format($tiket['harga'], 0, ',', '.') : 'N/A';
    $namaRute = $tiket['rute_keberangkatan'] . ' - ' . $tiket['rute_tujuan'];  // Menggunakan nama terminal
    $waktuKeberangkatan = !empty($tiket['waktu_keberangkatan']) ? date('d M Y H:i', strtotime($tiket['waktu_keberangkatan'])) : 'Belum ditentukan';
    $waktuSampai = !empty($tiket['waktu_kedatangan']) ? date('d M Y H:i', strtotime($tiket['waktu_kedatangan'])) : 'Belum ditentukan';
} else {
    // Jika tiket tidak ditemukan
    $tiket = null;
}

?>

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