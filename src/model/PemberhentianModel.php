<?php

class PemberhentianModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllPemberhentian()
    {
        $stmt = $this->pdo->query("SELECT * FROM pemberhentian");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPemberhentianById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pemberhentian WHERE id_pemberhentian = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPemberhentian($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO pemberhentian (nama_pemberhentian, lokasi_pemberhentian) VALUES (:nama, :lokasi)");
        $stmt->execute([
            'nama' => $data['nama_pemberhentian'],
            'lokasi' => $data['lokasi_pemberhentian']
        ]);
    }

    public function updatePemberhentian($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE pemberhentian SET nama_pemberhentian = :nama, lokasi_pemberhentian = :lokasi WHERE id_pemberhentian = :id");
        $stmt->execute([
            'nama' => $data['nama_pemberhentian'],
            'lokasi' => $data['lokasi_pemberhentian'],
            'id' => $id
        ]);
    }

    public function deletePemberhentian($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pemberhentian WHERE id_pemberhentian = :id");
        $stmt->execute(['id' => $id]);
    }
}
