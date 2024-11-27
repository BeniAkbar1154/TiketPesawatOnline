<?php

require_once __DIR__ . '/../model/PemesananModel.php';

class PemesananController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        $this->model = new PemesananModel($pdo);
        if (!$pdo) {
            throw new Exception("PDO instance not provided.");
        }
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM pemesanan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
