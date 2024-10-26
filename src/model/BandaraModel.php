<?php
class Bandara {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createBandara($id_destinasi, $nama, $iso_9001) {
        $stmt = $this->pdo->prepare("INSERT INTO bandara (id_destinasi, nama, iso_9001) VALUES (?, ?, ?)");
        return $stmt->execute([$id_destinasi, $nama, $iso_9001]);
    }

    public function getBandara() {
        $stmt = $this->pdo->query("SELECT * FROM bandara");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateBandara($id, $id_destinasi, $nama, $iso_9001) {
        $stmt = $this->pdo->prepare("UPDATE bandara SET id_destinasi = ?, nama = ?, iso_9001 = ? WHERE id = ?");
        return $stmt->execute([$id_destinasi, $nama, $iso_9001, $id]);
    }

    public function deleteBandara($id) {
        $stmt = $this->pdo->prepare("DELETE FROM bandara WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
