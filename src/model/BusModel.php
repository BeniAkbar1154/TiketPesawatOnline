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
        $stmt = $this->pdo->query("SELECT * FROM bus");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bus WHERE id_bus = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBus($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO bus (nama, tipe, deskripsi, kapasitas, gambar)
            VALUES (:nama, :tipe, :deskripsi, :kapasitas, :gambar)
        ");
        $stmt->execute([
            'nama' => $data['nama'],
            'tipe' => $data['tipe'],
            'deskripsi' => $data['deskripsi'],
            'kapasitas' => $data['kapasitas'],
            'gambar' => $data['gambar']
        ]);
    }

    public function updateBus($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE bus SET 
                nama = :nama, 
                tipe = :tipe, 
                deskripsi = :deskripsi, 
                kapasitas = :kapasitas, 
                gambar = :gambar 
            WHERE id_bus = :id
        ");
        $stmt->execute([
            'id' => $id,
            'nama' => $data['nama'],
            'tipe' => $data['tipe'],
            'deskripsi' => $data['deskripsi'],
            'kapasitas' => $data['kapasitas'],
            'gambar' => $data['gambar']
        ]);
    }

    public function deleteBus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bus WHERE id_bus = :id");
        $stmt->execute(['id' => $id]);
    }
}
