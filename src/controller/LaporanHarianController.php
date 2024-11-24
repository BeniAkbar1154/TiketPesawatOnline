<?php
require_once '../../database/db_connection.php';
require_once __DIR__ . '../../model/LaporanHarianModel.php';
require_once __DIR__ . '../../model/BusModel.php';

class LaporanHarianController
{

    private $laporanHarianModel;

    public function __construct($pdo)
    {
        // Mendapatkan instance PDO yang sudah didefinisikan di db_connection.php
        $this->laporanHarianModel = new LaporanHarianModel($pdo);
        $this->busModel = new BusModel($pdo);
    }

    // Fungsi untuk mengambil data laporan harian
    public function getAllLaporanHarian()
    {
        return $this->laporanHarianModel->getAll();
    }

    public function getAllBuses()
    {
        return $this->busModel->getAll();
    }

    // Fungsi untuk mengambil laporan harian berdasarkan ID
    public function getLaporanHarianById($id)
    {
        return $this->laporanHarianModel->getById($id);
    }


    public function getBuses()
    {
        return $this->laporanHarianModel->getAllBuses();
    }


    public function createLaporanHarian($data)
    {
        // Memeriksa dan mengganti nilai kosong dengan "Tidak ada masalah"
        $fields = [
            'kondisi_teknis',
            'kondisi_kebersihan',
            'bahan_bakar',
            'kondisi_jalan',
            'ketepatan_jadwal',
            'keselamatan'
        ];

        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $data[$field] = 'Tidak ada masalah';
            }
        }

        return $this->laporanHarianModel->create($data);
    }


    // Fungsi untuk mengedit laporan harian
    public function editLaporanHarian($id, $data)
    {
        return $this->laporanHarianModel->edit($id, $data);
    }

    // Fungsi untuk menghapus laporan harian
    public function deleteLaporanHarian($id)
    {
        return $this->laporanHarianModel->delete($id);
    }
}
?>