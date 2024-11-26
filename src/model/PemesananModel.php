<?php

class PemesananModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createPemesanan($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pemesanan (id_user, id_jadwal_bus, tanggal_pemesanan, nomor_kursi, tagihan, status, tenggat_waktu)
            VALUES (:id_user, :id_jadwal_bus, :tanggal_pemesanan, :nomor_kursi, :tagihan, 'pending', :tenggat_waktu)
        ");
        $stmt->execute($data);
    }

    public function updatePemesanan($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE pemesanan
            SET id_user = :id_user, id_jadwal_bus = :id_jadwal_bus, tanggal_pemesanan = :tanggal_pemesanan,
                nomor_kursi = :nomor_kursi, tagihan = :tagihan, status = :status, tenggat_waktu = :tenggat_waktu
            WHERE id_pemesanan = :id
        ");
        $stmt->execute(array_merge(['id' => $id], $data));
    }

    public function deletePemesanan($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pemesanan WHERE id_pemesanan = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getAllPemesanan()
    {
        $stmt = $this->pdo->query("SELECT * FROM pemesanan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPemesananById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pemesanan WHERE id_pemesanan = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
