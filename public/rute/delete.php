<?php
require_once '../../database/db_connection.php';

$id = $_GET['id'];
$query = "DELETE FROM rute WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);

header('Location: rute.php');
exit;
