<?php

class LaporanHarianModel
{
    private $pdo;

    public function __construct($pdo)
    {
        // Menyimpan objek PDO yang diterima dari controller
        $this->pdo = $pdo;
    }

    // Mendapatkan semua laporan harian
    public function getAll()
    {
        $sql = "SELECT l.id_laporan_harian, b.nama AS bus_name, l.tanggal, l.waktu, 
                       l.kondisi_teknis, l.kondisi_kebersihan, l.bahan_bakar, 
                       l.kondisi_jalan, l.ketepatan_jadwal, l.keselamatan
                FROM laporan_harian l
                JOIN bus b ON l.id_bus = b.id_bus";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBuses()
    {
        $sql = "SELECT id_bus, nama FROM bus";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengambil laporan harian berdasarkan ID
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM laporan_harian WHERE id_laporan_harian = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Menambahkan laporan harian baru
    public function create($data)
    {
        $sql = "INSERT INTO laporan_harian (id_bus, tanggal, waktu, kondisi_teknis, 
                kondisi_kebersihan, bahan_bakar, kondisi_jalan, ketepatan_jadwal, keselamatan) 
                VALUES (:id_bus, :tanggal, :waktu, :kondisi_teknis, :kondisi_kebersihan, 
                :bahan_bakar, :kondisi_jalan, :ketepatan_jadwal, :keselamatan)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    // Mengedit laporan harian
    public function edit($id, $data)
    {
        $sql = "UPDATE laporan_harian SET id_bus = :id_bus, tanggal = :tanggal, waktu = :waktu, 
                kondisi_teknis = :kondisi_teknis, kondisi_kebersihan = :kondisi_kebersihan, 
                bahan_bakar = :bahan_bakar, kondisi_jalan = :kondisi_jalan, 
                ketepatan_jadwal = :ketepatan_jadwal, keselamatan = :keselamatan 
                WHERE id_laporan_harian = :id";
        $data['id'] = $id; // Menambahkan ID untuk keperluan update
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    // Menghapus laporan harian
    public function delete($id)
    {
        $sql = "DELETE FROM laporan_harian WHERE id_laporan_harian = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>