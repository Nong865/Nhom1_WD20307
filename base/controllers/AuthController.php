<?php
require_once "./models/User.php";

class AuthController {

    public function showLogin() {
        require "./views/auth/login.php";
    }

    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new User();
        $user = $userModel->findByUsername($username);
        

        if (!$user) {
            die("Sai tài khoản hoặc mật khẩu!");
        }

        // kiểm tra mật khẩu bcrypt
       if ($password !== $user['password']) {
    die("Sai tài khoản hoặc mật khẩu!");
}


        $_SESSION['user'] = [
            "id" => $user['id'],
            "username" => $user['username'],
            "role_id" => $user['role_id']
        ];

        header("Location: index.php?action=listTours");
        exit;
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
    }
}