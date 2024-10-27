<?php
// File ini hanya berisi proses untuk menghapus rute dari database
require_once '../../database/db_connection.php';

$id = $_GET['id'];
$query = "DELETE FROM rute WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: rute.php?message=success_delete");
} else {
    header("Location: rute.php?message=error_delete");
}
// $stmt->close();
// $conn->close();
?>