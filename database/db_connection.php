<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiket_transportasi";

// koneksi user
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Mengatur mode error PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully!";
} catch (PDOException $e) {
    // Menampilkan pesan error jika koneksi gagal
    echo "Database connection failed: " . $e->getMessage();
}

?>