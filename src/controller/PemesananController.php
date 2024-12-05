<?php

require_once __DIR__ . '/../model/PemesananModel.php';

class PemesananController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("PDO instance not provided.");
        }
        $this->pdo = $pdo;
        $this->model = new PemesananModel($pdo);
    }

    public function getJadwalById($id_jadwal_bus)
    {
        $query = "SELECT * FROM jadwal_bus WHERE id_jadwal_bus = :id_jadwal_bus";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_jadwal_bus' => $id_jadwal_bus]);
        $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$jadwal) {
            throw new Exception("Jadwal dengan ID $id_jadwal_bus tidak ditemukan.");
        }

        return $jadwal;
    }

    private function buatKursiUntukBus($id_bus, $id_jadwal_bus)
    {
        // Ambil kapasitas bus
        $busQuery = $this->pdo->prepare("SELECT kapasitas FROM bus WHERE id_bus = :id_bus");
        $busQuery->execute(['id_bus' => $id_bus]);
        $bus = $busQuery->fetch(PDO::FETCH_ASSOC);

        if (!$bus) {
            throw new Exception("Bus dengan ID $id_bus tidak ditemukan.");
        }

        // Generate kursi berdasarkan kapasitas
        $kapasitas = $bus['kapasitas'];
        for ($i = 1; $i <= $kapasitas; $i++) {
            $insertQuery = $this->pdo->prepare(
                "INSERT INTO nomor_kursi (id_bus, id_jadwal_bus, nomor_kursi, status) 
                 VALUES (:id_bus, :id_jadwal_bus, :nomor_kursi, 'available')"
            );
            $insertQuery->execute(['id_bus' => $id_bus, 'id_jadwal_bus' => $id_jadwal_bus, 'nomor_kursi' => (string) $i]);
        }
    }

    public function getKursiTersedia($id_bus, $id_jadwal_bus)
    {
        // Periksa apakah kursi sudah dibuat
        $query = $this->pdo->prepare("SELECT * FROM nomor_kursi WHERE id_bus = :id_bus");
        $query->execute(['id_bus' => $id_bus]);
        $kursi = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($kursi)) {
            $this->buatKursiUntukBus($id_bus, $id_jadwal_bus);

            // Refresh data kursi setelah dibuat
            $query->execute(['id_bus' => $id_bus]);
            $kursi = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        // Filter kursi yang tersedia
        $availableQuery = $this->pdo->prepare(
            "SELECT * FROM nomor_kursi 
             WHERE id_bus = :id_bus AND status = 'available' AND nomor_kursi NOT IN (
                SELECT nomor_kursi FROM pemesanan WHERE id_jadwal_bus = :id_jadwal_bus
             )"
        );
        $availableQuery->execute(['id_bus' => $id_bus, 'id_jadwal_bus' => $id_jadwal_bus]);
        return $availableQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buatPemesanan($data)
    {
        // Validasi data input
        $requiredFields = ['id_user', 'id_bus', 'id_jadwal_bus', 'tanggal_pemesanan', 'nomor_kursi', 'status', 'tagihan', 'tenggat_waktu'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new Exception("Data $field tidak boleh kosong.");
            }
        }

        // Debug isi $data untuk memeriksa kesesuaian
        error_log(print_r($data, true)); // Tambahkan ini untuk melihat isi array $data

        // Mulai transaksi
        $this->pdo->beginTransaction();
        try {
            // Mengecek ketersediaan kursi
            $kursiTersedia = $this->getKursiTersedia($data['id_bus'], $data['id_jadwal_bus']);
            if (empty($kursiTersedia)) {
                throw new Exception("Tidak ada kursi yang tersedia untuk jadwal bus ini.");
            }

            // Validasi kursi yang dipilih
            $kursiTersedia = array_column($kursiTersedia, 'nomor_kursi');
            if (!in_array($data['nomor_kursi'], $kursiTersedia)) {
                throw new Exception("Kursi yang dipilih tidak tersedia.");
            }

            // Query untuk membuat pemesanan
            $query = "INSERT INTO pemesanan 
                  (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tagihan, tenggat_waktu) 
                  VALUES (:id_user, :id_jadwal_bus, :tanggal_pemesanan, :nomor_kursi, :status, :tagihan, :tenggat_waktu)";
            $stmt = $this->pdo->prepare($query);

            // Perbaikan di sini: pastikan hanya parameter yang sesuai dikirim
            $params = [
                'id_user' => $data['id_user'],
                'id_jadwal_bus' => $data['id_jadwal_bus'],
                'tanggal_pemesanan' => $data['tanggal_pemesanan'],
                'nomor_kursi' => $data['nomor_kursi'],
                'status' => $data['status'],
                'tagihan' => $data['tagihan'],
                'tenggat_waktu' => $data['tenggat_waktu']
            ];

            // Eksekusi query
            if (!$stmt->execute($params)) {
                throw new Exception("Gagal membuat pemesanan.");
            }

            // Commit transaksi
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaksi jika ada error
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function tambahPemesanan($id_user, $id_jadwal_bus, $nomor_kursi, $tagihan, $status = 'pending')
    {
        global $pdo;

        // Mulai Transaksi
        $pdo->beginTransaction();

        try {
            // Tambahkan data pemesanan
            $stmt = $pdo->prepare("
            INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, status, tagihan, tenggat_waktu)
            VALUES (:id_user, :id_jadwal_bus, NOW(), :nomor_kursi, :status, :tagihan, DATE_ADD(NOW(), INTERVAL 1 DAY))
        ");
            $stmt->execute([
                'id_user' => $id_user,
                'id_jadwal_bus' => $id_jadwal_bus,
                'nomor_kursi' => $nomor_kursi,
                'status' => $status,
                'tagihan' => $tagihan,
            ]);

            // Ambil ID pemesanan yang baru dibuat
            $id_pemesanan = $pdo->lastInsertId();

            // Tambahkan notifikasi untuk user
            $stmtNotif = $pdo->prepare("
            INSERT INTO pesan (id_user, pesan, status, tanggal)
            VALUES (:id_user, :pesan, 'unread', NOW())
        ");
            $stmtNotif->execute([
                'id_user' => $id_user,
                'pesan' => "Pemesanan tiket berhasil dengan ID #$id_pemesanan. Silakan selesaikan pembayaran.",
            ]);

            // Commit Transaksi
            $pdo->commit();

            return $id_pemesanan; // Kembalikan ID pemesanan jika berhasil
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e; // Kembalikan error jika terjadi
        }
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM pemesanan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ubahPemesanan($id, $data)
    {
        $this->model->updatePemesanan($id, $data);
    }

    public function hapusPemesanan($id)
    {
        $this->model->deletePemesanan($id);
    }

    public function semuaPemesanan()
    {
        return $this->model->getAllPemesanan();
    }

    public function pemesananById($id)
    {
        return $this->model->getPemesananById($id);
    }
}
