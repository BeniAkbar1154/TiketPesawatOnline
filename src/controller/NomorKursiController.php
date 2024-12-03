<?php
require_once '../../src/model/NomorKursiModel.php';

class NomorKursiController
{
    private $nomorKursiModel;

    public function __construct($pdo)
    {
        $this->nomorKursiModel = new NomorKursiModel($pdo);
    }

    public function index($id_bus)
    {
        return $this->nomorKursiModel->getKursiByBus($id_bus);
    }
}
