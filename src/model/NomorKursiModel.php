<?php
class NomorKursiModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getKursiByBus($id_bus)
    {
        $query = "SELECT 
                nomor_kursi.nomor_kursi,
                nomor_kursi.status,
                user.username AS nama_user
              FROM nomor_kursi
              LEFT JOIN pemesanan ON nomor_kursi.nomor_kursi = pemesanan.nomor_kursi
              LEFT JOIN user ON pemesanan.id_user = user.id_user
              WHERE nomor_kursi.id_bus = :id_bus";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_bus' => $id_bus]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
