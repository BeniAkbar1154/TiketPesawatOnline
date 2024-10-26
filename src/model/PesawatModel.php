<?php
class Pesawat {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createPesawat($gambar, $nama, $tipe, $deskripsi, $kapasitas) {
        $stmt = $this->pdo->prepare("INSERT INTO pesawat (gambar, nama, tipe, deskripsi, kapasitas) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$gambar, $nama, $tipe, $deskripsi, $kapasitas]);
    }

    public function getPesawat() {
        $stmt = $this->pdo->query("SELECT * FROM pesawat");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePesawat($id, $gambar, $nama, $tipe, $deskripsi, $kapasitas) {
        $stmt = $this->pdo->prepare("UPDATE pesawat SET gambar = ?, nama = ?, tipe = ?, deskripsi = ?, kapasitas = ? WHERE id = ?");
        return $stmt->execute([$gambar, $nama, $tipe, $deskripsi, $kapasitas, $id]);
    }

    public function deletePesawat($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pesawat WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
