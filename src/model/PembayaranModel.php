<?php

class PembayaranModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllPembayaran()
    {
        $stmt = $this->pdo->query("
            SELECT p.*, ps.tanggal_pemesanan, ps.tagihan, u.username
            FROM pembayaran p
            JOIN pemesanan ps ON p.id_pemesanan = ps.id_pemesanan
            JOIN user u ON p.id_user = u.id_user
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPembayaran($data)
    {
        // Mulai transaksi untuk memastikan integritas data
        $this->pdo->beginTransaction();

        try {
            // 1. Menyimpan pembayaran ke tabel pembayaran
            $stmt = $this->pdo->prepare("
            INSERT INTO pembayaran (id_pemesanan, id_user, jumlah_bayar, metode_pembayaran, tanggal_pembayaran, tagihan)
            VALUES (:id_pemesanan, :id_user, :jumlah_bayar, :metode_pembayaran, :tanggal_pembayaran, :tagihan)
        ");
            $stmt->execute([
                'id_pemesanan' => $data['id_pemesanan'],
                'id_user' => $data['id_user'],
                'jumlah_bayar' => $data['jumlah_bayar'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'tanggal_pembayaran' => $data['tanggal_pembayaran'],
                'tagihan' => $data['tagihan'], // Pastikan 'tagihan' dikirimkan
            ]);

            // 2. Mengurangi tagihan pada tabel pemesanan
            $stmt = $this->pdo->prepare("
            UPDATE pemesanan
            SET tagihan = tagihan - :jumlah_bayar
            WHERE id_pemesanan = :id_pemesanan
        ");
            $stmt->execute([
                'jumlah_bayar' => $data['jumlah_bayar'],
                'id_pemesanan' => $data['id_pemesanan']
            ]);

            // Jika semua berhasil, commit transaksi
            $this->pdo->commit();
        } catch (Exception $e) {
            // Jika ada error, rollback transaksi
            $this->pdo->rollBack();
            throw $e; // Re-throw exception setelah rollback
        }
    }


    public function getPembayaranById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pembayaran WHERE id_pembayaran = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePembayaran($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE pembayaran SET id_pemesanan = :id_pemesanan, id_user = :id_user, tagihan = :tagihan,
                                  metode_pembayaran = :metode_pembayaran, tanggal_pembayaran = :tanggal_pembayaran
            WHERE id_pembayaran = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function deletePembayaran($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pembayaran WHERE id_pembayaran = ?");
        return $stmt->execute([$id]);
    }
}
?>