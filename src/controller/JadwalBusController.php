<?php
require_once '../../database/db_connection.php';
require_once __DIR__ . '../../model/JadwalBusModel.php';

class JadwalBusController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("PDO instance not provided.");
        }

        $this->pdo = $pdo; // Simpan koneksi PDO
        require_once __DIR__ . '/../model/JadwalBusModel.php';
        $this->jadwalBusModel = new JadwalBusModel($pdo); // Berikan $pdo ke model
    }

    // Mendapatkan semua jadwal bus
    public function getAllSchedules()
    {
        return $this->model->getAllSchedules();
    }

    public function index()
    {
        return $this->jadwalBusModel->getAllJadwalBus();
    }

    // Mendapatkan jadwal berdasarkan ID
    public function getScheduleById($id)
    {
        return $this->model->getScheduleById($id);
    }

    // Menambahkan jadwal baru
    public function createSchedule($data)
    {
        $id_bus = $data['id_bus'];
        $rute_keberangkatan = $data['rute_keberangkatan'];
        $rute_transit = !empty($data['rute_transit']) ? $data['rute_transit'] : null; // Transit opsional
        $rute_tujuan = $data['rute_tujuan'];
        $datetime_keberangkatan = $data['datetime_keberangkatan'];
        $datetime_sampai = $data['datetime_sampai'];
        $harga = $data['harga'];

        return $this->model->createSchedule($id_bus, $rute_keberangkatan, $rute_transit, $rute_tujuan, $datetime_keberangkatan, $datetime_sampai, $harga);
    }

    // Mengupdate jadwal
    public function updateSchedule($id, $data)
    {
        $id_bus = $data['id_bus'];
        $rute_keberangkatan = $data['rute_keberangkatan'];
        $rute_transit = !empty($data['rute_transit']) ? $data['rute_transit'] : null; // Transit opsional
        $rute_tujuan = $data['rute_tujuan'];
        $datetime_keberangkatan = $data['datetime_keberangkatan'];
        $datetime_sampai = $data['datetime_sampai'];
        $harga = $data['harga'];

        return $this->model->updateSchedule($id, $id_bus, $rute_keberangkatan, $rute_transit, $rute_tujuan, $datetime_keberangkatan, $datetime_sampai, $harga);
    }

    // Menghapus jadwal
    public function deleteSchedule($id)
    {
        return $this->model->deleteSchedule($id);
    }
}
?>