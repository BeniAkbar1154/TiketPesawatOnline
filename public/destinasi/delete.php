<?php
require_once '../../database/db_connection.php';

$id = $_GET['id'];
$query = "DELETE FROM destinasi WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);

header('Location: destinasi.php');
exit;
?>
