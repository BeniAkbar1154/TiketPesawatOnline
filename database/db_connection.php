<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

// koneksi user
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
