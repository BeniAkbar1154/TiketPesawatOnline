<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fungsi untuk mengambil semua user
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Fungsi untuk mengambil user berdasarkan ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Fungsi untuk menambahkan user baru
    public function createUser($data)
    {
        $sql = "INSERT INTO user (nama, email, password, no_telepon, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt->execute([
            $data['nama'],
            $data['email'],
            $passwordHash,
            $data['no_telepon'],
            $data['role']
        ]);
    }

    // Fungsi untuk memperbarui user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE user SET nama = ?, email = ?, no_telepon = ?, role = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['nama'],
            $data['email'],
            $data['no_telepon'],
            $data['role'],
            $id
        ]);
    }

    // Fungsi untuk menghapus user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}
