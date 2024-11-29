<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id_user = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, level) VALUES (:username, :email, :password, :level)");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':level', $data['level']);
        return $stmt->execute();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE user SET username = :username, email = :email, password = :password, level = :level WHERE id_user = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':level', $data['level']);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id_user = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>