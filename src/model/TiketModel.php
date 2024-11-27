<?php

class TiketModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllTiket()
    {
        $stmt = $this->pdo->query("
            SELECT t.*, p.tanggal_pemesanan, ps.nama_terminal AS terminal_asal, pd.nama_terminal AS terminal_tujuan
            FROM tiket t
            JOIN pemesanan p ON t.id_pemesanan = p.id_pemesanan
            JOIN jadwal_bus jb ON t.id_jadwal_bus = jb.id_jadwal_bus
            JOIN terminal ps ON jb.rute_keberangkatan = ps.id_terminal
            JOIN terminal pd ON jb.rute_tujuan = pd.id_terminal
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTiket($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO tiket (id_pemesanan, id_user, id_jadwal_bus, nomor_kursi)
            VALUES (:id_pemesanan, :id_user, :id_jadwal_bus, :nomor_kursi)
        ");
        return $stmt->execute([
            'id_pemesanan' => $data['id_pemesanan'],
            'id_user' => $data['id_user'],
            'id_jadwal_bus' => $data['id_jadwal_bus'],
            'nomor_kursi' => $data['nomor_kursi']
        ]);
    }

    public function getTiketById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tiket WHERE id_tiket = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTiket($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE tiket 
            SET id_pemesanan = :id_pemesanan, id_user = :id_user, id_jadwal_bus = :id_jadwal_bus, nomor_kursi = :nomor_kursi
            WHERE id_tiket = :id_tiket
        ");
        $data['id_tiket'] = $id;
        return $stmt->execute($data);
    }

    public function deleteTiket($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tiket WHERE id_tiket = ?");
        return $stmt->execute([$id]);
    }
}
