<?php
class Rute {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createRute($transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat) {
        $stmt = $this->pdo->prepare("INSERT INTO rute (transit, rute_awal, rute_akhir, kedatangan, harga, id_pesawat) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat]);
    }

    public function getRute() {
        $stmt = $this->pdo->query("SELECT * FROM rute");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRute($id, $transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat) {
        $stmt = $this->pdo->prepare("UPDATE rute SET transit = ?, rute_awal = ?, rute_akhir = ?, kedatangan = ?, harga = ?, id_pesawat = ? WHERE id = ?");
        return $stmt->execute([$transit, $rute_awal, $rute_akhir, $kedatangan, $harga, $id_pesawat, $id]);
    }

    public function deleteRute($id) {
        $stmt = $this->pdo->prepare("DELETE FROM rute WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
