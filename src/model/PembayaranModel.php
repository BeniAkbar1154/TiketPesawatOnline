<?php

class PembayaranModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createPembayaran($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pembayaran (id_pemesanan, jumlah_bayar, tanggal_bayar)
            VALUES (:id_pemesanan, :jumlah_bayar, :tanggal_bayar)
        ");
        $stmt->execute($data);

        $this->updateStatusPemesanan($data['id_pemesanan']);
    }

    public function getTotalPembayaran($id_pemesanan)
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(jumlah_bayar) AS total_bayar
            FROM pembayaran
            WHERE id_pemesanan = :id_pemesanan
        ");
        $stmt->execute(['id_pemesanan' => $id_pemesanan]);
        return $stmt->fetchColumn();
    }

    private function updateStatusPemesanan($id_pemesanan)
    {
        $stmt = $this->pdo->prepare("
            SELECT tagihan, status, tenggat_waktu
            FROM pemesanan
            WHERE id_pemesanan = :id_pemesanan
        ");
        $stmt->execute(['id_pemesanan' => $id_pemesanan]);
        $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_bayar = $this->getTotalPembayaran($id_pemesanan);

        $newStatus = $pemesanan['status'];
        if ($total_bayar >= $pemesanan['tagihan']) {
            $newStatus = 'lunas';
        } elseif (strtotime($pemesanan['tenggat_waktu']) < time() && $total_bayar < $pemesanan['tagihan']) {
            $newStatus = 'kadaluarsa';
        }

        $stmt = $this->pdo->prepare("
            UPDATE pemesanan 
            SET status = :status
            WHERE id_pemesanan = :id_pemesanan
        ");
        $stmt->execute(['status' => $newStatus, 'id_pemesanan' => $id_pemesanan]);
    }
}
