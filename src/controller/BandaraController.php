<?php
require_once __DIR__ . '/../model/BandaraModel.php';

class BandaraController {
    private $bandaraModel;

    public function __construct($pdo) {
        $this->bandaraModel = new Bandara($pdo);
    }

    public function createBandara($id_destinasi, $nama, $iso_9001) {
        return $this->bandaraModel->createBandara($id_destinasi, $nama, $iso_9001);
    }

    public function getBandara() {
        return $this->bandaraModel->getBandara();
    }

    public function updateBandara($id, $id_destinasi, $nama, $iso_9001) {
        return $this->bandaraModel->updateBandara($id, $id_destinasi, $nama, $iso_9001);
    }

    public function deleteBandara($id) {
        return $this->bandaraModel->deleteBandara($id);
    }
}
?>
