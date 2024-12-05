<?php
class PesanModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Ambil semua pesan
    public function getAllPesan()
    {
        $query = $this->pdo->query("SELECT pesan.*, user.username 
                                    FROM pesan 
                                    JOIN user ON pesan.id_user = user.id_user 
                                    ORDER BY tanggal_kirim DESC");
        return $query->fetchAll();
    }

    // Ambil pesan berdasarkan ID
    public function getPesanById($id_pesan)
    {
        $query = $this->pdo->prepare("SELECT * FROM pesan WHERE id_pesan = ?");
        $query->execute([$id_pesan]);
        return $query->fetch();
    }

    // Tambahkan pesan baru
    public function createPesan($id_user, $pesan)
    {
        $query = $this->pdo->prepare("INSERT INTO pesan (id_user, pesan, status) VALUES (?, ?, 'baru')");
        return $query->execute([$id_user, $pesan]);
    }

    // Edit pesan
    public function updatePesan($id_pesan, $pesan)
    {
        $query = $this->pdo->prepare("UPDATE pesan SET pesan = ? WHERE id_pesan = ?");
        return $query->execute([$pesan, $id_pesan]);
    }

    // Hapus pesan
    public function deletePesan($id_pesan)
    {
        $query = $this->pdo->prepare("DELETE FROM pesan WHERE id_pesan = ?");
        return $query->execute([$id_pesan]);
    }
}
