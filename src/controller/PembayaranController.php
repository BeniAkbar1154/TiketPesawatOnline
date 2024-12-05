<?php

class PembayaranController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        if (!$pdo) {
            die('Koneksi database gagal.');
        }
        require_once __DIR__ . '/../model/PembayaranModel.php';
        $this->pdo = $pdo; // Pastikan $pdo diinisialisasi
        $this->model = new PembayaranModel($pdo);
    }

    public function index()
    {
        return $this->model->getAllPembayaran();
    }

    public function createPembayaran($data)
    {
        // Lakukan insert pembayaran terlebih dahulu
        $this->model->createPembayaran($data);

        // Ambil ID pemesanan dari data yang baru saja dibayar
        $id_pemesanan = $data['id_pemesanan'];

        // Ambil tagihan dan total pembayaran untuk pemesanan ini
        $tagihan = $this->getTagihanById($id_pemesanan);
        $totalPembayaran = $this->getTotalPembayaran($id_pemesanan);

        // Jika total pembayaran sama dengan atau lebih besar dari tagihan, ubah status menjadi 'confirmed' (lunas)
        if ($totalPembayaran >= $tagihan) {
            // Gunakan status 'confirmed' untuk menandakan bahwa pembayaran telah lunas
            $status = 'confirmed';

            // Update status pemesanan menjadi 'confirmed'
            $sql = "UPDATE pemesanan SET status = :status WHERE id_pemesanan = :id_pemesanan";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['status' => $status, 'id_pemesanan' => $id_pemesanan]);
        }

        return true;
    }

    public function cancelPembayaran($id_pemesanan)
    {
        // Update status pemesanan menjadi 'cancelled'
        $sql = "UPDATE pemesanan SET status = 'cancelled' WHERE id_pemesanan = :id_pemesanan";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_pemesanan' => $id_pemesanan]);
    }

    public function getPembayaranById($id)
    {
        return $this->model->getPembayaranById($id);
    }

    public function getTagihanById($id_pemesanan)
    {
        $sql = "SELECT tagihan FROM pemesanan WHERE id_pemesanan = :id_pemesanan";
        $stmt = $this->pdo->prepare($sql); // Menggunakan $this->pdo
        $stmt->execute(['id_pemesanan' => $id_pemesanan]);
        return $stmt->fetchColumn(); // Mengambil nilai tagihan
    }

    public function getTotalPembayaran($id_pemesanan)
    {
        $sql = "SELECT SUM(jumlah_bayar) FROM pembayaran WHERE id_pemesanan = :id_pemesanan";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_pemesanan' => $id_pemesanan]);
        return $stmt->fetchColumn() ?: 0; // Jika tidak ada pembayaran, kembalikan 0
    }

    public function getUserByPemesananId($id_pemesanan)
    {
        $sql = "SELECT id_user FROM pemesanan WHERE id_pemesanan = :id_pemesanan";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_pemesanan' => $id_pemesanan]);
        return $stmt->fetchColumn(); // Mengembalikan id_user
    }

    public function updatePembayaran($id, $data)
    {
        return $this->model->updatePembayaran($id, $data);
    }

    public function deletePembayaran($id)
    {
        return $this->model->deletePembayaran($id);
    }
}
?>