<?php
class Destinasi {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createDestinasi($destinasi, $iso) {
        $stmt = $this->pdo->prepare("INSERT INTO destinasi (destinasi, iso) VALUES (?, ?)");
        return $stmt->execute([$destinasi, $iso]);
    }

    public function getDestinasi() {
        $stmt = $this->pdo->query("SELECT * FROM destinasi");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDestinasi($id, $destinasi, $iso) {
        $stmt = $this->pdo->prepare("UPDATE destinasi SET destinasi = ?, iso = ? WHERE id = ?");
        return $stmt->execute([$destinasi, $iso, $id]);
    }

    public function deleteDestinasi($id) {
        $stmt = $this->pdo->prepare("DELETE FROM destinasi WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
