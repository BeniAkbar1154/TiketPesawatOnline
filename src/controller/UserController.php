<?php
require_once __DIR__ . '/../model/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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