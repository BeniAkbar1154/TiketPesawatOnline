<?php
$servername = "mysql_db";
$username = "root";
$password = "root";
$dbname = "tiketpesawat";

// koneksi user
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>