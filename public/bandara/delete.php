<?php
// File ini hanya berisi proses untuk menghapus bandara dari database
require_once '../../database/db_connection.php';

$id = $_GET['id'];
$query = "DELETE FROM bandara WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);

header('Location: bandara.php');
exit;
?>
