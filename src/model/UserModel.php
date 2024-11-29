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
        // Hanya pilih kolom yang dibutuhkan
        $stmt = $this->pdo->prepare("SELECT id_user, username, email, level FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id_user, username, email, level FROM user WHERE id_user = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($data)
    {
        // Pastikan password di-hash sebelum dimasukkan
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, level) VALUES (:username, :email, :password, :level)");
        $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':level', $data['level'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateUser($id, $data)
    {
        // Jika ada pembaruan password, pastikan di-hash
        $hashedPassword = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null;

        $stmt = $this->pdo->prepare(
            "UPDATE user 
             SET username = :username, 
                 email = :email, 
                 password = COALESCE(:password, password), 
                 level = :level 
             WHERE id_user = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':level', $data['level'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id_user = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>