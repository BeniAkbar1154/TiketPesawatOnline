<?php

class LaporanKhususModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create laporan khusus
    public function create($data)
    {
        $sql = "INSERT INTO laporan_khusus (id_bus, id_user, tanggal, masalah)
            VALUES (:id_bus, :id_user, :tanggal, :masalah)";
        $stmt = $this->pdo->prepare($sql);

        // Cek apakah `id_bus` dan `id_user` kosong, jika ya gunakan nilai NULL
        if (empty($data['id_bus'])) {
            $stmt->bindValue(':id_bus', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':id_bus', $data['id_bus'], PDO::PARAM_INT);
        }

        if (empty($data['id_user'])) {
            $stmt->bindValue(':id_user', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':id_user', $data['id_user'], PDO::PARAM_INT);
        }

        $stmt->bindParam(':tanggal', $data['tanggal'], PDO::PARAM_STR);
        $stmt->bindParam(':masalah', $data['masalah'], PDO::PARAM_STR);

        return $stmt->execute();
    }


    // Get semua laporan khusus dengan left join untuk mendukung null values
    public function getAllLaporanKhusus()
    {
        $stmt = $this->pdo->query("
            SELECT laporan_khusus.*, 
                   bus.nama AS bus_name, 
                   user.username AS user_name 
            FROM laporan_khusus
            LEFT JOIN bus ON laporan_khusus.id_bus = bus.id_bus
            LEFT JOIN user ON laporan_khusus.id_user = user.id_user
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get laporan khusus by ID
    public function getLaporanKhususById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM laporan_khusus 
            WHERE id_laporan_khusus = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update laporan khusus
    public function updateLaporanKhusus($id, $data)
    {
        $stmt = $this->pdo->prepare("
        UPDATE laporan_khusus 
        SET id_bus = :id_bus, id_user = :id_user, tanggal = :tanggal, masalah = :masalah
        WHERE id_laporan_khusus = :id
    ");
        $stmt->bindValue(':id_bus', $data['id_bus'], empty($data['id_bus']) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':id_user', $data['id_user'], empty($data['id_user']) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':tanggal', $data['tanggal'], PDO::PARAM_STR);
        $stmt->bindValue(':masalah', $data['masalah'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }




    // Delete laporan khusus
    public function deleteLaporanKhusus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM laporan_khusus WHERE id_laporan_khusus = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Get semua bus
    public function getAllBuses()
    {
        $stmt = $this->pdo->query("SELECT id_bus, nama FROM bus");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get semua user
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT id_user, username FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
