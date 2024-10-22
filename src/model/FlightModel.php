<?php
// src/model/FlightModel.php
require_once __DIR__ . '/../../database/db_connection.php';

class Flight {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create (Menambahkan penerbangan baru)
    public function createFlight($departure_time, $arrival_time, $origin, $destination, $airline_id, $status, $price, $capacity) {
        $sql = "INSERT INTO flights (departure_time, arrival_time, origin, destination, airline_id, status, price, capacity) 
                VALUES (:departure_time, :arrival_time, :origin, :destination, :airline_id, :status, :price, :capacity)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'origin' => $origin,
            'destination' => $destination,
            'airline_id' => $airline_id,
            'status' => $status,
            'price' => $price,
            'capacity' => $capacity
        ]);
    }

    // Read (Mendapatkan semua penerbangan)
    public function getAllFlights() {
        $stmt = $this->pdo->query("SELECT * FROM flights");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update (Mengubah data penerbangan)
    public function updateFlight($id, $departure_time, $arrival_time, $origin, $destination, $airline_id, $status, $price, $capacity) {
        $sql = "UPDATE flights SET departure_time = ?, arrival_time = ?, origin = ?, destination = ?, airline_id = ?, status = ?, price = ?, capacity = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$departure_time, $arrival_time, $origin, $destination, $airline_id, $status, $price, $capacity, $id]);
    }

    // Delete (Menghapus penerbangan)
    public function deleteFlight($id) {
        $stmt = $this->pdo->prepare("DELETE FROM flights WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Mendapatkan penerbangan berdasarkan ID
    public function getFlightById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM flights WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
