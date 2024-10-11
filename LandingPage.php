<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();

    if ($_SESSION['user_level'] == 3) {
        echo "<h1>Ini halaman admin</h1>";
    } elseif ($_SESSION['user_level'] == 2) {
        echo "<h1>Ini halaman petugas</h1>";
    } else {
        echo "<h1>Ini halaman pengguna biasa</h1>";
    }
    ?>
</body>
</html>
