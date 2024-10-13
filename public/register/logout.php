<?php
session_start();
session_unset(); // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi

// Arahkan pengguna kembali ke halaman login setelah logout
header("Location: /FinalProject/public/register/login.php");
exit();
?>
