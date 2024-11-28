<?php
require_once __DIR__ . '/../../database/db_connection.php';

class AuthController
{
    private $pdo;

    public function __construct()
    {
        global $pdo; // Gunakan variabel global PDO dari koneksi database
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (username, email, password, level) VALUES (:username, :email, :password, 'customer')";
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
        ]);
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
