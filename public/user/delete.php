<?php
// Koneksi ke database
include_once('../../database/db_connection.php');

// Cek apakah ada parameter ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus user berdasarkan ID
    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman user setelah berhasil dihapus
        header("Location: user.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID user tidak ditemukan!";
}
?>
