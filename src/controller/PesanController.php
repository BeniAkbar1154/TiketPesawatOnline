<?php
require_once __DIR__ . '/../model/PesanModel.php';

class PesanController
{
    private $pesanModel;

    public function __construct($pdo)
    {
        $this->pesanModel = new PesanModel($pdo);
    }

    public function index()
    {
        return $this->pesanModel->getAllPesan();
    }

    public function create($id_user, $pesan)
    {
        return $this->pesanModel->createPesan($id_user, $pesan);
    }

    public function edit($id_pesan, $pesan)
    {
        return $this->pesanModel->updatePesan($id_pesan, $pesan);
    }

    public function delete($id_pesan)
    {
        return $this->pesanModel->deletePesan($id_pesan);
    }

    public function show($id_pesan)
    {
        return $this->pesanModel->getPesanById($id_pesan);
    }
}