<?php
// src/controller/FlightController.php
require_once __DIR__ . '/../model/FlightModel.php';

class FlightController {
    private $flightModel;

    public function __construct($pdo) {
        $this->flightModel = new Flight($pdo);
    }

    public function create() {
        $this->flightModel->createFlight($_POST['departure_time'], $_POST['arrival_time'], $_POST['origin'], $_POST['destination'], $_POST['airline_id'], $_POST['status'], $_POST['price'], $_POST['capacity']);
        header("Location: /flights/index.php");
    }

    public function update($id) {
        $this->flightModel->updateFlight($id, $_POST['departure_time'], $_POST['arrival_time'], $_POST['origin'], $_POST['destination'], $_POST['airline_id'], $_POST['status'], $_POST['price'], $_POST['capacity']);
        header("Location: /flights/index.php");
    }

    public function delete($id) {
        $this->flightModel->deleteFlight($id);
        header("Location: /flights/index.php");
    }

    // Getter untuk flightModel agar bisa diakses di luar kelas
    public function getFlightModel() {
        return $this->flightModel;
    }
}
?>
