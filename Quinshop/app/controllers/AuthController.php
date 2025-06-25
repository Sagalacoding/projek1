<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function showLogin()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister()
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }


    public function login()
    {
        session_start();
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo "<script>alert('Email dan password harus diisi.');window.history.back();</script>";
            return;
        }

        $userModel = new User();
        $user = $userModel->login($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: ../../app/views/admin/index.php');
        } else {
            echo "<script>alert('Email atau password salah');window.history.back();</script>";
        }
    }

    public function register()
    {
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        if (empty($email) || empty($fullname) || empty($password) || empty($confirmPassword)) {
            echo "<script>alert('Email, fullname, dan password harus diisi.');window.history.back();</script>";
            return;
        }

        if ($password !== $confirmPassword) {
            echo "<script>alert('Password dan confirm password harus sama.');window.history.back();</script>";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Email tidak valid.');window.history.back();</script>";
            return;
        }

        if (preg_match('/\s/', $password)) {
            echo "<script>alert('Password tidak boleh mengandung spasi.');window.history.back();</script>";
            return;
        }

        $userModel = new User();
        $isRegistered = $userModel->register($email, $fullname, $password);

        if (!$isRegistered) {
            echo "<script>alert('Email sudah digunakan.');window.history.back();</script>";
            return;
        }

        echo "<script>alert('Registrasi berhasil! Silakan login.');window.location.href='../views/auth/login.php';</script>";
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ../../index.php');
    }
}


if (isset($_GET['action'])) {
    $auth = new AuthController();

    switch ($_GET['action']) {
        case 'login':
            $auth->login();
            break;
        case 'register':
            $auth->register();
            break;
        case 'logout':
            $auth->logout();
            break;
    }
}
