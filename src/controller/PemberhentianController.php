<?php

require_once __DIR__ . '/../model/PemberhentianModel.php';

class PemberhentianController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new PemberhentianModel($pdo);
    }

    public function getAllPemberhentian()
    {
        return $this->model->getAllPemberhentian();
    }

    public function getPemberhentianById($id)
    {
        return $this->model->getPemberhentianById($id);
    }

    public function createPemberhentian($data)
    {
        return $this->model->createPemberhentian($data);
    }

    public function updatePemberhentian($id, $data)
    {
        return $this->model->updatePemberhentian($id, $data);
    }

    public function deletePemberhentian($id)
    {
        return $this->model->deletePemberhentian($id);
    }
}
