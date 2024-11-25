<?php

require_once __DIR__ . '/../model/LaporanKhususModel.php';

class LaporanKhususController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new LaporanKhususModel($pdo);
    }

    public function createLaporanKhusus($data)
    {
        // Panggil metode `create` di model
        return $this->model->create($data);
    }

    public function getAllLaporanKhusus()
    {
        return $this->model->getAllLaporanKhusus();
    }

    public function getLaporanKhususById($id)
    {
        return $this->model->getLaporanKhususById($id);
    }

    public function updateLaporanKhusus($id, $data)
    {
        return $this->model->updateLaporanKhusus($id, $data);
    }

    public function deleteLaporanKhusus($id)
    {
        return $this->model->deleteLaporanKhusus($id);
    }

    public function getAllBuses()
    {
        return $this->model->getAllBuses();
    }

    public function getAllUsers()
    {
        return $this->model->getAllUsers();
    }
}
