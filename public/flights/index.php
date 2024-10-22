<?php
// public/flights/index.php
require_once __DIR__ . '/../../src/controller/FlightController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$flightController = new FlightController($pdo);
$flights = $flightController->getFlightModel()->getAllFlights();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Flight List</title>
    <link rel="stylesheet" href="/public/adminlte/css/bootstrap.min.css">
</head>
<body>
    <h2>Flight List</h2>
    <a href="create.php" class="btn btn-success">Create New Flight</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Airline</th>
                <th>Status</th>
                <th>Price</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($flights as $flight): ?>
            <tr>
                <td><?= $flight['id'] ?></td>
                <td><?= $flight['departure_time'] ?></td>
                <td><?= $flight['arrival_time'] ?></td>
                <td><?= $flight['origin'] ?></td>
                <td><?= $flight['destination'] ?></td>
                <td><?= $flight['airline_id'] ?></td>
                <td><?= $flight['status'] ?></td>
                <td><?= $flight['price'] ?></td>
                <td><?= $flight['capacity'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $flight['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $flight['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
