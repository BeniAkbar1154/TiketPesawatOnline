<?php
require_once __DIR__ . '/../model/RuteModel.php';

class RuteController {
    private $ruteModel;

    public function __construct($pdo) {
        $this->ruteModel = new Rute($pdo);
    }

    public function createRute($transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat) {
        return $this->ruteModel->createRute($transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat);
    }

    public function getRute() {
        return $this->ruteModel->getRute();
    }

    public function updateRute($id, $transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat) {
        return $this->ruteModel->updateRute($id, $transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat);
    }

    public function deleteRute($id) {
        return $this->ruteModel->deleteRute($id);
    }
}
?>
