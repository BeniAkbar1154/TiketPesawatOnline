<?php
// public/flights/edit.php
require_once __DIR__ . '/../../src/controller/FlightController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$flightController = new FlightController($pdo);

// Cek apakah ada ID di query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $flight = $flightController->getFlightModel()->getFlightById($id);

    if (!$flight) {
        echo "Flight not found!";
        exit;
    }
} else {
    echo "No flight ID provided!";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flightController->update($id);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Flight</title>
    <link rel="stylesheet" href="/public/adminlte/css/bootstrap.min.css">
</head>
<body>
    <h2>Edit Flight</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="departure_time">Departure Time</label>
            <input type="datetime-local" id="departure_time" name="departure_time" class="form-control" value="<?= $flight['departure_time'] ?>" required>
        </div>
        <div class="form-group">
            <label for="arrival_time">Arrival Time</label>
            <input type="datetime-local" id="arrival_time" name="arrival_time" class="form-control" value="<?= $flight['arrival_time'] ?>" required>
        </div>
        <div class="form-group">
            <label for="origin">Origin</label>
            <input type="text" id="origin" name="origin" class="form-control" value="<?= $flight['origin'] ?>" required>
        </div>
        <div class="form-group">
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" class="form-control" value="<?= $flight['destination'] ?>" required>
        </div>
        <div class="form-group">
            <label for="airline_id">Airline ID</label>
            <input type="text" id="airline_id" name="airline_id" class="form-control" value="<?= $flight['airline_id'] ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" id="status" name="status" class="form-control" value="<?= $flight['status'] ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" value="<?= $flight['price'] ?>" required>
        </div>
        <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" class="form-control" value="<?= $flight['capacity'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Flight</button>
    </form>
</body>
</html>
