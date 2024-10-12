<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/public/adminlte/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/public/adminlte/css/bootstrap.min.css">
</head>
<body>
    <h2>Login</h2>
    <form action="../routing.php?action=login" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
        <!-- Link ke JavaScript AdminLTE -->
        <script src="/public/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/public/adminlte/js/bootstrap.bundle.min.js"></script>
    <script src="/public/adminlte/js/AdminLTE.min.js"></script>

</body>
</html>
