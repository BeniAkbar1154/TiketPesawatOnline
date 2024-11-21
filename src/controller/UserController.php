<?php

require_once __DIR__ . '/../../database/db_connection.php';
require_once __DIR__ . '/../model/UserModel.php';

class UserController
{
    private $pdo;
    private $userModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo); // Inisialisasi model
    }

    // Fungsi untuk mengambil semua user
    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    // Fungsi untuk mengambil user berdasarkan ID
    public function getUserById($id)
    {
        return $this->userModel->getUserById($id);
    }

    // Fungsi untuk menambahkan user baru
    public function createUser($data)
    {
        return $this->userModel->createUser($data);
    }

    // Fungsi untuk memperbarui user
    public function updateUser($id, $data)
    {
        return $this->userModel->updateUser($id, $data);
    }

    // Fungsi untuk menghapus user
    public function deleteUser($id)
    {
        return $this->userModel->deleteUser($id);
    }
}
