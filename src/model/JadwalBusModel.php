<?php
require_once '../../database/db_connection.php';

class JadwalBusModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSchedules()
    {
        $sql = "
            SELECT 
                jb.id_jadwal_bus,
                jb.id_bus,
                jb.rute_keberangkatan,
                jb.rute_transit,
                jb.rute_tujuan,
                jb.jam_keberangkatan,
                jb.jam_sampai,
                jb.harga,
                t1.nama_terminal AS keberangkatan,
                t2.nama_terminal AS tujuan,
                p.nama_pemberhentian AS transit,
                b.nama AS bus_name
            FROM jadwal_bus jb
            LEFT JOIN terminal t1 ON jb.rute_keberangkatan = t1.id_terminal
            LEFT JOIN terminal t2 ON jb.rute_tujuan = t2.id_terminal
            LEFT JOIN pemberhentian p ON jb.rute_transit = p.id_pemberhentian
            LEFT JOIN bus b ON jb.id_bus = b.id_bus;
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getScheduleById($id)
    {
        $sql = "
            SELECT 
                jb.id_jadwal_bus,
                jb.id_bus,
                jb.rute_keberangkatan,
                jb.rute_transit,
                jb.rute_tujuan,
                jb.jam_keberangkatan,
                jb.jam_sampai,
                jb.harga,
                t1.nama_terminal AS keberangkatan,
                t2.nama_terminal AS tujuan,
                p.nama_pemberhentian AS transit,
                b.nama AS bus_name
            FROM jadwal_bus jb
            LEFT JOIN terminal t1 ON jb.rute_keberangkatan = t1.id_terminal
            LEFT JOIN terminal t2 ON jb.rute_tujuan = t2.id_terminal
            LEFT JOIN pemberhentian p ON jb.rute_transit = p.id_pemberhentian
            LEFT JOIN bus b ON jb.id_bus = b.id_bus
            WHERE jb.id_jadwal_bus = :id;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSchedule($id_bus, $rute_keberangkatan, $rute_transit, $rute_tujuan, $jam_keberangkatan, $jam_sampai, $harga)
    {
        $sql = "
            INSERT INTO jadwal_bus (id_bus, rute_keberangkatan, rute_transit, rute_tujuan, jam_keberangkatan, jam_sampai, harga)
            VALUES (:id_bus, :rute_keberangkatan, :rute_transit, :rute_tujuan, :jam_keberangkatan, :jam_sampai, :harga);
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_bus', $id_bus);
        $stmt->bindParam(':rute_keberangkatan', $rute_keberangkatan);
        $stmt->bindParam(':rute_transit', $rute_transit);
        $stmt->bindParam(':rute_tujuan', $rute_tujuan);
        $stmt->bindParam(':jam_keberangkatan', $jam_keberangkatan);
        $stmt->bindParam(':jam_sampai', $jam_sampai);
        $stmt->bindParam(':harga', $harga);

        return $stmt->execute();
    }

    public function updateSchedule($id, $id_bus, $rute_keberangkatan, $rute_transit, $rute_tujuan, $jam_keberangkatan, $jam_sampai, $harga)
    {
        $sql = "
            UPDATE jadwal_bus
            SET id_bus = :id_bus, rute_keberangkatan = :rute_keberangkatan, rute_transit = :rute_transit, rute_tujuan = :rute_tujuan, 
                jam_keberangkatan = :jam_keberangkatan, jam_sampai = :jam_sampai, harga = :harga
            WHERE id_jadwal_bus = :id;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_bus', $id_bus);
        $stmt->bindParam(':rute_keberangkatan', $rute_keberangkatan);
        $stmt->bindParam(':rute_transit', $rute_transit);
        $stmt->bindParam(':rute_tujuan', $rute_tujuan);
        $stmt->bindParam(':jam_keberangkatan', $jam_keberangkatan);
        $stmt->bindParam(':jam_sampai', $jam_sampai);
        $stmt->bindParam(':harga', $harga);

        return $stmt->execute();
    }

    public function deleteSchedule($id)
    {
        $sql = "DELETE FROM jadwal_bus WHERE id_jadwal_bus = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>