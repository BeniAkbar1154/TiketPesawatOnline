<?php
require_once __DIR__ . '/../model/DestinasiModel.php';

class DestinasiController {
    private $destinasiModel;

    public function __construct($pdo) {
        $this->destinasiModel = new Destinasi($pdo);
    }

    public function createDestinasi($destinasi, $iso) {
        return $this->destinasiModel->createDestinasi($destinasi, $iso);
    }

    public function getDestinasi() {
        return $this->destinasiModel->getDestinasi();
    }

    public function updateDestinasi($id, $destinasi, $iso) {
        return $this->destinasiModel->updateDestinasi($id, $destinasi, $iso);
    }

    public function deleteDestinasi($id) {
        return $this->destinasiModel->deleteDestinasi($id);
    }
}
?>
