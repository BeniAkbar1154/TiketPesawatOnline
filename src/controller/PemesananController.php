<?php
require_once __DIR__ . '/../model/PemesananModel.php';

class PemesananController {
    private $pemesananModel;

    public function __construct($pdo) {
        $this->pemesananModel = new Pemesanan($pdo);
    }

    public function createPemesanan($id_user, $nomor_kursi, $id_rute, $status) {
        return $this->pemesananModel->createPemesanan($id_user, $nomor_kursi, $id_rute, $status);
    }

    public function getPemesanan() {
        return $this->pemesananModel->getPemesanan();
    }

    public function updatePemesanan($id, $id_user, $nomor_kursi, $id_rute, $status) {
        return $this->pemesananModel->updatePemesanan($id, $id_user, $nomor_kursi, $id_rute, $status);
    }

    public function deletePemesanan($id) {
        return $this->pemesananModel->deletePemesanan($id);
    }
}
?>
