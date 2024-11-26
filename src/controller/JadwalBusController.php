<?php
require_once '../../database/db_connection.php';
require_once __DIR__ . '../../model/JadwalBusModel.php';

class JadwalBusController
{
    private $model;

    public function __construct()
    {
        global $pdo; // Menggunakan $pdo dari db_connection.php
        $this->model = new JadwalBusModel($pdo);
    }

    // Mendapatkan semua jadwal bus
    public function getAllSchedules()
    {
        return $this->model->getAllSchedules();
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