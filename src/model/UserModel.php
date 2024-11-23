<?php
require_once __DIR__ . '/../../database/db_connection.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function fetchAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertUser($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user (username, email, password, level) 
            VALUES (:username, :email, :password, :level)
        ");
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':level' => $data['level']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function fetchUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id_user = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE user 
            SET username = :username, email = :email, level = :level 
            WHERE id_user = :id
        ");
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':level' => $data['level'],
            ':id' => $id
        ]);
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id_user = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>