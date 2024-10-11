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
            $level = $_POST['level'];
    
            if ($this->userModel->register($username, $email, $password, $level)) {
                header('Location: /success.php');
            } else {
                echo "Registrasi Gagal.";
            }
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_level'] = $user['level']; // level 3 = admin, level 2 = petugas, level 1 = pengguna biasa

                // Redirect ke LandingPage.php
                header('Location: ../LandingPage.php');
                exit();
            } else {
                echo "Login failed. Invalid email or password.";
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
