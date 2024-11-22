<?php

class BusModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllBuses()
    {
        $sql = "SELECT * FROM bus";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getBusById($id)
    {
        $sql = "SELECT * FROM bus WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createBus($data)
    {
        $sql = "INSERT INTO bus (gambar, nama, tipe, deskripsi, kapasitas) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['gambar'],
            $data['nama'],
            $data['tipe'],
            $data['deskripsi'],
            $data['kapasitas']
        ]);
    }

    public function updateBus($id, $data)
    {
        $sql = "UPDATE bus SET gambar = ?, nama = ?, tipe = ?, deskripsi = ?, kapasitas = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['gambar'],
            $data['nama'],
            $data['tipe'],
            $data['deskripsi'],
            $data['kapasitas'],
            $id
        ]);
    }

    public function deleteBus($id)
    {
        $sql = "DELETE FROM bus WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>