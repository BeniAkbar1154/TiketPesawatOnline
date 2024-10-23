<?php
// Auth
// if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 3) {
//     header("Location: /FinalProject/public/register/login.php");
//     exit();
// }
    
require_once __DIR__ . '/../../src/controller/FlightController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$flightController = new FlightController($pdo);
$flights = $flightController->getFlightModel()->getAllFlights();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AdminLTE 3 | Dashboard 3</title>
    <title>Flight List</title>
    <link rel="stylesheet" href="/public/adminlte/css/bootstrap.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/FinalProject/public/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
  <link rel="stylesheet" href="/FinalProject/public/adminlte/dist/css/adminlte.min.css">
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
