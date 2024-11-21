<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiket_transportasi";

// koneksi user
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connected successfully!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}

?>