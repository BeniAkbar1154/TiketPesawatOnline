<?php
// src/controller/UserController.php
require_once __DIR__ . '/../model/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->register($username, $email, $password)) {
                header('Location: /success.php');
            } else {
                echo "Failed to register user.";
            }
        }
    }

    public function listUsers() {
        return $this->userModel->getAllUsers();
    }

    public function deleteUser($id) {
        $this->userModel->deleteUser($id);
    }

    public function editUser($id, $username, $email, $password) {
        $this->userModel->updateUser($id, $username, $email, $password);
    }
}
?>
