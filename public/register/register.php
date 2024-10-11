<!-- public/register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
    <h2>Register User</h2>
    <form action="../routing.php?action=register" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="level">Level:</label>
    <select id="level" name="level" required>
        <option value="1">Pengguna</option>
        <option value="2">Petugas</option>
        <option value="3">Admin</option>
    </select><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
