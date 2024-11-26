<?php

require_once __DIR__ . '/../model/PembayaranModel.php';

class PembayaranController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PembayaranModel($pdo);
    }

    public function buatPembayaran($data)
    {
        $this->model->createPembayaran($data);
    }

    public function totalPembayaran($id_pemesanan)
    {
        return $this->model->getTotalPembayaran($id_pemesanan);
    }
}
