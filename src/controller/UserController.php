<?php
require_once __DIR__ . '/../model/UserModel.php';

class UserController
{
    private $userModel;
    private $pdo;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("PDO instance not provided.");
        }
        $this->pdo = $pdo;
        $this->userModel = new UserModel($pdo); // Inisialisasi UserModel dengan koneksi PDO
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        return $this->userModel->fetchAllUsers();
    }

    public function createUser($data)
    {
        return $this->userModel->insertUser($data);
    }

    public function getUserById($id)
    {
        return $this->userModel->fetchUserById($id);
    }

    public function updateUser($id, $data)
    {
        return $this->userModel->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userModel->deleteUser($id);
    }
}
?>