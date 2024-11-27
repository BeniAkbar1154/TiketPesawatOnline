<?php

class TiketController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        require_once __DIR__ . '/../model/TiketModel.php';
        $this->pdo = $pdo;
        $this->model = new TiketModel($pdo);
    }

    public function index()
    {
        return $this->model->getAllTiket();
    }

    public function createTiket($data)
    {
        return $this->model->createTiket($data);
    }

    public function getTiketById($id)
    {
        return $this->model->getTiketById($id);
    }

    public function updateTiket($id, $data)
    {
        return $this->model->updateTiket($id, $data);
    }

    public function deleteTiket($id)
    {
        return $this->model->deleteTiket($id);
    }
}
