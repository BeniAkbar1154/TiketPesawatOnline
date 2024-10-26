<?php
require_once __DIR__ . '/../model/PesawatModel.php';

class PesawatController {
    private $pesawatModel;

    public function __construct($pdo) {
        $this->pesawatModel = new Pesawat($pdo);
    }

    public function createPesawat($gambar, $nama, $tipe, $deskripsi, $kapasitas) {
        return $this->pesawatModel->createPesawat($gambar, $nama, $tipe, $deskripsi, $kapasitas);
    }

    public function getPesawat() {
        return $this->pesawatModel->getPesawat();
    }

    public function updatePesawat($id, $gambar, $nama, $tipe, $deskripsi, $kapasitas) {
        return $this->pesawatModel->updatePesawat($id, $gambar, $nama, $tipe, $deskripsi, $kapasitas);
    }

    public function deletePesawat($id) {
        return $this->pesawatModel->deletePesawat($id);
    }
}
?>
