<?php
require_once __DIR__ . '/../model/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("PDO instance not provided.");
        }
        $this->userModel = new UserModel($pdo);
    }

    public function getAllUsers()
    {
        return $this->userModel->fetchAllUsers();
    }

    public function createUser($data)
    {
        try {
            return $this->userModel->insertUser($data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
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