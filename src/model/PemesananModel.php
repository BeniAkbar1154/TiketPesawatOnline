<?php
class Pemesanan {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createPemesanan($id_user, $nomor_kursi, $id_rute, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO pemesanan (id_user, nomor_kursi, id_rute, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_user, $nomor_kursi, $id_rute, $status]);
    }

    public function getPemesanan() {
        $stmt = $this->pdo->query("SELECT * FROM pemesanan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePemesanan($id, $id_user, $nomor_kursi, $id_rute, $status) {
        $stmt = $this->pdo->prepare("UPDATE pemesanan SET id_user = ?, nomor_kursi = ?, id_rute = ?, status = ? WHERE id = ?");
        return $stmt->execute([$id_user, $nomor_kursi, $id_rute, $status, $id]);
    }

    public function deletePemesanan($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pemesanan WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
