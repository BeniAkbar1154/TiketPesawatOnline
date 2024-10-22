<?php
// public/flights/create.php
require_once __DIR__ . '/../../src/controller/FlightController.php';
require_once __DIR__ . '/../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flightController = new FlightController($pdo);
    $flightController->create();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Flight</title>
    <link rel="stylesheet" href="/public/adminlte/css/bootstrap.min.css">
</head>
<body>
    <h2>Create Flight</h2>
    <form action="create.php" method="POST">
        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" name="departure_time" required><br>

        <label for="arrival_time">Arrival Time:</label>
        <input type="datetime-local" name="arrival_time" required><br>

        <label for="origin">Origin:</label>
        <input type="text" name="origin" required><br>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" required><br>

        <label for="airline_id">Airline ID:</label>
        <input type="number" name="airline_id" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" required><br>

        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" required><br>

        <button type="submit" class="btn btn-primary">Create Flight</button>
    </form>
</body>
</html>
