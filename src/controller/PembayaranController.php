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
        return $this->model->createPembayaran($data);
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