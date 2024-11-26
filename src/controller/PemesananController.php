<?php

require_once __DIR__ . '/../model/PemesananModel.php';

class PemesananController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PemesananModel($pdo);
    }

    public function buatPemesanan($data)
    {
        $this->model->createPemesanan($data);
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
